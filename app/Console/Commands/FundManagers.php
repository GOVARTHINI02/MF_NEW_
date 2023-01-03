<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\FundBenchmark;
use App\Models\FundManager;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FundManagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature    = 'fund-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description  = 'Command description';

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
        Log::info('Fund Manager - start');

        try {

            $response       =   Http::get('https://api.morningstar.com/v2/service/mf/krpp14z315ydb9bu/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data           =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        if (key_exists('FM-Managers', $value['api'])) {

                            foreach ($value['api']['FM-Managers'] as $row) {
    
                                $this->store_data($value, $row);
                            }
                        } else {

                            $this->store_data($value, null);
                        }
                    }
                }
                FundManager::where('created_at', '<', Carbon::today())->delete();

            } else {

                Log::info('Fund Manager - error' . $response);
            }

        } 
        catch (\Throwable $th) {
            $schedule   = 'Fund - Manager';
            Log::info($th);
            FundManager::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }
        Log::info('Fund Manager - end');
    }

    function store_data($value,$row)
    {

      $details                                =   new FundManager;
      $details->MStarID                       =   $value['api']['DP-MStarID'] ?? null;
      $details->ISIN                          =   $value['api']['DP-ISIN'] ?? null;
      $details->FundManagerTenureAverage      =   $value['api']['FM-FundManagerTenureAverage'] ?? null;
      $details->Display                       =   $row['Display'] ?? null;
      $details->ManagerId                     =   $row['ManagerId'] ?? null;
      $details->Name                          =   $row['Name'] ?? null;
      $details->Role                          =   $row['Role'] ?? null;
      $details->StartDate                     =   $row['StartDate'] ?? null;
      $details->Tenure                        =   $row['Tenure'] ?? null;
      $details->save();

    }
}