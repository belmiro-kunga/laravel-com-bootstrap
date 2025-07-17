<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize {--path=evidencias : Caminho relativo para otimizar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otimiza imagens para melhorar a performance';

    /**
     * Extensões de imagem suportadas
     */
    protected $supportedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->option('path');
        $this->info("Iniciando otimização de imagens em: {$path}");
        
        // Verificar se o diretório existe
        if (!Storage::disk('public')->exists($path)) {
            $this->error("Diretório não encontrado: {$path}");
            return 1;
        }
        
        // Obter todos os arquivos no diretório
        $files = Storage::disk('public')->files($path);
        $imageCount = 0;
        $optimizedCount = 0;
        $totalSaved = 0;
        
        $this->info("Encontrados " . count($files) . " arquivos.");
        $bar = $this->output->createProgressBar(count($files));
        
        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            // Verificar se é uma imagem suportada
            if (in_array($extension, $this->supportedExtensions)) {
                $imageCount++;
                
                // Obter tamanho original
                $originalSize = Storage::disk('public')->size($file);
                
                // Otimizar imagem
                $result = $this->optimizeImage($file, $extension);
                
                if ($result) {
                    // Obter novo tamanho
                    $newSize = Storage::disk('public')->size($file);
                    $saved = $originalSize - $newSize;
                    $totalSaved += $saved;
                    $optimizedCount++;
                    
                    $this->info("Otimizada: {$file} - Economia: " . $this->formatBytes($saved) . " (" . round(($saved / $originalSize) * 100, 1) . "%)");
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("Otimização concluída!");
        $this->info("Total de imagens: {$imageCount}");
        $this->info("Imagens otimizadas: {$optimizedCount}");
        $this->info("Economia total: " . $this->formatBytes($totalSaved));
        
        return 0;
    }
    
    /**
     * Otimiza uma imagem específica
     */
    protected function optimizeImage($file, $extension)
    {
        try {
            $fullPath = Storage::disk('public')->path($file);
            
            // Verificar se as extensões necessárias estão disponíveis
            if (!extension_loaded('gd')) {
                $this->warn("Extensão GD não disponível. Pulando otimização.");
                return false;
            }
            
            // Carregar imagem
            $image = null;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($fullPath);
                    break;
                case 'png':
                    $image = imagecreatefrompng($fullPath);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($fullPath);
                    break;
            }
            
            if (!$image) {
                $this->warn("Não foi possível carregar a imagem: {$file}");
                return false;
            }
            
            // Salvar imagem otimizada
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($image, $fullPath, 85); // Qualidade 85%
                    break;
                case 'png':
                    imagepng($image, $fullPath, 8); // Compressão 8 (0-9)
                    break;
                case 'gif':
                    imagegif($image, $fullPath);
                    break;
            }
            
            // Liberar memória
            imagedestroy($image);
            
            return true;
        } catch (\Exception $e) {
            $this->error("Erro ao otimizar {$file}: " . $e->getMessage());
            Log::error("Erro ao otimizar imagem {$file}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Formata bytes para exibição amigável
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}