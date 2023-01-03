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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;

class MFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //     public function new()     {
    // 
    //          $response       =   Http::get('https://api.morningstar.com/v2/service/mf/dctlquvshh3f2yvo/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
    //          print_r('<pre>');
    //         $data           =   json_decode($response, true);
    //         //   print_r($data);
    //         //   die;
    //         if ($data['status']['message'] == "OK") {
    // 
    //             foreach ($data['data'] as $value) {
    // 
    //                 if (key_exists('api', $value)) {
    //                     $common_details = [
    // 
    //                         'MStarID'                       =>   $value['api']['DP-MStarID'] ?? null,
    //                         'Admin_CompanyID'               =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyID'] ?? null,
    //                         'Admin_CompanyName'             =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null,
    //                         'Admin_CompanyCity'             =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null,
    //                         'Admin_CompanyProvince'         =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null,
    //                         'Admin_CompanyCountry'          =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null,
    //                         'Admin_CompanyPostalCode'       =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null,
    //                         'Admin_CompanyAddress'          =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null,
    // 
    //                         'Advisor_CompanyID'             =>   $value['api']['AMCBI-AdvisorListCountryHeadquarter'][0]['CompanyID'] ?? null,
    //                         'Advisor_CompanyName'           =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null,
    //                         'Advisor_CompanyCity'           =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null,
    //                         'Advisor_CompanyProvince'       =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null,
    //                         'Advisor_CompanyCountry'        =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null,
    //                         'Advisor_CompanyPostalCode'     =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null,
    //                         'Advisor_CompanyAddress'        =>   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null,
    // 
    //                         'Distributor_CompanyID'                 =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyID'] ?? null,
    //                         'Distributor_CompanyName'               =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyName'] ?? null,
    //                         'Distributor_CompanyCity'               =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCity'] ?? null,
    //                         'Distributor_CompanyProvince'           =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyProvince'] ?? null,
    //                         'Distributor_CompanyCountry'            =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCountry'] ?? null,
    //                         'Distributor_CompanyPostalCode'         =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyPostalCode'] ?? null,
    //                         'Distributor_CompanyAddress'            =>   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyAddress'] ?? null,
    // 
    //                         'Provider_CompanyID'                   =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyID'] ?? null,
    //                         'Provider_CompanyName'                 =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyName'] ?? null,
    //                         'Provider_CompanyCity'                 =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCity'] ?? null,
    //                         'Provider_CompanyProvince'             =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyProvince'] ?? null,
    //                         'Provider_CompanyCountry'              =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCountry'] ?? null,
    //                         'Provider_CompanyPostalCode'           =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyPostalCode'] ?? null,
    //                         'Provider_CompanyAddress'              =>   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyAddress'] ?? null,
    // 
    //                         'Registration_AddressLine1'            =>   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine1'] ?? null,
    //                         'Registration_AddressLine2'            =>   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine2'] ?? null,
    //                         'Registration_City'                    =>   $value['api']['AMCBI-RegistrationCompanies'][0]['City'] ?? null,
    //                         'Registration_CompanyId'               =>   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyID'] ?? null,
    //                         'Registration_CompanyName'             =>   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyName'] ?? null,
    //                         'Registration_CountryId'               =>   $value['api']['AMCBI-RegistrationCompanies'][0]['CountryId'] ?? null,
    //                         'Registration_Fax'                     =>   $value['api']['AMCBI-RegistrationCompanies'][0]['Fax'] ?? null,
    //                         'Registration_Homepage'                =>   $value['api']['AMCBI-RegistrationCompanies'][0]['Homepage'] ?? null,
    //                         'Registration_Phone'                   =>   $value['api']['AMCBI-RegistrationCompanies'][0]['Phone'] ?? null,
    //                         'Registration_PostalCode'              =>   $value['api']['AMCBI-RegistrationCompanies'][0]['PostalCode'] ?? null,
    //                         'Registration_Province'                =>   $value['api']['AMCBI-RegistrationCompanies'][0]['Province'] ?? null,
    // 
    //                         'Transfer_CompanyID'                   =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyID'] ?? null,
    //                         'Transfer_CompanyName'                 =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyName'] ?? null,
    //                         'Transfer_CompanyCity'                 =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCity'] ?? null,
    //                         'Transfer_CompanyProvince'             =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyProvince'] ?? null,
    //                         'Transfer_CompanyCountry'              =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCountry'] ?? null,
    //                         'Transfer_CompanyPostalCode'           =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyPostalCode'] ?? null,
    //                         'Transfer_CompanyAddress'              =>   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyAddress'] ?? null,
    // 
    //                     ];
    // 
    //                     if (key_exists('AMCBI-AuditorCompanies', $value['api'])) {
    // 
    // 
    //                         foreach ($value['api']['AMCBI-AuditorCompanies']  as  $rows) {
    //                             $new_array = [
    // 
    //                                 'Auditor_CompanyID'             =>   $rows['CompanyID'] ?? null,
    //                                 'Auditor_CompanyName'           =>   $rows['CompanyName'] ?? null,
    //                                 'Auditor_CompanyCity'           =>   $rows['CompanyCity'] ?? null,
    //                                 'Auditor_CompanyProvince'       =>   $rows['CompanyProvince'] ?? null,
    //                                 'Auditor_CompanyCountry'        =>   $rows['CompanyCountry'] ?? null,
    //                                 'Auditor_CompanyPostalCode'     =>   $rows['CompanyPostalCode'] ?? null,
    //                                 'Auditor_CompanyAddress'        =>   $rows['CompanyAddress'] ?? null,
    // 
    //                             ];
    //                         }
    //                     }
    // 
    //                     if (key_exists('AMCBI-CustodianCompanies', $value['api'])) {
    // 
    //                         foreach ($value['api']['AMCBI-CustodianCompanies']  as  $row) {
    // 
    //                             $add_array = [
    //                                 'Custodian_CompanyID'               =>   $row['CompanyID'] ?? null,
    //                                 'Custodian_CompanyName'             =>   $row['CompanyName'] ?? null,
    //                                 'Custodian_CompanyCity'             =>   $row['CompanyCity'] ?? null,
    //                                 'Custodian_CompanyProvince'         =>   $row['CompanyProvince'] ?? null,
    //                                 'Custodian_CompanyCountry'          =>   $row['CompanyCountry'] ?? null,
    //                                 'Custodian_CompanyPostalCode'       =>   $row['CompanyPostalCode'] ?? null,
    //                                 'Custodian_CompanyAddress'          =>   $row['CompanyAddress'] ?? null,
    // 
    //                             ];
    //                         }
    //                     }
    //                 }
    //                 $finalarray[] = array_merge($common_details, $new_array, $add_array);
    // 
    //                 // AmcBasicInfo::insert($finalarray);
    // 
    //             }
    //             print_r('<pre>');
    //             print_r($finalarray);
    //         }    }
    // 
    // public function index()
    //  {

    //         $response       =   Http::get('https://api.morningstar.com/v2/service/mf/dctlquvshh3f2yvo/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
    // 
    //         $data           =   json_decode($response, true);
    // 
    //         
    //         if ($data['status']['message'] == "OK") {
    // 
    //             
    //             foreach ($data['data'] as $value) {
    // 
    //                 $i = 0;
    // 
    //                 if (key_exists('api', $value)) {
    // 
    //                     $auditor    =   count($value['api']['AMCBI-AuditorCompanies']);
    //                     $custodian  =   count($value['api']['AMCBI-CustodianCompanies']);
    // 
    //                     $count      =   $auditor > $custodian ? $auditor :  $custodian;
    //                     
    // 
    //                     do {
    // 
    //                         $details                               =   new AmcBasicInfo;
    //                         $details->MStarID                      =   $value['api']['DP-MStarID'] ?? null;
    //                         $details->Admin_CompanyID              =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyID'] ?? null;
    //                         $details->Admin_CompanyName            =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null;
    //                         $details->Admin_CompanyCity            =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null;
    //                         $details->Admin_CompanyProvince        =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null;
    //                         $details->Admin_CompanyCountry         =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null;
    //                         $details->Admin_CompanyPostalCode      =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null;
    //                         $details->Admin_CompanyAddress         =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null;
    // 
    //                         $details->Advisor_CompanyID            =   $value['api']['AMCBI-AdvisorListCountryHeadquarter'][0]['CompanyID'] ?? null;
    //                         $details->Advisor_CompanyName          =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyName'] ?? null;
    //                         $details->Advisor_CompanyCity          =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCity'] ?? null;
    //                         $details->Advisor_CompanyProvince      =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyProvince'] ?? null;
    //                         $details->Advisor_CompanyCountry       =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyCountry'] ?? null;
    //                         $details->Advisor_CompanyPostalCode    =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyPostalCode'] ?? null;
    //                         $details->Advisor_CompanyAddress       =   $value['api']['AMCBI-AdministratorCompanies'][0]['CompanyAddress'] ?? null;
    // 
    //                         $details->Auditor_CompanyID            =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyID'] ?? null;
    //                         $details->Auditor_CompanyName          =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyName'] ?? null;
    //                         $details->Auditor_CompanyCity          =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyCity'] ?? null;
    //                         $details->Auditor_CompanyProvince      =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyProvince'] ?? null;
    //                         $details->Auditor_CompanyCountry       =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyCountry'] ?? null;
    //                         $details->Auditor_CompanyPostalCode    =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyPostalCode'] ?? null;
    //                         $details->Auditor_CompanyAddress       =   $value['api']['AMCBI-AuditorCompanies'][$i]['CompanyAddress'] ?? null;   
    //                         
    //                         $details->Custodian_CompanyID           =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyID'] ?? null;
    //                         $details->Custodian_CompanyName         =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyName'] ?? null;
    //                         $details->Custodian_CompanyCity         =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyCity'] ?? null;
    //                         $details->Custodian_CompanyProvince     =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyProvince'] ?? null;
    //                         $details->Custodian_CompanyCountry      =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyCountry'] ?? null;
    //                         $details->Custodian_CompanyPostalCode   =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyPostalCode'] ?? null;
    //                         $details->Custodian_CompanyAddress      =   $value['api']['AMCBI-CustodianCompanies'][$i]['CompanyAddress'] ?? null;
    // 
    //                         $details->Distributor_CompanyID                 =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyID'] ?? null;
    //                         $details->Distributor_CompanyName               =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyName'] ?? null;
    //                         $details->Distributor_CompanyCity               =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCity'] ?? null;
    //                         $details->Distributor_CompanyProvince           =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyProvince'] ?? null;
    //                         $details->Distributor_CompanyCountry            =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyCountry'] ?? null;
    //                         $details->Distributor_CompanyPostalCode         =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyPostalCode'] ?? null;
    //                         $details->Distributor_CompanyAddress            =   $value['api']['AMCBI-DistributorCompanies'][0]['CompanyAddress'] ?? null;
    // 
    //                         $details->Provider_CompanyID                   =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyID'] ?? null;
    //                         $details->Provider_CompanyName                 =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyName'] ?? null;
    //                         $details->Provider_CompanyCity                 =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCity'] ?? null;
    //                         $details->Provider_CompanyProvince             =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyProvince'] ?? null;
    //                         $details->Provider_CompanyCountry              =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyCountry'] ?? null;
    //                         $details->Provider_CompanyPostalCode           =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyPostalCode'] ?? null;
    //                         $details->Provider_CompanyAddress              =   $value['api']['AMCBI-ProviderCompanyCountryHeadquarter'][0]['CompanyAddress'] ?? null;
    // 
    //                         $details->Registration_AddressLine1            =   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine1'] ?? null;
    //                         $details->Registration_AddressLine2            =   $value['api']['AMCBI-RegistrationCompanies'][0]['AddressLine2'] ?? null;
    //                         $details->Registration_City                    =   $value['api']['AMCBI-RegistrationCompanies'][0]['City'] ?? null;
    //                         $details->Registration_CompanyId               =   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyID'] ?? null;
    //                         $details->Registration_CompanyName             =   $value['api']['AMCBI-RegistrationCompanies'][0]['CompanyName'] ?? null;
    //                         $details->Registration_CountryId               =   $value['api']['AMCBI-RegistrationCompanies'][0]['CountryId'] ?? null;
    //                         $details->Registration_Fax                     =   $value['api']['AMCBI-RegistrationCompanies'][0]['Fax'] ?? null;
    //                         $details->Registration_Homepage                =   $value['api']['AMCBI-RegistrationCompanies'][0]['Homepage'] ?? null;
    //                         $details->Registration_Phone                   =   $value['api']['AMCBI-RegistrationCompanies'][0]['Phone'] ?? null;
    //                         $details->Registration_PostalCode              =   $value['api']['AMCBI-RegistrationCompanies'][0]['PostalCode'] ?? null;
    //                         $details->Registration_Province                =   $value['api']['AMCBI-RegistrationCompanies'][0]['Province'] ?? null;
    // 
    //                         $details->Transfer_CompanyID                   =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyID'] ?? null;
    //                         $details->Transfer_CompanyName                 =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyName'] ?? null;
    //                         $details->Transfer_CompanyCity                 =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCity'] ?? null;
    //                         $details->Transfer_CompanyProvince             =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyProvince'] ?? null;
    //                         $details->Transfer_CompanyCountry              =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyCountry'] ?? null;
    //                         $details->Transfer_CompanyPostalCode           =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyPostalCode'] ?? null;
    //                         $details->Transfer_CompanyAddress              =   $value['api']['AMCBI-TransferAgentCompanies'][0]['CompanyAddress'] ?? null;
    //                         $details->save();
    // 
    //                         $i++;
    // 
    //                     } while ($count >= $i);
    //                     
    //                     
    //                     
    //                 }
    //             }
    //         
    //     


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $response       =   Http::get('https://api.morningstar.com/v2/service/mf/krpp14z315ydb9bu/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
        //  print_r('<pre>');
        $data           =   json_decode($response, true);
        //    print_r($data);
        //   die;  
        if ($data['status']['message'] == "OK") {


            foreach ($data['data'] as $value) {
                if (key_exists('api', $value)) {
                  
                    if (key_exists('FM-Managers', $value['api'])) {
                        foreach ($value['api']['FM-Managers'] as $row) {
                           $this->stores($value,$row);
                        }
                      
                    }
                }
            }
        }
    }

          function stores($value,$row)
          {

            $details                                =   new FundManager;
            $details->MStarID                       =   $value['api']['DP-MStarID'] ?? null;
            $details->ISIN                          =   $value['api']['DP-ISIN'] ?? null;
            $details->FundManagerTenureAverage      =   $value['api']['FM-FundManagerTenureAverage'] ?? null;
            $details->Display                       =   $row['Display'] ?? null;
            $details->ManagerId                     =   $row['ManagerId'] ?? null;
            $details->Name                          =   $row['Name'] ?? null;
            $details->Role                          =   $row['Role'] ?? null;
            $details->StartDate                     =   $row['StartDate'] ?? null;
            $details->Tenure                        =   $row['Tenure'] ?? null;
            $details->save();

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
