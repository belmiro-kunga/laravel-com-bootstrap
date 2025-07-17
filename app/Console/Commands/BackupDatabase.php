<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup do banco de dados MySQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando backup do banco de dados...');
        
        try {
            // Obter configurações do banco de dados
            $database = config('database.connections.mysql.database');
            $user = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            
            // Criar nome do arquivo de backup
            $filename = 'backup-' . $database . '-' . Carbon::now()->format('Y-m-d-H-i-s') . '.sql';
            $backupPath = storage_path('app/backups');
            
            // Criar diretório de backup se não existir
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            $fullPath = $backupPath . '/' . $filename;
            
            // Comando para backup
            $command = "mysqldump --user={$user} --password={$password} --host={$host} {$database} > {$fullPath}";
            
            // Executar comando
            $returnVar = NULL;
            $output = NULL;
            exec($command, $output, $returnVar);
            
            if ($returnVar === 0) {
                // Comprimir o arquivo SQL
                $zipFilename = $filename . '.gz';
                $zipFullPath = $backupPath . '/' . $zipFilename;
                
                $this->compressFile($fullPath, $zipFullPath);
                
                // Remover arquivo SQL original após compressão
                if (file_exists($zipFullPath)) {
                    unlink($fullPath);
                }
                
                // Manter apenas os últimos 7 backups
                $this->cleanOldBackups($backupPath, 7);
                
                $this->info('Backup do banco de dados concluído com sucesso: ' . $zipFilename);
                Log::channel('security')->info('Backup do banco de dados concluído com sucesso', [
                    'arquivo' => $zipFilename,
                    'tamanho' => filesize($zipFullPath),
                    'timestamp' => now()->toIso8601String()
                ]);
                
                return 0;
            } else {
                throw new \Exception("Erro ao executar comando mysqldump. Código de retorno: {$returnVar}");
            }
        } catch (\Exception $e) {
            $this->error('Erro ao fazer backup do banco de dados: ' . $e->getMessage());
            Log::channel('security')->error('Erro ao fazer backup do banco de dados', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()->toIso8601String()
            ]);
            
            return 1;
        }
    }
    
    /**
     * Comprime um arquivo usando gzip
     */
    private function compressFile($source, $destination)
    {
        $this->info('Comprimindo arquivo...');
        
        $mode = 'wb9'; // Nível máximo de compressão
        $error = false;
        
        if ($fp_out = gzopen($destination, $mode)) {
            if ($fp_in = fopen($source, 'rb')) {
                while (!feof($fp_in)) {
                    gzwrite($fp_out, fread($fp_in, 1024 * 512));
                }
                fclose($fp_in);
            } else {
                $error = true;
            }
            gzclose($fp_out);
        } else {
            $error = true;
        }
        
        if ($error) {
            throw new \Exception('Erro ao comprimir arquivo de backup');
        }
        
        return true;
    }
    
    /**
     * Mantém apenas os últimos N backups
     */
    private function cleanOldBackups($backupPath, $keep)
    {
        $this->info('Limpando backups antigos...');
        
        // Listar todos os arquivos de backup
        $files = glob($backupPath . '/backup-*.sql.gz');
        
        // Ordenar por data (mais recente primeiro)
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        // Manter apenas os últimos N backups
        if (count($files) > $keep) {
            for ($i = $keep; $i < count($files); $i++) {
                if (file_exists($files[$i])) {
                    unlink($files[$i]);
                    $this->info('Backup antigo removido: ' . basename($files[$i]));
                }
            }
        }
    }
}