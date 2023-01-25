<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\SchemaMaster;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SchemeMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature ='scheme-master';

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
        Log::info('Scheme Master - Start');

        try {

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
            $response;
            $array =  explode("\n", $response);
            foreach ($array  as  $key => $val) {
                if ($val) {
                    $funds = (explode("|", $val));

                    if ($funds[7] == 'DIRECT'  &&  $funds[9] == 'Y' &&  ($funds[10] == 'DP' || $funds[10] == 'D') && ($funds[15] == '13:00:00' || $funds[15] == '14:30:00' || $funds[15] == '15:00:00') && ($funds[17] == 'D' || $funds[17] == 'DP') &&  ($funds[27] == 'N' || $funds[27] == 'Z') &&  ($funds[5] != 'NJMUTUALFUND_MF' || $funds[5] != 'SAMCOMUTUALFUND_MF' || $funds[5] != 'TRUSTMUTUALFUND_MF')) {
                       
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
                            $value->save();
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            $schedule       =   'Scheme Master';
            Log::info($th);         
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }

        Log::info('Scheme Master - End');
    }
}
