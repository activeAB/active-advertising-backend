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
        // $schedule->command('inspire')->hourly();
        // 
        $schedule->command('weekly-report:generate')->weeklyOn(0, '23:59'); // Run every Sunday at 11:59 PM
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        $this->load(__DIR__.'/Commands');
        $files = glob(app_path('Console/Commands') . '/*.php');

        foreach ($files as $file) {
            $command = 'App\\Console\\Commands\\' . basename($file, '.php');
            $this->app->singleton($command);
            $this->commands[] = $command;
        }
    }

    
}
