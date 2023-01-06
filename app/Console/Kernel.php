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
        $schedule->command('annual-report-fee')->dailyAt('12:54');
        $schedule->command('annual-report-financials')->dailyAt('12:58');
        $schedule->command('fee-schedules')->dailyAt('13:03');
        $schedule->command('investment-criteria')->dailyAt('13:07');
        $schedule->command('amc-basic-info')->dailyAt('13:10');
        $schedule->command('fund-benchmark')->dailyAt('13:46');
        $schedule->command('fundnet-asset')->dailyAt('13:16');
        $schedule->command('fund-manager')->dailyAt('13:19');
        $schedule->command('total-return')->dailyAt('13:22');
        $schedule->command('current-price')->dailyAt('13:49');
        $schedule->command('morningstar-rating')->dailyAt('13:52');
        $schedule->command('dailynav-performance')->dailyAt('13:32');
        $schedule->command('isin')->dailyAt('13:36');
        $schedule->command('top10holding')->dailyAt('13:40');
        
        
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
