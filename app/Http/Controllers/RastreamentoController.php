<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AuditService;

class RastreamentoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Buscar denúncias do usuário logado
        $denuncias = Denuncia::where('email_denunciante', $user->email)
            ->orWhere('nome_denunciante', $user->name)
            ->with(['categoria', 'status', 'responsavel'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Estatísticas
        $totalDenuncias = $denuncias->total();
        $denunciasEmAnalise = $denuncias->where('status.nome', 'Em Análise')->count();
        $denunciasConcluidas = $denuncias->where('status.nome', 'Concluída')->count();
        $denunciasUrgentes = $denuncias->where('urgente', true)->count();
        
        return view('rastreamento.index', compact(
            'denuncias', 
            'totalDenuncias', 
            'denunciasEmAnalise', 
            'denunciasConcluidas', 
            'denunciasUrgentes'
        ));
    }
    
    public function show($protocolo)
    {
        $user = Auth::user();
        
        // Buscar denúncia pelo protocolo (apenas se pertencer ao usuário)
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->where(function($query) use ($user) {
                $query->where('email_denunciante', $user->email)
                      ->orWhere('nome_denunciante', $user->name);
            })
            ->with(['categoria', 'status', 'responsavel', 'comentarios.user', 'comentarios.replies.user', 'evidencias'])
            ->firstOrFail();
        
        // Buscar histórico de status
        $historicoStatus = Status::orderBy('ordem')->get();
        
        return view('rastreamento.show', compact('denuncia', 'historicoStatus'));
    }
    
    public function buscar(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string|max:20'
        ]);
        
        $protocolo = $request->protocolo;
        
        // Buscar denúncia pelo protocolo
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->with(['categoria', 'status', 'responsavel'])
            ->first();
        
        if (!$denuncia) {
            return back()->with('error', 'Denúncia não encontrada. Verifique o protocolo informado.');
        }
        
        // Verificar se o usuário tem acesso a esta denúncia
        $user = Auth::user();
        if ($denuncia->email_denunciante !== $user->email && $denuncia->nome_denunciante !== $user->name) {
            return back()->with('error', 'Você não tem permissão para visualizar esta denúncia.');
        }
        
        return redirect()->route('rastreamento.show', $denuncia->protocolo);
    }
    
    public function apiStatus($protocolo)
    {
        $user = Auth::user();
        
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->where(function($query) use ($user) {
                $query->where('email_denunciante', $user->email)
                      ->orWhere('nome_denunciante', $user->name);
            })
            ->with(['categoria', 'status', 'responsavel'])
            ->first();
        
        if (!$denuncia) {
            return response()->json(['error' => 'Denúncia não encontrada'], 404);
        }
        
        return response()->json([
            'protocolo' => $denuncia->protocolo,
            'titulo' => $denuncia->titulo,
            'status' => $denuncia->status->nome,
            'status_cor' => $denuncia->status->cor,
            'categoria' => $denuncia->categoria->nome,
            'data_criacao' => $denuncia->created_at->format('d/m/Y H:i'),
            'ultima_atualizacao' => $denuncia->updated_at->format('d/m/Y H:i'),
            'responsavel' => $denuncia->responsavel ? $denuncia->responsavel->name : 'Não atribuído',
            'urgente' => $denuncia->urgente,
            'prioridade' => $denuncia->prioridade_label
        ]);
    }
    
    /**
     * Exibe o formulário de rastreamento público de denúncias
     */
    public function publico(Request $request)
    {
        $protocolo = $request->query('protocolo');
        return view('rastreamento.publico', compact('protocolo'));
    }

    /**
     * Processa a busca de uma denúncia pelo protocolo (público)
     */
    public function publicoBuscar(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string|max:50',
        ]);

        $protocolo = $request->protocolo;
        
        // Buscar denúncia pelo protocolo
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->with(['categoria', 'status', 'comentarios' => function($query) {
                $query->where('publico', true)
                      ->orWhere('tipo', 'mensagem')
                      ->with(['user', 'replies' => function($q) {
                          $q->where('publico', true);
                      }]);
            }, 'evidencias' => function($query) {
                $query->where('publico', true);
            }])
            ->first();

        if (!$denuncia) {
            return back()->with('error', 'Nenhuma denúncia encontrada com o protocolo informado.');
        }

        // Registrar auditoria de consulta
        AuditService::logRastreamento($denuncia, $request->ip(), $request->userAgent());

        return view('rastreamento.publico-resultado', compact('denuncia'));
    }

    /**
     * Exibe o resultado do rastreamento público de denúncias por protocolo
     */
    public function publicoResultado($protocolo)
    {
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->with(['categoria', 'status', 'comentarios' => function($query) {
                $query->where('publico', true)
                      ->orWhere('tipo', 'mensagem')
                      ->with(['user', 'replies' => function($q) {
                          $q->where('publico', true);
                      }]);
            }, 'evidencias' => function($query) {
                $query->where('publico', true);
            }])
            ->firstOrFail();

        return view('rastreamento.publico-resultado', compact('denuncia'));
    }

    /**
     * Gera um PDF com os detalhes da denúncia (público)
     */
    public function downloadPDF($protocolo)
    {
        $denuncia = Denuncia::where('protocolo', $protocolo)
            ->with(['categoria', 'status', 'comentarios' => function($query) {
                $query->where('publico', true)
                      ->orWhere('tipo', 'mensagem')
                      ->with(['user', 'replies' => function($q) {
                          $q->where('publico', true);
                      }]);
            }, 'evidencias' => function($query) {
                $query->where('publico', true);
            }])
            ->firstOrFail();

        // Registrar auditoria de download
        AuditService::logDownloadPDF($denuncia, request()->ip(), request()->userAgent());

        $pdf = PDF::loadView('rastreamento.pdf-publico', compact('denuncia'));
        
        return $pdf->download("denuncia-{$denuncia->protocolo}.pdf");
    }
}
