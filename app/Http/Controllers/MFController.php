<?php

namespace App\Http\Controllers;

use App\Mail\Exception;
use App\Models\AmcBasicInfo;
use App\Models\Annual_report_fees;
use App\Models\AnnualReportFinancial;
use App\Models\FeeSchedule;
use App\Models\FundBasicInfo;
use App\Models\FundBenchmarks;
use App\Models\FundManager;
use App\Models\FundNetAsset;
use App\Models\HistoricNav;
use App\Models\HistoricNavs;
use App\Models\InvestmentCriteria;
use App\Models\SchemaMaster;
use App\Models\Top10Holding;
use App\Models\User;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\File;
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
    public function store()
    {
        $response       =   Http::get('https://api.morningstar.com/service/mf/Price/isin/INF209K01P23?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&startdate=2020-02-01&enddate=2021-02-17&format=json&=');
        // print_r('<pre>');
        $data           =   json_decode($response, true);
        // print_r($data);
        // die;
        if ($data['status']['message'] == "OK") {

            foreach ($data['data']['Prices'] as $value) {

                    $details             =    new HistoricNav;
                    $details->nav_date   =    $value['d'] ?? null;
                    $details->nav_value  =    $value['v'] ?? null;
                    $details->save();
                               
                
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL   => 'https://bsestarmf.in/RptSchemeMaster.aspx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('__VIEWSTATE' => 'HE2KcMaPPQhZY+O/LBdx+TnRtnikQ72+nR2Rw5C+LkUID8+ZyUiHHzYOylOSi6W1cphCFvmH7R77ygs44n0qeVoKSyPR/gKABB5IIB6VOtYRcMb6BGSwHD4HgbtLJ55KL6SeAa0dOule2Fr7fVcuYBkKOX/FtMrh1bTnRgNSndiZUrY1wQ7gRksKYFyDlnqnZY23BA==', '__VIEWSTATEGENERATOR' => '27FA2253', '__VIEWSTATEENCRYPTED' => '', '__EVENTVALIDATION' => 'gWOGfeBAlaUGi3RfeRNodp6ksB+XYVd7y9smtu0W97VhRAqUeowQdZ9FOQCdgqhFBmJWTGJkTaLggGbZ3D8G+OVWwZdpBfjF48Pg7sppN9AAFvvVWXn6jUEs1MF2bE4InZ7847uP6+lYfw28MqYcsQyQ97MeFjmb3lIJTjQbxYFzgC/AvWpEZe7Zs/svRIEeql9jCQ==', 'ddlTypeOption' => 'SCHEMEMASTER', 'btnText' => 'Export to Text'),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // print_r('<pre>');
        $response;
        // echo nl2br($response, false);
        $array =  explode("\n", $response);

        foreach ($array  as  $key => $val) {
            if ($val) {
                $funds = (explode("|", $val));

                if ($funds[7] == 'Direct'  &&  $funds[9] == 'y'  &&  $funds[10] == 'DP' || $funds[10] == 'D' && $funds[15] == '13:00:00' || $funds[15] == '14:30:00' || $funds[15] == '15:00:00' && $funds[17] == 'D' || $funds[17] == 'DP' &&  $funds[27] == 'N' || $funds[27] == 'Z' &&  $funds[5] == 'NJMUTUALFUND_MF' || $funds[5] == 'SAMCOMUTUALFUND_MF' || $funds[5] == 'TRUSTMUTUALFUND_MF') {

                    if ($key != 0) {
                        $value                                  =  new SchemaMaster;
                        $value->unique_no                       =  $funds[0];
                        $value->schema_code                     =  $funds[1];
                        $value->rta_schema_code                 =  $funds[2];
                        $value->amc_schema_code                 =  $funds[3];
                        $value->isin                            =  $funds[4];
                        $value->amc_code                        =  $funds[5];
                        $value->scheme_type                     =  $funds[6];
                        $value->schema_plan                     =  $funds[7];
                        $value->schema_name                     =  $funds[8];
                        $value->purchase_allowed                =  $funds[9];
                        $value->purchase_transaction_mode       =  $funds[10];
                        $value->minimum_purchase_amount         =  $funds[11];
                        $value->additional_purchase_amount      =  $funds[12];
                        $value->maximum_purchase_amount         =  $funds[13];
                        $value->purchase_amount_multiplier      =  $funds[14];
                        $value->purchase_cutoff_time            =  $funds[15];
                        $value->redemption_allowed              =  $funds[16];
                        $value->redemption_transaction_mode     =  $funds[17];
                        $value->minimum_redemption_qty          =  $funds[18];
                        $value->redemption_qty_multiplier       =  $funds[19];
                        $value->maximum_redemption_qty          =  $funds[20];
                        $value->redemption_amount_minimum       =  $funds[21];
                        $value->redemption_amount_maximum       =  $funds[22];
                        $value->redemption_amount_multiple      =  $funds[23];
                        $value->redemption_cutoff_time          =  $funds[24];
                        $value->rta_agent_code                  =  $funds[25];
                        $value->amc_active_flag                 =  $funds[26];
                        $value->dividend_reinvestment_flag      =  $funds[27];
                        $value->sip_flag                        =  $funds[28];
                        $value->stp_flag                        =  $funds[29];
                        $value->swp_flag                        =  $funds[30];
                        $value->switch_flag                     =  $funds[31];
                        $value->settlement_type                 =  $funds[32];
                        $value->amc_ind                         =  $funds[33];
                        $value->face_value                      =  $funds[34];
                        $value->start_date                      =  $funds[35];
                        $value->end_date                        =  $funds[36];
                        $value->exit_load_flag                  =  $funds[37];
                        $value->exit_load                       =  $funds[38];
                        $value->lockin_period_flag              =  $funds[39];
                        $value->lockin_period                   =  $funds[40];
                        $value->channel_partner_code            =  $funds[41];
                        $value->reopening_date                  =  $funds[42];
                        $value->save();
                    }
                }
            }
        }
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
