<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EvidenciaController extends Controller
{
    /**
     * Store a newly created evidence.
     */
    public function store(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'arquivos.*' => 'required|file|max:10240', // Máximo 10MB por arquivo
            'descricao' => 'nullable|string|max:500',
            'publico' => 'boolean'
        ]);

        try {
            $arquivosSalvos = [];

            foreach ($request->file('arquivos') as $arquivo) {
                // Gerar nome único para o arquivo
                $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                
                // Salvar arquivo
                $caminho = $arquivo->storeAs('evidencias/' . $denuncia->id, $nomeArquivo, 'public');

                // Criar registro no banco
                $evidencia = Evidencia::create([
                    'denuncia_id' => $denuncia->id,
                    'nome_original' => $arquivo->getClientOriginalName(),
                    'nome_arquivo' => $nomeArquivo,
                    'caminho' => $caminho,
                    'tipo_mime' => $arquivo->getMimeType(),
                    'tamanho' => $arquivo->getSize(),
                    'extensao' => $arquivo->getClientOriginalExtension(),
                    'descricao' => $request->descricao,
                    'publico' => $request->boolean('publico', false)
                ]);

                $arquivosSalvos[] = $evidencia;
            }

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', count($arquivosSalvos) . ' arquivo(s) enviado(s) com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao enviar arquivo(s): ' . $e->getMessage());
        }
    }

    /**
     * Display the specified evidence.
     */
    public function show(Evidencia $evidencia)
    {
        // Verificar permissão
        if (!$evidencia->podeSerVisualizada(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        return view('evidencias.show', compact('evidencia'));
    }

    /**
     * Download the specified evidence.
     */
    public function download(Evidencia $evidencia)
    {
        // Verificar permissão
        if (!$evidencia->podeSerVisualizada(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        $caminhoCompleto = storage_path('app/public/' . $evidencia->caminho);

        if (!file_exists($caminhoCompleto)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->download($caminhoCompleto, $evidencia->nome_original);
    }

    /**
     * Remove the specified evidence.
     */
    public function destroy(Evidencia $evidencia)
    {
        // Verificar permissão
        if (!$evidencia->podeSerExcluida(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        try {
            $denuncia = $evidencia->denuncia;
            $evidencia->excluirArquivo();

            return redirect()->route('denuncias.show', $denuncia)
                           ->with('success', 'Evidência excluída com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir evidência: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified evidence.
     */
    public function update(Request $request, Evidencia $evidencia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $evidencia->denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'descricao' => 'nullable|string|max:500',
            'publico' => 'boolean'
        ]);

        try {
            $evidencia->update([
                'descricao' => $request->descricao,
                'publico' => $request->boolean('publico', false)
            ]);

            return redirect()->route('denuncias.show', $evidencia->denuncia)
                           ->with('success', 'Evidência atualizada com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar evidência: ' . $e->getMessage());
        }
    }

    /**
     * Toggle público/privado
     */
    public function togglePublico(Evidencia $evidencia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $evidencia->denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        try {
            $evidencia->update(['publico' => !$evidencia->publico]);

            $mensagem = $evidencia->publico 
                ? 'Evidência marcada como pública!' 
                : 'Evidência marcada como privada!';

            return redirect()->route('denuncias.show', $evidencia->denuncia)
                           ->with('success', $mensagem);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar visibilidade da evidência: ' . $e->getMessage());
        }
    }

    /**
     * Preview da evidência (para imagens)
     */
    public function preview(Evidencia $evidencia)
    {
        // Verificar permissão
        if (!$evidencia->podeSerVisualizada(Auth::user())) {
            abort(403, 'Acesso negado.');
        }

        if (!$evidencia->is_imagem) {
            abort(400, 'Apenas imagens podem ser visualizadas.');
        }

        $caminhoCompleto = storage_path('app/public/' . $evidencia->caminho);

        if (!file_exists($caminhoCompleto)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->file($caminhoCompleto);
    }

    /**
     * Listar evidências de uma denúncia (AJAX)
     */
    public function listarEvidencias(Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $evidencias = $denuncia->evidencias()
                              ->orderBy('created_at', 'desc')
                              ->get();

        return response()->json([
            'evidencias' => $evidencias,
            'podeVerPrivadas' => Auth::user()->podeVerEvidenciasPrivadas()
        ]);
    }

    /**
     * Upload via AJAX
     */
    public function uploadAjax(Request $request, Denuncia $denuncia)
    {
        // Verificar permissão
        if (!Auth::user()->podeGerenciarDenuncias() && $denuncia->responsavel_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'arquivo' => 'required|file|max:10240', // Máximo 10MB
            'descricao' => 'nullable|string|max:500',
            'publico' => 'boolean'
        ]);

        try {
            $arquivo = $request->file('arquivo');

            // Gerar nome único para o arquivo
            $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
            
            // Salvar arquivo
            $caminho = $arquivo->storeAs('evidencias/' . $denuncia->id, $nomeArquivo, 'public');

            // Criar registro no banco
            $evidencia = Evidencia::create([
                'denuncia_id' => $denuncia->id,
                'nome_original' => $arquivo->getClientOriginalName(),
                'nome_arquivo' => $nomeArquivo,
                'caminho' => $caminho,
                'tipo_mime' => $arquivo->getMimeType(),
                'tamanho' => $arquivo->getSize(),
                'extensao' => $arquivo->getClientOriginalExtension(),
                'descricao' => $request->descricao,
                'publico' => $request->boolean('publico', false)
            ]);

            return response()->json([
                'success' => true,
                'evidencia' => $evidencia,
                'message' => 'Arquivo enviado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar arquivo: ' . $e->getMessage()
            ], 500);
        }
    }
}
