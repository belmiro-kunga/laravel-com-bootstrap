<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        $categorias = Categoria::withCount('denuncias')
                              ->ordenadas()
                              ->paginate(15);

        // Log para depuração
        \Log::info('Categorias carregadas:', [
            'total' => $categorias->total(),
            'denuncias_count' => $categorias->map(function($categoria) {
                return [
                    'categoria_id' => $categoria->id,
                    'nome' => $categoria->nome,
                    'denuncias_count' => $categoria->denuncias_count
                ];
            })
        ]);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'nome' => 'required|string|max:100|unique:categorias',
            'descricao' => 'nullable|string',
            'cor' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'ativo' => 'boolean'
        ]);

        try {
            Categoria::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'cor' => $request->cor,
                'ordem' => $request->ordem ?? 1,
                'ativo' => $request->boolean('ativo', true)
            ]);

            return redirect()->route('categorias.index')
                           ->with('success', 'Categoria criada com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao criar categoria: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        $categoria->load(['denuncias' => function($query) {
            $query->with(['status', 'responsavel'])
                  ->orderBy('created_at', 'desc')
                  ->limit(10);
        }]);

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acesso negado.'
                ], 403);
            }
            abort(403, 'Acesso negado.');
        }

        try {
            // Se for requisição AJAX, retornar JSON
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'categoria' => [
                        'id' => $categoria->id,
                        'nome' => $categoria->nome,
                        'descricao' => $categoria->descricao,
                        'cor' => $categoria->cor,
                        'ordem' => $categoria->ordem,
                        'ativo' => $categoria->ativo
                    ]
                ]);
            }

            return view('categorias.edit', compact('categoria'));
            
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar categoria: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao carregar dados da categoria.'
                ], 500);
            }
            return back()->with('error', 'Erro ao carregar categoria: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome,' . $categoria->id,
            'descricao' => 'nullable|string',
            'cor' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
            'ativo' => 'boolean'
        ]);

        try {
            $categoria->update([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'cor' => $request->cor,
                'ordem' => $request->ordem ?? 1,
                'ativo' => $request->boolean('ativo', true)
            ]);

            return redirect()->route('categorias.index')
                           ->with('success', 'Categoria atualizada com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        // Verificar se há denúncias associadas
        if ($categoria->denuncias()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma categoria que possui denúncias associadas.');
        }

        try {
            $categoria->delete();

            return redirect()->route('categorias.index')
                           ->with('success', 'Categoria excluída com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir categoria: ' . $e->getMessage());
        }
    }

    /**
     * Toggle ativo/inativo
     */
    public function toggleAtivo(Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        try {
            $categoria->update(['ativo' => !$categoria->ativo]);

            $mensagem = $categoria->ativo 
                ? 'Categoria ativada com sucesso!' 
                : 'Categoria desativada com sucesso!';

            return redirect()->route('categorias.index')
                           ->with('success', $mensagem);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status da categoria: ' . $e->getMessage());
        }
    }

    /**
     * Listar categorias para select (AJAX)
     */
    public function listarParaSelect()
    {
        $categorias = Categoria::ativas()
                              ->ordenadas()
                              ->select('id', 'nome', 'cor')
                              ->get();

        return response()->json($categorias);
    }

    /**
     * Estatísticas da categoria
     */
    public function estatisticas(Categoria $categoria)
    {
        if (!Auth::user()->podeGerenciarCategorias()) {
            abort(403, 'Acesso negado.');
        }

        // Estatísticas por status
        $estatisticasPorStatus = $categoria->denuncias()
                                          ->select('status_id', DB::raw('count(*) as total'))
                                          ->with('status')
                                          ->groupBy('status_id')
                                          ->get();

        // Estatísticas por mês (últimos 12 meses)
        $estatisticasPorMes = $categoria->denuncias()
                                       ->select(
                                           DB::raw('YEAR(created_at) as ano'),
                                           DB::raw('MONTH(created_at) as mes'),
                                           DB::raw('count(*) as total')
                                       )
                                       ->where('created_at', '>=', now()->subMonths(12))
                                       ->groupBy('ano', 'mes')
                                       ->orderBy('ano', 'desc')
                                       ->orderBy('mes', 'desc')
                                       ->get();

        // Denúncias recentes
        $denunciasRecentes = $categoria->denuncias()
                                      ->with(['status', 'responsavel'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(10)
                                      ->get();

        return view('categorias.estatisticas', compact(
            'categoria',
            'estatisticasPorStatus',
            'estatisticasPorMes',
            'denunciasRecentes'
        ));
    }
}
