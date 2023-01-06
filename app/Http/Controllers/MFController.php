<?php

namespace App\Http\Controllers;

use App\Mail\Exception;
use App\Models\AmcBasicInfo;
use App\Models\Annual_report_fees;
use App\Models\AnnualReportFinancial;
use App\Models\FeeSchedule;
use App\Models\FundBenchmarks;
use App\Models\FundManager;
use App\Models\FundNetAsset;
use App\Models\InvestmentCriteria;
use App\Models\Top10Holding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;

use function Ramsey\Uuid\v1;

class MFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $response       =   Http::get('https://api.morningstar.com/v2/service/mf/xy3a4bkmr39ahzw1/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
        print_r('<pre>');
        $data           =   json_decode($response, true);
        print_r($data);
        die;
        if ($data['status']['message'] == "OK") {


            foreach ($data['data'] as $value) {
                

                if (key_exists('api', $value)) {
                           
                          
                    if (key_exists('T10HV2-HoldingDetail', $value['api'])) {
                        foreach ($value['api']['T10HV2-HoldingDetail'] as $rows) {
                            $details                                    =    new Top10Holding;
                            $details->MstarID                           =  $value['_id'] ?? null; 
                            $details->ISIN                              =  $rows['ISIN'] ?? null;
                            $details->HoldingType                       =  $rows['HoldingType'] ?? null;
                            $details->Name                              =  $rows['Name'] ?? null;
                            $details->Weighting                         =  $rows['Weighting'] ?? null;
                            $details->NumberOfShare                     =  $rows['NumberOfShare'] ?? null;
                            $details->MarketValue                       =  $rows['MarketValue'] ?? null;
                            $details->ShareChange                       =  $rows['ShareChange'] ?? null;
                            $details->MaturityDate                      =  $rows['MaturityDate'] ?? null;
                            $details->IndianCreditQualityClassification =  $rows['IndianCreditQualityClassification'] ?? null;
                            $details->SectorId                          =  $rows['SectorId'] ?? null;
                            $details->Sector                            =  $rows['Sector'] ?? null;
                            $details->GlobalSectorId                    =  $rows['GlobalSectorId'] ?? null;
                            $details->GlobalSector                      =  $rows['GlobalSector'] ?? null;
                            $details->Ticker                            =  $rows['Ticker'] ?? null;
                            $details->HoldingYTDReturn                  =  $rows['HoldingYTDReturn'] ?? null;
                            $details->Stylebox                          =  $rows['Stylebox'] ?? null;
                            $details->RegionId                          =  $rows['RegionId'] ?? null;
                            $details->save();
                        }
                    }
                }
            }
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
