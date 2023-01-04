<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\CurrentPrice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CurrentPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current-price';

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
        Log::info('Current Price - Start');

        try {
            $response =  Http::get('https://api.morningstar.com/v2/service/mf/bgum3c0e1ay8hgj7/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
            $data  = json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data']  as  $value) {

                    if (key_exists('api', $value)) {

                        $details                            =  new CurrentPrice;
                        $details->MStarID                   =  $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                      =  $value['api']['DP-ISIN'] ?? null;
                        $details->DayEndNAV                 =  $value['api']['TS-DayEndNAV'] ?? null;
                        $details->DayEndNAVDate             =  $value['api']['TS-DayEndNAVDate'] ?? null;
                        $details->MonthEndNAV               =  $value['api']['TS-MonthEndNAV'] ?? null;
                        $details->MonthEndNAVDate           =  $value['api']['TS-MonthEndNAVDate'] ?? null;
                        $details->NAV52wkHigh               =  $value['api']['TS-NAV52wkHigh'] ?? null;
                        $details->NAV52wkHighDate           =  $value['api']['TS-NAV52wkHighDate'] ?? null;
                        $details->NAV52wkLow                =  $value['api']['TS-NAV52wkLow'] ?? null;
                        $details->NAV52wkLowDate            =  $value['api']['TS-NAV52wkLowDate'] ?? null;
                        $details->PerformanceReturnSource   =  $value['api']['TS-PerformanceReturnSource'] ?? null;
                        $details->save();
                    }
                }

                CurrentPrice::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Current Price - error' . $response);
            }

        } catch (\Throwable $th) {

            $schedule = "Current - Price";
            Log::info($th);
            CurrentPrice::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Current Price - End');
    }
}
