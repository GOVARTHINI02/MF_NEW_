<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\Isin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Isins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isin';

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
        Log::info(' ISIN  - start');

        try {

            $response   =   Http::get('https://api.morningstar.com/v2/service/mf/hzknpom97bkybm4i/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
            $data       =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {
                        $details                            =   new Isin;
                        $details->MStarID                   =   $value['api']['FSCBI-MStarID'] ?? null;
                        $details->ISIN                      =   $value['api']['FSCBI-ISIN'] ?? null;
                        $details->AMFICode                  =   $value['api']['FSCBI-AMFICode'] ?? null;              
                        $details->save();
                    }
                }

                Isin::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Isin - error' . $response);
            }
        } catch (\Throwable $th) {
            $schedule   =   "Isin";
            Log::info($th);
            Isin::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Isin - end');
    }
    
}
