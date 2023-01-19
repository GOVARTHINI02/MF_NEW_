<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\Top10Holding;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\MfTrait;
class Top10Holdings extends Command
{
    use MfTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'top10holding';

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
        Log::info('Top10Holding - Start');
        try {

            $response  =  Http::withToken($this->edit())->get('https://api.morningstar.com/v2/service/mf/fokr7wm4cxjcrc6v/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data = json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        if (key_exists('T10HV2-HoldingDetail', $value['api'])) {

                            foreach ($value['api']['T10HV2-HoldingDetail'] as $rows) {

                                $details                                    =    new Top10Holding            ;
                                $details->MstarID                           =   $value['_id'] ?? null;
                                $details->ISIN                              =   $rows['ISIN'] ?? null;
                                $details->HoldingType                       =   $rows['HoldingType'] ?? null;
                                $details->Name                              =   $rows['Name'] ?? null;
                                $details->Weighting                         =   $rows['Weighting'] ?? null;
                                $details->NumberOfShare                     =   $rows['NumberOfShare'] ?? null;
                                $details->MarketValue                       =   $rows['MarketValue'] ?? null;
                                $details->ShareChange                       =   $rows['ShareChange'] ?? null;
                                $details->MaturityDate                      =   $rows['MaturityDate'] ?? null;
                                $details->IndianCreditQualityClassification =   $rows['IndianCreditQualityClassification'] ?? null;
                                $details->SectorId                          =   $rows['SectorId'] ?? null;
                                $details->Sector                            =   $rows['Sector'] ?? null;
                                $details->GlobalSectorId                    =   $rows['GlobalSectorId'] ?? null;
                                $details->GlobalSector                      =   $rows['GlobalSector'] ?? null;
                                $details->Ticker                            =   $rows['Ticker'] ?? null;
                                $details->HoldingYTDReturn                  =   $rows['HoldingYTDReturn'] ?? null;
                                $details->Stylebox                          =   $rows['Stylebox'] ?? null;
                                $details->RegionId                          =   $rows['RegionId'] ?? null;
                                $details->save();
                            }
                        }

                        Top10Holding::where('created_at', '<', Carbon::today())->delete();
                    }
                }
            } else {

                Log::info('Top10Holding - error' . $response);
            }
        } catch (\Throwable $th) {

            $schedule   =   "Top10Holding";
            Log::info($th);
            Top10Holding::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Top10Holding - end');
    }
}
