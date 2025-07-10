<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Categoria;
use App\Models\Status;
use App\Models\User;
use App\Services\DashboardMetricsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DenunciaController extends Controller
{
    protected $metricsService;

    public function __construct(DashboardMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    /**
     * Listar denúncias com filtros
     */
    public function index(Request $request): JsonResponse
    {
        try {
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
                      ->orWhere('descricao', 'like', "%{$busca}%");
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

            // Paginação
            $perPage = $request->get('per_page', 15);
            $denuncias = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $denuncias->items(),
                'pagination' => [
                    'current_page' => $denuncias->currentPage(),
                    'last_page' => $denuncias->lastPage(),
                    'per_page' => $denuncias->perPage(),
                    'total' => $denuncias->total(),
                    'from' => $denuncias->firstItem(),
                    'to' => $denuncias->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar denúncias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar denúncia específica
     */
    public function show(Denuncia $denuncia): JsonResponse
    {
        try {
            // Verificar permissão
            if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acesso negado.'
                ], 403);
            }

            $denuncia->load(['categoria', 'status', 'responsavel', 'evidencias', 'comentarios.user', 'historicoStatus.statusAnterior', 'historicoStatus.statusNovo', 'historicoStatus.user']);

            return response()->json([
                'success' => true,
                'data' => $denuncia
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar denúncia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Criar nova denúncia
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'categoria_id' => 'required|exists:categorias,id',
                'titulo' => 'required|string|max:200',
                'descricao' => 'required|string',
                'local_ocorrencia' => 'nullable|string',
                'data_ocorrencia' => 'nullable|date',
                'hora_ocorrencia' => 'nullable|date_format:H:i',
                'nome_denunciante' => 'nullable|string|max:100',
                'email_denunciante' => 'nullable|email|max:100',
                'envolvidos' => 'nullable|string',
                'testemunhas' => 'nullable|string',
                'prioridade' => 'required|in:baixa,media,alta,critica',
                'urgente' => 'boolean',
                'responsavel_id' => 'nullable|exists:users,id',
                'data_limite' => 'nullable|date|after:today',
                'observacoes_internas' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

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
                'envolvidos' => $request->envolvidos,
                'testemunhas' => $request->testemunhas,
                'prioridade' => $request->prioridade,
                'urgente' => $request->boolean('urgente'),
                'responsavel_id' => $request->responsavel_id,
                'data_limite' => $request->data_limite,
                'observacoes_internas' => $request->observacoes_internas,
            ]);

            $denuncia->load(['categoria', 'status', 'responsavel']);

            return response()->json([
                'success' => true,
                'message' => 'Denúncia criada com sucesso',
                'data' => $denuncia
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar denúncia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar denúncia
     */
    public function update(Request $request, Denuncia $denuncia): JsonResponse
    {
        try {
            // Verificar permissão
            if (!Auth::user()->podeVerTodasDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acesso negado.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'categoria_id' => 'sometimes|exists:categorias,id',
                'titulo' => 'sometimes|string|max:200',
                'descricao' => 'sometimes|string',
                'local_ocorrencia' => 'nullable|string',
                'data_ocorrencia' => 'nullable|date',
                'hora_ocorrencia' => 'nullable|date_format:H:i',
                'envolvidos' => 'nullable|string',
                'testemunhas' => 'nullable|string',
                'prioridade' => 'sometimes|in:baixa,media,alta,critica',
                'urgente' => 'boolean',
                'responsavel_id' => 'nullable|exists:users,id',
                'data_limite' => 'nullable|date',
                'observacoes_internas' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $denuncia->update($request->only([
                'categoria_id', 'titulo', 'descricao', 'local_ocorrencia',
                'data_ocorrencia', 'hora_ocorrencia', 'envolvidos', 'testemunhas',
                'prioridade', 'urgente', 'responsavel_id', 'data_limite', 'observacoes_internas'
            ]));

            $denuncia->load(['categoria', 'status', 'responsavel']);

            return response()->json([
                'success' => true,
                'message' => 'Denúncia atualizada com sucesso',
                'data' => $denuncia
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar denúncia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alterar status da denúncia
     */
    public function alterarStatus(Request $request, Denuncia $denuncia): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'status_id' => 'required|exists:status,id',
                'comentario' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $denuncia->alterarStatus($request->status_id, Auth::id(), $request->comentario);

            return response()->json([
                'success' => true,
                'message' => 'Status alterado com sucesso',
                'data' => $denuncia->fresh(['status', 'historicoStatus.statusNovo', 'historicoStatus.user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter métricas do dashboard
     */
    public function metrics(): JsonResponse
    {
        try {
            $metrics = $this->metricsService->getGeneralMetrics();
            $statusMetrics = $this->metricsService->getStatusMetrics();
            $responsavelMetrics = $this->metricsService->getResponsavelMetrics();
            $alertsAndRecommendations = $this->metricsService->getAlertsAndRecommendations();
            $trends = $this->metricsService->getTrends();

            return response()->json([
                'success' => true,
                'data' => [
                    'general_metrics' => $metrics,
                    'status_metrics' => $statusMetrics,
                    'responsavel_metrics' => $responsavelMetrics,
                    'alerts_and_recommendations' => $alertsAndRecommendations,
                    'trends' => $trends
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar métricas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter dados para filtros
     */
    public function filters(): JsonResponse
    {
        try {
            $categorias = Categoria::ativas()->ordenadas()->get();
            $status = Status::ativos()->ordenados()->get();
            $responsaveis = User::responsaveis()->ativos()->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'categorias' => $categorias,
                    'status' => $status,
                    'responsaveis' => $responsaveis
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar filtros: ' . $e->getMessage()
            ], 500);
        }
    }
}
