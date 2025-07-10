<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Denuncia::with(['categoria', 'status', 'responsavel']);

        // Filtros
        if ($request->filled('status')) {
            $query->porStatus($request->status);
        }

        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('prioridade')) {
            $query->porPrioridade($request->prioridade);
        }

        if ($request->filled('responsavel')) {
            $query->porResponsavel($request->responsavel);
        }

        if ($request->filled('tipo_denuncia')) {
            if ($request->tipo_denuncia === 'anonima') {
                $query->where(function($q) {
                    $q->whereNull('nome_denunciante')
                      ->orWhere('nome_denunciante', '')
                      ->orWhereNull('email_denunciante')
                      ->orWhere('email_denunciante', '');
                });
            } elseif ($request->tipo_denuncia === 'identificada') {
                $query->whereNotNull('nome_denunciante')
                      ->where('nome_denunciante', '!=', '')
                      ->whereNotNull('email_denunciante')
                      ->where('email_denunciante', '!=', '');
            }
        }

        if ($request->filled('urgente')) {
            $query->urgentes();
        }

        if ($request->filled('atrasadas')) {
            $query->atrasadas();
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('protocolo', 'like', "%{$busca}%")
                  ->orWhere('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('nome_denunciante', 'like', "%{$busca}%");
            });
        }

        // Se não for admin, mostrar apenas denúncias do responsável
        if (!Auth::user()->podeVerTodasDenuncias()) {
            $query->porResponsavel(Auth::id());
        }

        // Ordenação
        $ordenacao = $request->get('ordenacao', 'created_at');
        $direcao = $request->get('direcao', 'desc');
        $query->orderBy($ordenacao, $direcao);

        $denuncias = $query->paginate(15);

        // Dados para filtros
        $categorias = Categoria::ativas()->ordenadas()->get();
        $status = Status::ativos()->ordenados()->get();
        $responsaveis = User::responsaveis()->ativos()->get();

        return view('denuncias.index', compact('denuncias', 'categorias', 'status', 'responsaveis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::ativas()->ordenadas()->get();
        $status = Status::ativos()->ordenados()->get();
        $responsaveis = User::responsaveis()->ativos()->get();

        return view('denuncias.create', compact('categorias', 'status', 'responsaveis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:200',
            'descricao' => 'required|string',
            'local_ocorrencia' => 'nullable|string',
            'data_ocorrencia' => 'nullable|date',
            'hora_ocorrencia' => 'nullable|date_format:H:i',
            'nome_denunciante' => 'nullable|string|max:100',
            'email_denunciante' => 'nullable|email|max:100',
            'telefone_denunciante' => [
                'nullable',
                'regex:/^(\\+244\\s?)?9\\d{2}\\s?\\d{3}\\s?\\d{3}$/'
            ],
            'departamento_denunciante' => 'nullable|string|max:100',
            'envolvidos' => 'nullable|string',
            'testemunhas' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta,critica',
            'urgente' => 'boolean',
            'responsavel_id' => 'nullable|exists:users,id',
            'data_limite' => 'nullable|date|after:today',
            'observacoes_internas' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $denuncia = Denuncia::create([
                'categoria_id' => $request->categoria_id,
                'status_id' => Status::where('nome', 'Recebida')->first()->id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'local_ocorrencia' => $request->local_ocorrencia,
                'data_ocorrencia' => $request->data_ocorrencia,
                'hora_ocorrencia' => $request->hora_ocorrencia,
                'nome_denunciante' => $request->nome_denunciante,
                'email_denunciante' => $request->email_denunciante,
                'telefone_denunciante' => $request->telefone_denunciante,
                'departamento_denunciante' => $request->departamento_denunciante,
                'envolvidos' => $request->envolvidos,
                'testemunhas' => $request->testemunhas,
                'prioridade' => $request->prioridade,
                'urgente' => $request->boolean('urgente'),
                'responsavel_id' => $request->responsavel_id,
                'data_limite' => $request->data_limite,
                'observacoes_internas' => $request->observacoes_internas,
                'ip_denunciante' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Adicionar comentário inicial se houver observações
            if ($request->observacoes_internas) {
                $denuncia->adicionarComentario(
                    "Observações iniciais: " . $request->observacoes_internas,
                    Auth::id(),
                    'interno'
                );
            }

            DB::commit();

            // Notificar admins e moderadores sobre nova denúncia
            NotificationService::notificarNovaDenuncia($denuncia);

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Denúncia criada com sucesso! Protocolo: ' . $denuncia->protocolo);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro ao criar denúncia: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $denuncia->load(['categoria', 'status', 'responsavel', 'evidencias', 'comentarios.user']);

        $statusDisponiveis = Status::ativos()->ordenados()->get();
        $responsaveis = User::responsaveis()->ativos()->get();

        return view('denuncias.show', compact('denuncia', 'statusDisponiveis', 'responsaveis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if (!$denuncia->podeSerEditada()) {
            return redirect()->route('denuncias.show', $denuncia)
                           ->with('error', 'Esta denúncia não pode ser editada.');
        }

        $denuncia->load(['categoria', 'status', 'responsavel']);
        $categorias = Categoria::ativas()->ordenadas()->get();
        $status = Status::ativos()->ordenados()->get();
        $responsaveis = User::responsaveis()->ativos()->get();

        return view('denuncias.edit', compact('denuncia', 'categorias', 'status', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if (!$denuncia->podeSerEditada()) {
            return redirect()->route('denuncias.show', $denuncia)
                           ->with('error', 'Esta denúncia não pode ser editada.');
        }

        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:200',
            'descricao' => 'required|string',
            'local_ocorrencia' => 'nullable|string',
            'data_ocorrencia' => 'nullable|date',
            'hora_ocorrencia' => 'nullable|date_format:H:i',
            'nome_denunciante' => 'nullable|string|max:100',
            'email_denunciante' => 'nullable|email|max:100',
            'telefone_denunciante' => [
                'nullable',
                'regex:/^(\\+244\\s?)?9\\d{2}\\s?\\d{3}\\s?\\d{3}$/'
            ],
            'departamento_denunciante' => 'nullable|string|max:100',
            'envolvidos' => 'nullable|string',
            'testemunhas' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta,critica',
            'urgente' => 'boolean',
            'responsavel_id' => 'nullable|exists:users,id',
            'data_limite' => 'nullable|date',
            'observacoes_internas' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $denuncia->update([
                'categoria_id' => $request->categoria_id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'local_ocorrencia' => $request->local_ocorrencia,
                'data_ocorrencia' => $request->data_ocorrencia,
                'hora_ocorrencia' => $request->hora_ocorrencia,
                'nome_denunciante' => $request->nome_denunciante,
                'email_denunciante' => $request->email_denunciante,
                'telefone_denunciante' => $request->telefone_denunciante,
                'departamento_denunciante' => $request->departamento_denunciante,
                'envolvidos' => $request->envolvidos,
                'testemunhas' => $request->testemunhas,
                'prioridade' => $request->prioridade,
                'urgente' => $request->boolean('urgente'),
                'responsavel_id' => $request->responsavel_id,
                'data_limite' => $request->data_limite,
                'observacoes_internas' => $request->observacoes_internas,
            ]);

            // Adicionar comentário sobre a edição
            $denuncia->adicionarComentario(
                "Denúncia editada por " . Auth::user()->name,
                Auth::id(),
                'interno'
            );

            DB::commit();

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Denúncia atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro ao atualizar denúncia: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if (!$denuncia->podeSerExcluida()) {
            return redirect()->route('denuncias.show', $denuncia)
                           ->with('error', 'Esta denúncia não pode ser excluída.');
        }

        try {
            $denuncia->delete();
            return redirect()->route('denuncias.index')
                           ->with('success', 'Denúncia excluída com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir denúncia: ' . $e->getMessage());
        }
    }

    /**
     * Alterar status da denúncia
     */
    public function alterarStatus(Request $request, Denuncia $denuncia)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'comentario' => 'nullable|string'
        ]);

        try {
            $statusAnterior = $denuncia->status_id;
            $denuncia->alterarStatus($request->status_id, Auth::id(), $request->comentario);

            // Verificar se a denúncia foi finalizada (status "Resolvida")
            $statusResolvida = Status::where('nome', 'Resolvida')->first();
            if ($statusResolvida && $request->status_id == $statusResolvida->id && $statusAnterior != $statusResolvida->id) {
                NotificationService::notificarDenunciaFinalizada($denuncia);
            }

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Status alterado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    /**
     * Atribuir responsável
     */
    public function atribuirResponsavel(Request $request, Denuncia $denuncia)
    {
        $request->validate([
            'responsavel_id' => 'required|exists:users,id',
            'comentario' => 'nullable|string'
        ]);

        try {
            $denuncia->atribuirResponsavel($request->responsavel_id, Auth::id(), $request->comentario);

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Responsável atribuído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atribuir responsável: ' . $e->getMessage());
        }
    }

    /**
     * Formulário de denúncia anônima (público)
     */
    public function formularioPublico()
    {
        $categorias = Categoria::ativas()->ordenadas()->get();
        return view('denuncias.formulario-publico', compact('categorias'));
    }

    /**
     * Salvar denúncia pública
     */
    public function salvarPublica(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:200',
            'descricao' => 'required|string',
            'local_ocorrencia' => 'nullable|string',
            'data_ocorrencia' => 'nullable|date',
            'hora_ocorrencia' => 'nullable|date_format:H:i',
            'nome_denunciante' => 'nullable|string|max:100',
            'email_denunciante' => 'nullable|email|max:100',
            'telefone_denunciante' => 'nullable|string|max:20',
            'departamento_denunciante' => 'nullable|string|max:100',
            'envolvidos' => 'nullable|string',
            'testemunhas' => 'nullable|string',
            'prioridade' => 'required|in:baixa,media,alta,critica',
            'comprovativos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120', // 5MB por arquivo
            'descricao_comprovativos' => 'nullable|string',
            'tipo_denuncia' => 'required|in:anonima,identificada',
            'termos' => 'required|accepted',
        ]);

        try {
            DB::beginTransaction();

            // Determinar se é anônima baseado na escolha do usuário
            $isAnonima = $request->tipo_denuncia === 'anonima';
            
            // Se for identificada, validar campos obrigatórios
            if (!$isAnonima) {
                $request->validate([
                    'nome_denunciante' => 'required|string|max:100',
                    'email_denunciante' => 'required|email|max:100',
                ]);
            }

            $denuncia = Denuncia::create([
                'categoria_id' => $request->categoria_id,
                'status_id' => Status::where('nome', 'Recebida')->first()->id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'local_ocorrencia' => $request->local_ocorrencia,
                'data_ocorrencia' => $request->data_ocorrencia,
                'hora_ocorrencia' => $request->hora_ocorrencia,
                'nome_denunciante' => $isAnonima ? null : $request->nome_denunciante,
                'email_denunciante' => $isAnonima ? null : $request->email_denunciante,
                'telefone_denunciante' => $isAnonima ? null : $request->telefone_denunciante,
                'departamento_denunciante' => $isAnonima ? null : $request->departamento_denunciante,
                'envolvidos' => $request->envolvidos,
                'testemunhas' => $request->testemunhas,
                'prioridade' => $request->prioridade,
                'urgente' => false,
                'ip_denunciante' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Garante que o protocolo foi gerado
            if (empty($denuncia->protocolo)) {
                $denuncia->protocolo = $denuncia->gerarProtocolo();
                $denuncia->save();
            }

            // Processar comprovativos enviados
            if ($request->hasFile('comprovativos')) {
                $comprovativos = $request->file('comprovativos');
                
                foreach ($comprovativos as $comprovativo) {
                    if ($comprovativo->isValid()) {
                        // Gerar nome único para o arquivo
                        $nomeArquivo = time() . '_' . uniqid() . '.' . $comprovativo->getClientOriginalExtension();
                        
                        // Salvar arquivo
                        $caminho = $comprovativo->storeAs('comprovativos', $nomeArquivo, 'public');
                        
                        // Criar registro de evidência
                        $denuncia->evidencias()->create([
                            'user_id' => User::where('email', 'anonymous@system.com')->first()->id ?? 1, // Usuário anônimo
                            'nome_original' => $comprovativo->getClientOriginalName(),
                            'nome_arquivo' => $nomeArquivo,
                            'caminho' => $caminho,
                            'tipo_mime' => $comprovativo->getClientMimeType(),
                            'tamanho' => $comprovativo->getSize(),
                            'extensao' => $comprovativo->getClientOriginalExtension(),
                            'descricao' => 'Comprovativo enviado pelo denunciante',
                            'publico' => false, // Comprovativos são privados por padrão
                        ]);
                    }
                }
                
                // Adicionar comentário sobre os comprovativos
                $totalComprovativos = count($request->file('comprovativos'));
                $comentario = "Denúncia enviada com {$totalComprovativos} comprovativo(s)";
                
                if ($request->descricao_comprovativos) {
                    $comentario .= ". Descrição: " . $request->descricao_comprovativos;
                }
                
                $denuncia->adicionarComentario(
                    $comentario,
                    User::where('email', 'anonymous@system.com')->first()->id ?? 1,
                    'interno'
                );
            }

            // Adicionar comentário sobre o tipo de denúncia
            $tipoComentario = $isAnonima 
                ? "Denúncia anônima enviada" 
                : "Denúncia identificada enviada por: {$request->nome_denunciante} ({$request->email_denunciante})";
            
            $denuncia->adicionarComentario(
                $tipoComentario,
                User::where('email', 'anonymous@system.com')->first()->id ?? 1,
                'interno'
            );

            DB::commit();

            // Notificar admins e moderadores sobre nova denúncia
            NotificationService::notificarNovaDenuncia($denuncia);

            return view('denuncias.confirmacao', compact('denuncia'))
                           ->with('success', 'Denúncia enviada com sucesso! Protocolo: ' . $denuncia->protocolo);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Erro ao enviar denúncia: ' . $e->getMessage());
        }
    }
}
