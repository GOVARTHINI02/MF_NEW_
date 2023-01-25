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
        // $schedule->command('annual-report-fee')->dailyAt('13:05');
        // $schedule->command('annual-report-financials')->dailyAt('13:08');
        // $schedule->command('fee-schedules')->dailyAt('14:01');
        // $schedule->command('investment-criteria')->dailyAt('14:03');
        // $schedule->command('amc-basic-info')->dailyAt('14:05');
        // $schedule->command('fund-benchmark')->dailyAt('13:23');
        // $schedule->command('fundnet-asset')->dailyAt('13:24');
        // $schedule->command('fund-manager')->dailyAt('13:28');
        // $schedule->command('total-return')->dailyAt('13:32');
        // $schedule->command('current-price')->dailyAt('13:36');
        // $schedule->command('morningstar-rating')->dailyAt('13:40');
        // $schedule->command('dailynav-performance')->dailyAt('13:44');
        // $schedule->command('isin')->dailyAt('13:47');
        // $schedule->command('top10holding')->dailyAt('13:51');
        // $schedule->command('fund-basic-infos')->dailyAt('13:54');
        // $schedule->command('historic-navs')->dailyAt('13:58');
         $schedule->command('scheme-master')->dailyAt('19:47');
        
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
