<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\FundNetAsset;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\MfTrait;
class FundNetAssets extends Command
{
    use MfTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fundnet-asset';

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
        Log::info('Fund Net Asset - start');

        try {

            $response   =   Http::withToken($this->edit())->get('https://middleware.aliceblueonline.com:8181/mstar/fundNetAssets');
            $data       =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        $details                                =       new FundNetAsset;
                        $details->MStarID                       =       $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                          =       $value['api']['DP-ISIN'] ?? null;
                        $details->AsOfOriginalReported          =       $value['api']['FNA-AsOfOriginalReported'] ?? null;
                        $details->AsOfOriginalReportedDate      =       $value['api']['FNA-AsOfOriginalReportedDate'] ?? null;
                        $details->FundNetAssets                 =       $value['api']['FNA-FundNetAssets'] ?? null;
                        $details->NetAssetsDate                 =       $value['api']['FNA-NetAssetsDate'] ?? null;
                        $details->save();
                    }
                }

                FundNetAsset::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Fund Net Asset - error' . $response);
            }
        } catch (\Throwable $th) {
            $schedule = "Fund Net Asset";
            Log::info($th);
            FundNetAsset::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Fund Net Asset - end');
    }
}
