<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\FundBenchmark;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FundBenchmarks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund-benchmark';

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
        Log::info('Fund Benchmark - start');

        try {

            $response       =   Http::get('https://api.morningstar.com/v2/service/mf/hn9s4u6i1qr9ydjm/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data           =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        if (key_exists('FB-PrimaryProspectusBenchmarks', $value['api'])) {

                            foreach ($value['api']['FB-PrimaryProspectusBenchmarks']  as  $row) {
    
                                $this->store_data($value, $row);
                            }
                        } else {

                            $this->store_data($value, null);
                        }
                    }
                }
                FundBenchmark::where('created_at', '<', Carbon::today())->delete();

            } else {

                Log::info('Fund Benchmark - error' . $response);
            }

        } 
        catch (\Throwable $th) {
            $schedule   = 'Fund - Benchmark';
            Log::info($th);
            FundBenchmark::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }
        Log::info('Fund Benchmark - end');
    }

    function store_data($value, $row)
    {

        $details                        =  new FundBenchmark;

        $details->MStarID               =   $value['api']['DP-MStarID'] ?? null;
        $details->ISIN                  =   $value['api']['DP-ISIN'] ?? null;
        $details->PrimaryIndexId        =   $value['api']['FB-PrimaryIndexId'] ?? null;
        $details->IndexId               =   $row['IndexId'] ?? null;
        $details->IndexName             =   $row['IndexName'] ?? null;
        $details->Weighting             =   $row['Weighting'] ?? null;
        $details->SecondaryIndexId      =   $value['api']['FB-SecondaryIndexId'] ?? null;
        $details->SecondaryIndexName    =   $value['api']['FB-SecondaryIndexName'] ?? null;
        $details->save();
    
    }
}
