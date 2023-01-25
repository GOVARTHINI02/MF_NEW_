<?php

namespace App\Http\Controllers;

use App\Mail\ErrorMail;
use App\Mail\Exception;
use App\Models\AmcBasicInfo;

use App\Models\AnnualReportFees;
use App\Models\AnnualReportFinancial;
use App\Models\FeeSchedule;
use App\Models\FundBasicInfo;
use App\Models\FundBenchmarks;
use App\Models\FundManager;
use App\Models\FundNetAsset;
use App\Models\HistoricNav;
use App\Models\HistoricNavs;
use App\Models\InvestmentCriteria;
use App\Models\MfLogin;
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
use App\Traits\MfTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MFController extends Controller
   
{

    use MfTrait;
    /**
     * 
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
       
        Log::info('Annual report fees - start');
        
        try {
            
            $response   =   Http::withToken($this->edit())->get('https://middleware.aliceblueonline.com:8181/mstar/annualReportFees');
            $data       =   json_decode($response, true);

            if ($data['status']['message'] == "OK") {

                foreach ($data['data'] as $value) {

                    if (key_exists('api', $value)) {
                        $details                            =   new AnnualReportFees;
                        $details->MStarID                   =   $value['api']['DP-MStarID'] ?? null;
                        $details->ISIN                      =   $value['api']['DP-ISIN'] ?? null;
                        $details->AnnualReportDate          =   $value['api']['ARF-AnnualReportDate'] ?? null;
                        $details->NetExpenseRatio           =   $value['api']['ARF-NetExpenseRatio'] ?? null;
                        $details->InterimNetExpenseRatio    =   $value['api']['ARF-InterimNetExpenseRatio'] ?? null;
                        $details->save();
                    }
                }

                AnnualReportFees::where('created_at', '<', Carbon::today())->delete();
            } else {
                Log::info('Annual report fees - error' . $response);
            }
        
        } catch (\Throwable $th) {
            $schedule = "Annual Report Fees";
            Log::info($th);
            AnnualReportFees::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Annual report fees - end');
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
        // $count = [];
        foreach ($array  as  $key => $val) {
            if ($val) {
                $funds = (explode("|", $val));
         
                if ($funds[7] == 'DIRECT'  &&  $funds[9] == 'Y' &&  ($funds[10] == 'DP' || $funds[10] == 'D') && ($funds[15] == '13:00:00' || $funds[15] == '14:30:00' || $funds[15] == '15:00:00') && ($funds[17] == 'D' || $funds[17] == 'DP') &&  ($funds[27] == 'N' || $funds[27] == 'Z') &&  ($funds[5] != 'NJMUTUALFUND_MF' || $funds[5] != 'SAMCOMUTUALFUND_MF' || $funds[5] != 'TRUSTMUTUALFUND_MF')) {
                    
                    //   if($key != 0){
                        // $count[]    =   $funds[7];
                    //   }
                    if ($key != 0) {
                            $value                                  =  new SchemaMaster;
                            $value->unique_no                       =  $funds[0];
                            $value->scheme_code                     =  $funds[1];
                            $value->rta_scheme_code                 =  $funds[2];
                            $value->amc_scheme_code                 =  $funds[3];
                            $value->isin                            =  $funds[4];
                            $value->amc_code                        =  $funds[5];
                            $value->scheme_type                     =  $funds[6];
                            $value->scheme_plan                     =  $funds[7];
                            $value->scheme_name                     =  $funds[8];
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
                            $value->lock_in_period_flag             =  $funds[39];
                            $value->lock_in_period                  =  $funds[40];
                            $value->channel_partner_code            =  $funds[41];
                            $value->reOpeningDate                   =  $funds[42];
                           // log::info($value);
                            $value->save();                      
                    }
                }
            }
        }

        // return count($count);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $file = storage_path('mffile.txt');
        $myfile = fopen($file, "r")  or die("Unable to open file!");
        $fund =   fread($myfile, filesize($file));
        fclose($myfile);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL   => 'https://bsestarmf.in/RptSettlementMaster.aspx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('__VIEWSTATE' => $fund, '__VIEWSTATEGENERATOR' =>  'B6D58731', '__EVENTVALIDATION' =>
            'X0nuY49Lz+QRB5EJh/+j8LbWaMZX0iSF4cXvNDzFXBjqyFsSrsykiZHktI9a+qqtEr30Qf1rpmigFf5lTNX4uvmglvufKWFRhUjixE9jN5tLkFImGgNm2vEcEarp+fi4GgQfx3uJiD59ecP0', 'btnText' => 'Export to Text'),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Length:6777172'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response;
        print_r($response);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function edit()
//     {
//           $response = Http::asForm()->withHeaders([
//         'Connection'    => 'keep-alive',
//         'Content-Type'  => 'application/x-www-form-urlencoded'
//     ])->post('https://mwareuat.aliceblueonline.com:8443/realms/back-office-middleware-realm/protocol/openid-connect/token', [
// 
//         'client_id'     => 'back-office-middleware',
//         'client_secret' => 'o8xFjtAYhLDyQGrMc6DLDVj7QuKasjjt',
//         'scope'         =>  'openid offline_access',
//         'grant_type'    => 'client_credentials',
//     ]);
// 
//         $token         =   MfLogin::updateOrCreate(
//     
//         [
//             'token'         =>   ($response['access_token'])
//         ],
//         [
//             'login_at' =>   Carbon::now(),
//             'expiary_at' => Carbon::today()->addHours(12)
//         ]
// 
//     );
//     // $flight = Flight::updateOrCreate(
//     //     ['departure' => 'Oakland', 'destination' => 'San Diego'],
//     //     ['price' => 99, 'discounted' => 1]
//     // );
//    
//     return $response['access_token'];
// 
// }
     

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
