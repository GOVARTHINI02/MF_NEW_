<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\MorningstarRating;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MorningstarRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'morningstar-rating';

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
        Log::info('Morning star Rating - Start');

        try {
            $response =  Http::get('https://api.morningstar.com/v2/service/mf/xy3a4bkmr39ahzw1/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
            $data  = json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data']  as  $value) {

                    if (key_exists('api', $value)) {

                        $details                                =  new MorningstarRating;
                        $details->MStarID                       =  $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                          =  $value['api']['DP-ISIN'] ?? null;
                        $details->NumberOfFunds10Year           =  $value['api']['MR-NumberOfFunds10Year'] ?? null;
                        $details->NumberOfFunds3Year            =  $value['api']['MR-NumberOfFunds3Year'] ?? null;
                        $details->NumberOfFunds5Year            =  $value['api']['MR-NumberOfFunds5Year'] ?? null;
                        $details->NumberOfFundsOverall          =  $value['api']['TS-MR-NumberOfFundsOverall'] ?? null;
                        $details->PerformanceScore3Yr           =  $value['api']['MR-PerformanceScore3Yr'] ?? null;
                        $details->PerformanceScoreOverall       =  $value['api']['MR-PerformanceScoreOverall'] ?? null;
                        $details->Rating3Year                   =  $value['api']['MR-Rating3Year'] ?? null;
                        $details->Rating5Year                   =  $value['api']['MR-Rating5Year'] ?? null;
                        $details->RatingDate                    =  $value['api']['MR-RatingDate'] ?? null;
                        $details->RatingOverall                 =  $value['api']['MR-RatingOverall'] ?? null;
                        $details->Return3Year                   =  $value['api']['MR-Return3Year'] ?? null;
                        $details->Return5Year                   =  $value['api']['MR-Return5Year'] ?? null;
                        $details->ReturnOverall                 =  $value['api']['MR-ReturnOverall'] ?? null;
                        $details->Risk3Year                     =  $value['api']['MR-Risk3Year'] ?? null;
                        $details->Risk5Year                     =  $value['api']['MR-Risk5Year'] ?? null;
                        $details->RiskOverall                   =  $value['api']['MR-RiskOverall'] ?? null;
                        $details->RiskScore3Yr                  =  $value['api']['MR-RiskScore3Yr'] ?? null;
                        $details->RiskScore5Yr                  =  $value['api']['MR-RiskScore5Yr'] ?? null;
                        $details->RiskScoreOverall              =  $value['api']['MR-RiskScoreOverall'] ?? null;
                        $details->save();
                    }
                }

                MorningstarRating::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Morningstar Rating - error' . $response);
            }

        } catch (\Throwable $th) {

            $schedule = "Morning star Rating";
            Log::info($th);
            MorningstarRating::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Morning star Rating - End');
    }

    
}
