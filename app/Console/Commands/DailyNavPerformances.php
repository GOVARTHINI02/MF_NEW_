<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\DailyNavPerformance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Foreach_;

use function Ramsey\Uuid\v1;

class DailyNavPerformances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailynav-performance';

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
        Log::info('Daily Nav Performance - Start');
        try {

            $response = Http::get('https://api.morningstar.com/v2/service/mf/iyoavhm9qqh102g9/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data = json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data']  as $value) {

                    if (key_exists('api', $value)) {

                        $details                                     =      new DailyNavPerformance;
                        $details->MStarID                            =      $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                               =      $value['api']['DP-ISIN'] ?? null;
                        $details->CategoryCode                       =      $value['api']['DP-CategoryCode'] ?? null;
                        $details->CategoryName                       =      $value['api']['DP-CategoryName'] ?? null;
                        $details->CumulativeReturn3Yr                =      $value['api']['DP-CumulativeReturn3Yr'] ?? null;
                        $details->CumulativeReturn5Yr                =      $value['api']['DP-CumulativeReturn5Yr'] ?? null;
                        $details->CumulativeReturn10Yr               =      $value['api']['DP-CumulativeReturn10Yr'] ?? null;
                        $details->CumulativeReturnSinceInception     =      $value['api']['DP-CumulativeReturnSinceInception'] ?? null;
                        $details->DayEndDate                         =      $value['api']['DP-DayEndDate'] ?? null;
                        $details->DayEndNAV                          =      $value['api']['DP-DayEndNAV'] ?? null;
                        $details->Dividend                           =      $value['api']['DP-Dividend'] ?? null;
                        $details->DividendDate                       =      $value['api']['DP-DividendDate'] ?? null;
                        $details->FundName                           =      $value['api']['DP-FundName'] ?? null;
                        $details->NAVChange                          =      $value['api']['DP-NAVChange'] ?? null;
                        $details->NAVChangePercentage                =      $value['api']['DP-NAVChangePercentage'] ?? null;
                        $details->RecordDate                         =      $value['api']['DP-RecordDate'] ?? null;
                        $details->Return1Day                         =      $value['api']['DP-Return1Day'] ?? null;
                        $details->Return1Mth                         =      $value['api']['DP-Return1Mth'] ?? null;
                        $details->Return1Week                        =      $value['api']['DP-Return1Week'] ?? null;
                        $details->Return1Yr                          =      $value['api']['DP-Return1Yr'] ?? null;
                        $details->Return2Mth                         =      $value['api']['DP-Return2Mth'] ?? null;
                        $details->Return2Yr                          =      $value['api']['DP-Return2Yr'] ?? null;
                        $details->Return3Mth                         =      $value['api']['DP-Return3Mth'] ?? null;
                        $details->Return3Yr                          =      $value['api']['DP-Return3Yr'] ?? null;
                        $details->Return4Yr                          =      $value['api']['DP-Return4Yr'] ?? null;
                        $details->Return5Yr                          =      $value['api']['DP-Return5Yr'] ?? null;
                        $details->Return6Mth                         =      $value['api']['DP-Return6Mth'] ?? null;
                        $details->ReturnSinceInception               =      $value['api']['DP-ReturnSinceInception'] ?? null;
                        $details->save();
                    }
                }

                DailynavPerformance::where('created_at', "<", Carbon::today())->delete();
            } else {

                Log::info('Daily Nav Performance - Error' . $response);
            }
        } catch (\Throwable $th) {

            $schedule  =  'Daily Nav Performance';

            Log::info($th);

            DailyNavPerformance::wheredate('created_at', Carbon::today())->delete();

            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Daily Nav Performance - END');
    }
}
