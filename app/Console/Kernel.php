<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Verificar denúncias atrasadas diariamente às 9h
        $schedule->command('denuncias:check-overdue')
                ->dailyAt('09:00')
                ->withoutOverlapping()
                ->runInBackground();

        // Limpar notificações antigas semanalmente
        $schedule->command('notifications:clean')
                ->weekly()
                ->sundays()
                ->at('02:00');
                
        // Backup diário do banco de dados às 3h da manhã
        $schedule->command('backup:database')
                ->dailyAt('03:00')
                ->withoutOverlapping()
                ->runInBackground()
                ->onSuccess(function () {
                    \Log::channel('security')->info('Backup agendado concluído com sucesso');
                })
                ->onFailure(function () {
                    \Log::channel('security')->error('Falha no backup agendado');
                });
                
        // Verificação de segurança diária
        $schedule->command('security:check')
                ->dailyAt('04:00')
                ->withoutOverlapping()
                ->emailOutputOnFailure(env('ADMIN_EMAIL'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
