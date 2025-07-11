<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DenunciaController extends Controller
{
    /**
     * Exibe o formulário público de denúncias.
     */
    public function formularioPublico()
    {
        $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();
        return view('denuncias.formulario-publico', compact('categorias'));
    }

    /**
     * Salva uma denúncia enviada pelo formulário público.
     */
    public function salvarPublica(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'prioridade' => 'required|in:baixa,media,alta,critica',
            'nome_denunciante' => 'nullable|string|max:255',
            'email_denunciante' => 'nullable|email|max:255',
            'telefone_denunciante' => 'nullable|string|max:20',
            'local_ocorrencia' => 'required|string|max:500',
            'data_ocorrencia' => 'required|date',
            'evidencias.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        try {
            DB::beginTransaction();

            // Criar a denúncia (protocolo temporário)
            $denuncia = new Denuncia([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'categoria_id' => $request->categoria_id,
                'status_id' => 1, // Status inicial (Aberto)
                'prioridade' => $request->prioridade,
                'protocolo' => '', // será atualizado após salvar
                'nome_denunciante' => $request->nome_denunciante,
                'email_denunciante' => $request->email_denunciante,
                'telefone_denunciante' => $request->telefone_denunciante,
                'local_ocorrencia' => $request->local_ocorrencia,
                'data_ocorrencia' => $request->data_ocorrencia,
                'ip_denunciante' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $denuncia->save();

            // Gerar protocolo no formato AAAA-MM-DD-XXXXXX
            $data = $denuncia->created_at ?? now();
            $protocolo = $data->format('Y-m-d') . '-' . str_pad($denuncia->id, 6, '0', STR_PAD_LEFT);
            $denuncia->protocolo = $protocolo;
            $denuncia->save();

            // Processar anexos
            if ($request->hasFile('evidencias')) {
                foreach ($request->file('evidencias') as $file) {
                    $path = $file->store('evidencias', 'public');
                    
                    $denuncia->evidencias()->create([
                        'nome_arquivo' => $file->getClientOriginalName(),
                        'caminho_arquivo' => $path,
                        'tipo_mime' => $file->getClientMimeType(),
                        'tamanho' => $file->getSize(),
                        'publico' => false,
                    ]);
                }
            }

            // Registrar auditoria
            AuditService::logCreated($denuncia, 'Denúncia criada através do formulário público');

            // Notificar administradores
            NotificationService::notificarNovaDenuncia($denuncia);

            DB::commit();

            return redirect()->route('rastreamento.publico.resultado', ['protocolo' => $protocolo]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao salvar denúncia pública: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()->withInput()->withErrors([
                'error' => 'Ocorreu um erro ao processar sua denúncia. Por favor, tente novamente mais tarde.'
            ]);
        }
    }
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
}
