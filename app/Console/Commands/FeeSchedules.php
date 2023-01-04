<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\FeeSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FeeSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fee-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Fee Schedule - start');

        try {

            $response       =   Http::get('https://api.morningstar.com/v2/service/mf/jz000epuvey19sqw/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data           =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        if (key_exists('LS-DeferLoads', $value['api'])) {

                            foreach ($value['api']['LS-DeferLoads']  as  $row) {

                                $this->store_data($value, $row);
                            }
                        } else {

                            $this->store_data($value, null);
                        }
                    }
                }
                FeeSchedule::where('created_at', '<', Carbon::today())->delete();

            } else {

                Log::info('Fee Schedule - error' . $response);
            }

        } 
        catch (\Throwable $th) {
            $schedule   = 'Fee - Schedule';
            Log::info($th);
            FeeSchedule::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }
        Log::info('Fee Schedule - end');
    }

    function store_data($value, $row)
    {
        $details                                    =   new FeeSchedule();
        $details->MStarID                           =   $value['api']['DP-MStarID'] ?? null;
        $details->ISIN                              =   $value['api']['DP-ISIN'] ?? null;
        $details->DeferLoads_HighBreakpoint         =   $row['HighBreakpoint'] ?? null;
        $details->DeferLoads_LowBreakpoint          =   $row['LowBreakpoint'] ?? null;
        $details->DeferLoads_BreakpointUnit         =   $row['BreakpointUnit'] ?? null;
        $details->DeferLoads_Unit                   =   $row['Unit'] ?? null;
        $details->DeferLoads_Value                  =   $row['Value'] ?? null;
        $details->DeferLoadDate                     =   $value['api']['LS-DeferLoadDate'] ?? null;
        $details->FrontLoads_LowBreakpoint          =   $value['api']['LS-FrontLoads'][0]['LowBreakpoint'] ?? null;
        $details->FrontLoads_BreakpointUnit         =   $value['api']['LS-FrontLoads'][0]['BreakpointUnit'] ?? null;
        $details->FrontLoads_Unit                   =   $value['api']['LS-FrontLoads'][0]['Unit'] ?? null;
        $details->FrontLoads_Value                  =   $value['api']['LS-FrontLoads'][0]['Value'] ?? null;
        $details->save();
    }
}
