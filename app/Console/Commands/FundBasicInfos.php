<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\FundBasicInfo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FundBasicInfos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund-basic-infos';

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
        Log::info('Fund Basic Info - Start');
        try {

            $response = Http::get('https://api.morningstar.com/v2/service/mf/q44i4g1hofp4tw8y/universeid/xlf5e5g9pqeffzs0?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data = json_decode($response, true);

            if ($data['status']['message'] == 'OK') {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {

                        $details                                =       new FundBasicInfo();
                        $details->MstarID                       =    $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                          =    $value['api']['FSCBI-ISIN'] ?? null;
                        $details->AMFICode                      =    $value['api']['FSCBI-AMFICode'] ?? null;
                        $details->AggregatedCategoryName        =    $value['api']['FSCBI-AggregatedCategoryName'] ?? null;
                        $details->BroadCategoryGroup            =    $value['api']['FSCBI-BroadCategoryGroup'] ?? null;
                        $details->CategoryName                  =    $value['api']['FSCBI-CategoryName'] ?? null;
                        $details->FundLegalName                 =    $value['api']['FSCBI-FundLegalName'] ?? null;
                        $details->FundName                      =    $value['api']['FSCBI-FundName'] ?? null;
                        $details->InceptionDate                 =    $value['api']['FSCBI-InceptionDate'] ?? null;
                        $details->IndianRiskLevel               =    $value['api']['FSCBI-IndianRiskLevel'] ?? null;
                        $details->ProviderCompanyName           =    $value['api']['FSCBI-ProviderCompanyName'] ?? null;
                        $details->ProviderCompanyPhoneNumber    =    $value['api']['FSCBI-ProviderCompanyPhoneNumber']  ?? null;
                        $details->ProviderCompanyWebsite        =    $value['api']['FSCBI-ProviderCompanyWebsite']  ?? null;
                        $details->RTACode                       =    $value['api']['FSCBI-RTACode'] ?? null;
                        $details->CustodianCompanyName          =    $value['api']['FSCBI-CustodianCompanyName'] ?? null;
                        $details->DistributorCompanyName        =    $value['api']['FSCBI-DistributorCompanies'][0]['DistributorCompanyName'] ?? null;

                        if ($value['api']['FSCBI-BroadCategoryGroup'] == 'Fixed Income') {
                            $details->Alice_category = 'Fixed Income';
                            $details->save();
                        } elseif ($value['api']['FSCBI-BroadCategoryGroup'] == 'Allocation') {
                            $details->Alice_category = 'Hybrid';
                            $details->save();
                        } elseif (($value['api']['FSCBI-BroadCategoryGroup'] == 'commodities') || ($value['api']['FSCBI-BroadCategoryGroup'] == 'Alternative') || ($value['api']['FSCBI-BroadCategoryGroup'] == 'Money market')) {
                            $details->Alice_category = 'Other';
                            $details->save();
                        } elseif (($value['api']['FSCBI-BroadCategoryGroup'] == 'Equity') &&  ($value['api']['FSCBI-CategoryName'] == 'ELSS (Tax Savings)')) {
                            $details->Alice_category = 'ELSS';
                            $details->save();
                        } elseif (($value['api']['FSCBI-BroadCategoryGroup'] == 'Equity') && ($value['api']['FSCBI-CategoryName'] != 'ELSS (Tax Savings)')) {
                            $details->Alice_category = 'Equity';
                            $details->save();
                        }
                    }
                }
                FundBasicInfo::where('created_at', '<', Carbon::today())->delete();

            }else{

                  Log::info('Fund Basic Info - Error' . $response);

            }
        } catch (\Throwable $th) {
                
            $schedule = "Fund Basic Info";
            Log::info($th);
            FundBasicInfo::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));

        }

        Log::info('Fund Basic Info - End');
    }
}
