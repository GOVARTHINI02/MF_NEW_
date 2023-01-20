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
        $schedule->command('annual-report-fee')->dailyAt('16:10');
        $schedule->command('annual-report-financials')->dailyAt('16:13');
        $schedule->command('fee-schedules')->dailyAt('16:16');
        $schedule->command('investment-criteria')->dailyAt('16:20');
        $schedule->command('amc-basic-info')->dailyAt('16:25');
        $schedule->command('fund-benchmark')->dailyAt('16:30');
        $schedule->command('fundnet-asset')->dailyAt('16:35');
        $schedule->command('fund-manager')->dailyAt('16:40');
        $schedule->command('total-return')->dailyAt('16:45');
        $schedule->command('current-price')->dailyAt('16:50');
        $schedule->command('morningstar-rating')->dailyAt('16:55');
        $schedule->command('dailynav-performance')->dailyAt('17:00');
        $schedule->command('isin')->dailyAt('17:05');
        $schedule->command('top10holding')->dailyAt('17:10');
        $schedule->command('fund-basic-infos')->dailyAt('17:15');
        $schedule->command('historic-navs')->dailyAt('17:20');
        
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
