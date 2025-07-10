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
