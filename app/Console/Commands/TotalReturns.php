<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\TotalReturn;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\MfTrait;
class TotalReturns extends Command
{
    use MfTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'total-return';

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
        Log::info('Total Return - Start');
        try {
            $response   =  Http::withToken($this->edit())->get('https://middleware.aliceblueonline.com:8181/mstar/totalReturns');

            $data       =  json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        $details                                     =      new  TotalReturn;
                        $details->MStarID                            =      $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                               =      $value['api']['DP-ISIN'] ?? null;
                        $details->CumulativeReturn2Yr                =      $value['api']['TTR-CumulativeReturn2Yr'] ?? null;
                        $details->CumulativeReturn3Yr                =      $value['api']['TTR-CumulativeReturn3Yr'] ?? null;
                        $details->CumulativeReturn4Yr                =      $value['api']['TTR-CumulativeReturn4Yr'] ?? null;
                        $details->CumulativeReturnSinceInception     =      $value['api']['TTR-CumulativeReturnSinceInception'] ?? null;
                        $details->MonthEndDate                       =      $value['api']['TTR-MonthEndDate'] ?? null;
                        $details->Return1Mth                         =      $value['api']['TTR-Return1Mth'] ?? null;
                        $details->Return1Yr                          =      $value['api']['TTR-Return1Yr'] ?? null;
                        $details->Return2Mth                         =      $value['api']['TTR-Return2Mth'] ?? null;
                        $details->Return2Yr                          =      $value['api']['TTR-Return2Yr'] ?? null;
                        $details->Return3Mth                         =      $value['api']['TTR-Return3Mth'] ?? null;
                        $details->Return3Yr                          =      $value['api']['TTR-Return3Yr'] ?? null;
                        $details->Return4Yr                          =      $value['api']['TTR-Return4Yr'] ?? null;
                        $details->Return6Mth                         =      $value['api']['TTR-Return6Mth'] ?? null;
                        $details->ReturnSinceInception               =      $value['api']['TTR-ReturnSinceInception'] ?? null;
                        $details->save();
                    }
                }
                TotalReturn::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Total Return - error' . $response);
            }
        } catch (\Throwable $th) {

            $schedule   =   "Total - Return";
            Log::info($th);
            TotalReturn::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Total Return - End');
    }
}
