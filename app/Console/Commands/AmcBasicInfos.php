<?php

namespace App\Console\Commands;

use App\Mail\ErrorMail;
use App\Models\AmcBasicInfo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AmcBasicInfos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amc-basic-info';

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
        Log::info('Amc Basic Info - start');
        try {

            $response       =   Http::get('https://api.morningstar.com/v2/service/mf/dctlquvshh3f2yvo/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');

            $data           =   json_decode($response, true);



            if ($data['status']['message'] == "OK") {


                foreach ($data['data'] as $value) {

                    $i = 0;

                    if (key_exists('api', $value)) {


                        $auditor    =   count($value['api']['AMCBI-AuditorCompanies'] ?? []);
                        $custodian  =   count($value['api']['AMCBI-CustodianCompanies'] ?? []);

                        $count      =   $auditor > $custodian ? $auditor :  $custodian;
                        do {

                            $details                                    =   new AmcBasicInfo;
                            $details->MStarID                           =   $value['api']['DP-MStarID'] ?? null;
                            $details->Admin_CompanyID                   =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyID'] ?? null;
                            $details->Admin_CompanyName                 =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null;
                            $details->Admin_CompanyCity                 =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null;
                            $details->Admin_CompanyProvince             =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null;
                            $details->Admin_CompanyCountry              =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null;
                            $details->Admin_CompanyPostalCode           =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null;
                            $details->Admin_CompanyAddress              =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null;

                            $details->Advisor_CompanyID                 =   $value['api']['AMCBI-AdvisorListCountryHeadquarter'][0]['CompanyID'] ?? null;
                            $details->Advisor_CompanyName               =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null;
                            $details->Advisor_CompanyCity               =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null;
                            $details->Advisor_CompanyProvince           =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null;
                            $details->Advisor_CompanyCountry            =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null;
                            $details->Advisor_CompanyPostalCode         =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null;
                            $details->Advisor_CompanyAddress            =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null;

                            $details->Auditor_CompanyID                 =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyID'] ?? null;
                            $details->Auditor_CompanyName               =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyName'] ?? null;
                            $details->Auditor_CompanyCity               =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyCity'] ?? null;
                            $details->Auditor_CompanyProvince           =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyProvince'] ?? null;
                            $details->Auditor_CompanyCountry            =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyCountry'] ?? null;
                            $details->Auditor_CompanyPostalCode         =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyPostalCode'] ?? null;
                            $details->Auditor_CompanyAddress            =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyAddress'] ?? null;

                            $details->Custodian_CompanyID               =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyID'] ?? null;
                            $details->Custodian_CompanyName             =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyName'] ?? null;
                            $details->Custodian_CompanyCity             =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyCity'] ?? null;
                            $details->Custodian_CompanyProvince         =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyProvince'] ?? null;
                            $details->Custodian_CompanyCountry          =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyCountry'] ?? null;
                            $details->Custodian_CompanyPostalCode       =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyPostalCode'] ?? null;
                            $details->Custodian_CompanyAddress          =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyAddress'] ?? null;

                            $details->Distributor_CompanyID             =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyID'] ?? null;
                            $details->Distributor_CompanyName           =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyName'] ?? null;
                            $details->Distributor_CompanyCity           =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCity'] ?? null;
                            $details->Distributor_CompanyProvince       =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyProvince'] ?? null;
                            $details->Distributor_CompanyCountry        =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCountry'] ?? null;
                            $details->Distributor_CompanyPostalCode     =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyPostalCode'] ?? null;
                            $details->Distributor_CompanyAddress        =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyAddress'] ?? null;

                            $details->Provider_CompanyID                =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyID'] ?? null;
                            $details->Provider_CompanyName              =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyName'] ?? null;
                            $details->Provider_CompanyCity              =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCity'] ?? null;
                            $details->Provider_CompanyProvince          =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyProvince'] ?? null;
                            $details->Provider_CompanyCountry           =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCountry'] ?? null;
                            $details->Provider_CompanyPostalCode        =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyPostalCode'] ?? null;
                            $details->Provider_CompanyAddress           =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyAddress'] ?? null;

                            $details->Registration_AddressLine1         =   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine1'] ?? null;
                            $details->Registration_AddressLine2         =   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine2'] ?? null;
                            $details->Registration_City                 =   $value['api']['AMCBI-RegistrationCompanies'][0]['City'] ?? null;
                            $details->Registration_CompanyId            =   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyID'] ?? null;
                            $details->Registration_CompanyName          =   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyName'] ?? null;
                            $details->Registration_CountryId            =   $value['api']['AMCBI-RegistrationCompanies'][0]['CountryId'] ?? null;
                            $details->Registration_Fax                  =   $value['api']['AMCBI-RegistrationCompanies'][0]['Fax'] ?? null;
                            $details->Registration_Homepage             =   $value['api']['AMCBI-RegistrationCompanies'][0]['Homepage'] ?? null;
                            $details->Registration_Phone                =   $value['api']['AMCBI-RegistrationCompanies'][0]['Phone'] ?? null;
                            $details->Registration_PostalCode           =   $value['api']['AMCBI-RegistrationCompanies'][0]['PostalCode'] ?? null;
                            $details->Registration_Province             =   $value['api']['AMCBI-RegistrationCompanies'][0]['Province'] ?? null;

                            $details->Transfer_CompanyID                =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyID'] ?? null;
                            $details->Transfer_CompanyName              =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyName'] ?? null;
                            $details->Transfer_CompanyCity              =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCity'] ?? null;
                            $details->Transfer_CompanyProvince          =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyProvince'] ?? null;
                            $details->Transfer_CompanyCountry           =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCountry'] ?? null;
                            $details->Transfer_CompanyPostalCode        =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyPostalCode'] ?? null;
                            $details->Transfer_CompanyAddress           =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyAddress'] ?? null;
                            $details->save();

                            $i++;
                        } while ($count > $i);
                    }
                }
                AmcBasicInfo::where('created_at', '<', Carbon::today())->delete();
            }else{
                Log::info('Amc Basic Info - error' . $response);
              
            }
           
        }  catch (\Throwable $th) {
            $schedule   = 'Amc-Basic-Info';
            Log::info($th);
            AmcBasicInfo::whereDate('created_at', Carbon::today())->delete();
            Mail::to('priyachaubey@aliceblueindia.com')->send(new ErrorMail($schedule));
        }
        Log::info('Amc Basic Info - end');
    }

}