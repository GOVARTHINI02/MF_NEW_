<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\HistoricNav;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\MfTrait;
class HistoricNavs extends Command
{
    use MfTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historic-navs';

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
        Log::info('Historic Nav - Start');

        try {

            $response = Http::withToken($this->accesstoken())->get('https://middleware.aliceblueonline.com:8181/mstar/historicNAVs?start_date=2022-12-11&end_date=2022-12-31&isin=INF209K01P23');

            $data = json_decode($response, true);

            if ($data['status']['message'] == 'OK') {

                foreach ($data['data']['Prices'] as $value) {

                    $details             =    new HistoricNav;
                    $details->nav_date   =    $value['d'] ?? null;
                    $details->nav_value  =    $value['v'] ?? null;
                    $details->save();
                }

                HistoricNav::where('created_at', '<', Carbon::today())->delete();
            } else {

                Log::info('Historic Nav - Error' . $response);
            }
        } catch (\Throwable $th) {

            $schedule = "Historic Nav";
            Log::info($th);
            HistoricNav::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }
        Log::info('Historic Nav - End');
    }
}
