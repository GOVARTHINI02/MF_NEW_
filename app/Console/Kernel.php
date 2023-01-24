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
        $schedule->command('annual-report-fee')->dailyAt('21:01');
        $schedule->command('annual-report-financials')->dailyAt('21:03');
        $schedule->command('fee-schedules')->dailyAt('21:05');
        $schedule->command('investment-criteria')->dailyAt('21:07');
        $schedule->command('amc-basic-info')->dailyAt('21:10');
        $schedule->command('fund-benchmark')->dailyAt('21:13');
        $schedule->command('fundnet-asset')->dailyAt('21:16');
        $schedule->command('fund-manager')->dailyAt('21:19');
        $schedule->command('total-return')->dailyAt('21:23');
        $schedule->command('current-price')->dailyAt('21:26');
        $schedule->command('morningstar-rating')->dailyAt('21:30');
        $schedule->command('dailynav-performance')->dailyAt('21:33');
        $schedule->command('isin')->dailyAt('21:36');
        $schedule->command('top10holding')->dailyAt('21:39');
        $schedule->command('fund-basic-infos')->dailyAt('21:43');
        $schedule->command('historic-navs')->dailyAt('21:46');
        
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
