<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComentarioController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'comentario' => 'required|string|max:1000',
            'tipo' => 'required|in:interno,publico',
            'importante' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $comentario = $denuncia->adicionarComentario(
                $request->comentario,
                Auth::id(),
                $request->tipo
            );

            if ($request->boolean('importante')) {
                $comentario->marcarComoImportante();
            }

            DB::commit();

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Comentário adicionado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao adicionar comentário: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comentario $comentario)
    {
        // Verificar permissão
        if (!$comentario->podeSerEditado(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'comentario' => 'required|string|max:1000',
            'tipo' => 'required|in:interno,publico'
        ]);

        try {
            $comentario->update([
                'comentario' => $request->comentario,
                'tipo' => $request->tipo
            ]);

            return redirect()->route('denuncias.show', $comentario->denuncia)
                           ->with('success', 'Comentário atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar comentário: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comentario $comentario)
    {
        // Verificar permissão
        if (!$comentario->podeSerExcluido(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        try {
            $denuncia = $comentario->denuncia;
            $comentario->delete();

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Comentário excluído com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir comentário: ' . $e->getMessage());
        }
    }

    /**
     * Marcar/desmarcar comentário como importante
     */
    public function toggleImportante(Comentario $comentario)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $comentario->denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        try {
            $comentario->alternarImportancia();

            $mensagem = $comentario->importante 
                ? 'Comentário marcado como importante!' 
                : 'Comentário desmarcado como importante!';

            return redirect()->route('denuncias.show', $comentario->denuncia)
                           ->with('success', $mensagem);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status do comentário: ' . $e->getMessage());
        }
    }

    /**
     * Listar comentários de uma denúncia (AJAX)
     */
    public function listarComentarios(Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $comentarios = $denuncia->comentarios()
                               ->with('user')
                               ->orderBy('created_at', 'desc')
                               ->get();

        return response()->json([
            'comentarios' => $comentarios,
            'podeVerInternos' => Auth::user()->podeVerComentariosInternos()
        ]);
    }

    /**
     * Adicionar comentário via AJAX
     */
    public function adicionarComentarioAjax(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'comentario' => 'required|string|max:1000',
            'tipo' => 'required|in:interno,publico',
            'importante' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $comentario = $denuncia->adicionarComentario(
                $request->comentario,
                Auth::id(),
                $request->tipo
            );

            if ($request->boolean('importante')) {
                $comentario->marcarComoImportante();
            }

            $comentario->load('user');

            DB::commit();

            return response()->json([
                'success' => true,
                'comentario' => $comentario,
                'message' => 'Comentário adicionado com sucesso!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao adicionar comentário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar mensagem do moderador para o denunciante
     */
    public function enviarMensagem(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão - apenas moderadores e responsáveis podem enviar mensagens
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'mensagem' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $comentario = $denuncia->comentarios()->create([
                'user_id' => Auth::id(),
                'comentario' => $request->mensagem,
                'tipo' => 'publico', // Mensagens para o denunciante são sempre públicas
                'importante' => false
            ]);

            DB::commit();

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Mensagem enviada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao enviar mensagem: ' . $e->getMessage());
        }
    }

    /**
     * Responder a uma mensagem (para denunciantes)
     */
    public function responderMensagem(Request $request, Comentario $comentario)
    {
        // Verificar se o usuário é o denunciante
        if (Auth::id() !== $comentario->denuncia->user_id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'resposta' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $resposta = $comentario->denuncia->comentarios()->create([
                'user_id' => Auth::id(),
                'comentario' => $request->resposta,
                'tipo' => 'publico',
                'importante' => false,
                'reply_to' => $comentario->id
            ]);

            DB::commit();

            return redirect()->route('rastreamento.show', $comentario->denuncia)
                           ->with('success', 'Resposta enviada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao enviar resposta: ' . $e->getMessage());
        }
    }

    /**
     * Listar mensagens de uma denúncia (para timeline)
     */
    public function listarMensagens(Denuncia $denuncia)
    {
        $mensagens = $denuncia->comentarios()
                             ->where('tipo', 'publico')
                             ->with(['user', 'replies.user'])
                             ->whereNull('reply_to') // Apenas mensagens principais
                             ->orderBy('created_at', 'asc')
                             ->get();

        return response()->json([
            'mensagens' => $mensagens
        ]);
    }

    /**
     * Responder mensagem pública sem login (rastreamento público)
     */
    public function responderMensagemPublica(Request $request, $protocolo, $comentario)
    {
        $request->validate([
            'resposta' => 'required|string|max:1000',
        ]);

        // Buscar denúncia pelo protocolo
        $denuncia = \App\Models\Denuncia::where('protocolo', $protocolo)->firstOrFail();
        // Buscar comentário pai
        $comentarioPai = \App\Models\Comentario::where('id', $comentario)
            ->where('denuncia_id', $denuncia->id)
            ->where('tipo', 'publico')
            ->whereNull('reply_to')
            ->firstOrFail();

        // Buscar usuário anônimo
        $usuarioAnonimo = \App\Models\User::where('email', 'anonimo@sistema.com')->firstOrFail();

        // Criar resposta como comentário público
        $resposta = $denuncia->comentarios()->create([
            'user_id' => $usuarioAnonimo->id, // Usar usuário anônimo
            'comentario' => $request->resposta,
            'tipo' => 'publico',
            'importante' => false,
            'reply_to' => $comentarioPai->id
        ]);

        return redirect()->back()->with('success', 'Resposta enviada com sucesso!');
    }
}
