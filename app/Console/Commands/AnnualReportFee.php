<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use Illuminate\Console\Command;
use App\Models\AnnualReportFees;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AnnualReportFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'annual-report-fee';

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
        Log::info('Annual report fees - start');

        try {

            $response   =   Http::get('https://api.morningstar.com/v2/service/mf/yuw8oobhq25iu206/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
            $data       =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {
                        $details                            =   new AnnualReportFees;
                        $details->MStarID                   =   $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                      =   $value['api']['DP-ISIN'] ?? null;
                        $details->AnnualReportDate          =   $value['api']['ARF-AnnualReportDate'] ?? null;
                        $details->NetExpenseRatio           =   $value['api']['ARF-NetExpenseRatio'] ?? null;
                        $details->InterimNetExpenseRatio    =   $value['api']['ARF-InterimNetExpenseRatio'] ?? null;
                        $details->save();
                    }
                }

                AnnualReportFees::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Annual report fees - error' . $response);
            }
        } catch (\Throwable $th) {
            $schedule = "Annual Report Fee";
            Log::info($th);
            AnnualReportFees::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Annual report fees - end');
    }
}
