<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Atualizar protocolos existentes para o novo formato AAAAMMDD-XXXXX
        $denuncias = \App\Models\Denuncia::orderBy('created_at')->get();
        
        foreach ($denuncias as $denuncia) {
            $data = $denuncia->created_at;
            $dataFormatada = $data->format('Ymd'); // AAAAMMDD
            
            // Contar quantas denúncias já existem para este dia (incluindo a atual)
            $contador = \App\Models\Denuncia::whereDate('created_at', $data->toDateString())
                        ->where('id', '<=', $denuncia->id)
                        ->count();
            
            $novoProtocolo = sprintf('%s-%05d', $dataFormatada, $contador);
            
            // Atualizar o protocolo
            \DB::table('denuncias')
                ->where('id', $denuncia->id)
                ->update(['protocolo' => $novoProtocolo]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para o formato antigo (ano + 6 dígitos)
        $denuncias = \App\Models\Denuncia::orderBy('created_at')->get();
        
        foreach ($denuncias as $index => $denuncia) {
            $ano = $denuncia->created_at->format('Y');
            $numero = $index + 1;
            
            $protocoloAntigo = sprintf('%s%06d', $ano, $numero);
            
            \DB::table('denuncias')
                ->where('id', $denuncia->id)
                ->update(['protocolo' => $protocoloAntigo]);
        }
    }
};
