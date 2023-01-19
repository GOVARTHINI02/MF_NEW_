<?php

namespace App\Traits;

use App\Models\MfLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Http;

 trait MfTrait {

    public function edit()
    {
        $response = Http::asForm()->withHeaders([
            'Connection'    => 'keep-alive',
            'Content-Type'  => 'application/x-www-form-urlencoded'
        ])->post('https://mwareuat.aliceblueonline.com:8443/realms/back-office-middleware-realm/protocol/openid-connect/token', [

            'client_id'     => 'back-office-middleware',
            'client_secret' => 'o8xFjtAYhLDyQGrMc6DLDVj7QuKasjjt',
            'scope'         =>  'openid offline_access',
            'grant_type'    => 'client_credentials',
        ]);

        $token              =   new MfLogin;
        $token->token       =   $response['access_token'];
        $token->login_at    =   Carbon::now();
        $token->expiary_at  =   Carbon::today()->addHours(12);
        $token->save();
        return $response['access_token'];

       
    }





 }
