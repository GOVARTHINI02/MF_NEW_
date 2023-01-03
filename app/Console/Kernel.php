<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('annual-report-fee')->everyMinute();
        // $schedule->command('annual-report-financials')->everyMinute();
        // $schedule->command('fee-schedules')->everyMinute();
        // $schedule->command('investment-criteria')->everyMinute();
        // $schedule->command('amc-basic-info')->everyMinute();
        //  $schedule->command('fund-benchmark')->everyMinute();
           $schedule->command('fundnet-asset')->everyMinute();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
