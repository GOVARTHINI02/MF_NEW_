<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\InvestmentCriteria;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\MfTrait;
class InvestmentCriterias extends Command
{
    use MfTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment-criteria';

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
        Log::info('Investment Criteria - Start');

        try {
            $response       =   Http::withToken($this->accesstoken())->get('https://middleware.aliceblueonline.com:8181/mstar/investmentCriteria');

            $data           =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {
                        $details                            =   new InvestmentCriteria;
                        $details->MStarID                   =   $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                      =   $value['api']['DP-ISIN'] ?? null;
                        $details->InvestmentPhilosophy      =   $value['api']['IC-InvestmentPhilosophy'] ?? null;
                        $details->InvestmentStrategy        =   $value['api']['IC-InvestmentStrategy'] ?? null;
                        $details->save();
                    }
                }
                InvestmentCriteria::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Investment Criteria - error' . $response);
            }
        } catch (\Throwable $th) {

            $schedule   =   'Investment Criteria';
            Log::info($th);
            InvestmentCriteria::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Investment Criteria - end');
    }
}
