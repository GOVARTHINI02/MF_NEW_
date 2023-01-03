<?php

namespace App\Console\Commands;


use App\Models\AnnualReportFees;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:update';

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
        log::info('Annual report fees - start');

        try {

            $response   =   Http::get('https://api.morningstar.com/v2/service/mf/yuw8oobhq25iu206/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
            $data       =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {
                        $details                            =   new  AnnualReportFees();
                        $details->MStarID                   =   $value['api']['DP-MStarID'] ?? '';
                        $details->ISIN                      =   $value['api']['DP-ISIN'] ?? '';
                        $details->AnnualReportDate          =   $value['api']['ARF-AnnualReportDate'] ?? '';
                        $details->NetExpenseRatio           =   $value['api']['ARF-NetExpenseRatio'] ?? '';
                        $details->InterimNetExpenseRatio    =   $value['api']['ARF-InterimNetExpenseRatio'] ?? '';
                        $details->save();
                    }
                }

                AnnualReportFees::where('created_at', '<', Carbon::today())->delete();
            } else {
                log::info('Annual report fees - error');
            }
        } catch (\Throwable $th) {
            log::info($th);
            AnnualReportFees::whereDate('created_at', Carbon::today())->delete();
        }

        log::info('Annual report fees - end');
    }
}
