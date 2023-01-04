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

        $response       =   Http::get('https://api.morningstar.com/v2/service/mf/fokr7wm4cxjcrc6v/universeid/i9t7jgix6xje3x87?accesscode=egfnfxsxo1rklo0z0su56i9htuu2j49y&format=json');
        // print_r('<pre>');
        $data           =   json_decode($response, true);
        print_r($data);
        die;
        if ($data['status']['message'] == "OK") {


            foreach ($data['data'] as $value) {
                if(key_exists('api', $value)) {

                    if(key_exists('FM-Managers', $value['api'])){
                        foreach ($value['api']['FM-Managers'] as $row) {
                            $this->stores($value, $row);
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
