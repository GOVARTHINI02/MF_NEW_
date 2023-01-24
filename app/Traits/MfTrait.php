<?php

namespace App\Traits;

use App\Models\MfLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

trait MfTrait
{

    public function createToken(){
        
        $response = Http::asForm()->withHeaders([
            'Connection'    => 'keep-alive',
            'Content-Type'  => 'application/x-www-form-urlencoded'
        ])->post('https://mwareuat.aliceblueonline.com:8443/realms/back-office-middleware-realm/protocol/openid-connect/token', [

            'client_id'     => 'back-office-middleware',
            'client_secret' => 'o8xFjtAYhLDyQGrMc6DLDVj7QuKasjjt',
            'scope'         =>  'openid offline_access',
            'grant_type'    => 'client_credentials',
        ]);

        $token  =   MfLogin::first();

        if(!$token){

            $token  =   new MfLogin;
        }
        
        $token->token       =   $response['access_token'];
        $token->login_at    =   Carbon::now();
        $token->expiary_at  =   Carbon::now()->addHours(12);
        $token->save();
        return $response['access_token'];

    }

    public function accesstoken()
    {
        $fund =   MfLogin::first();
    
        if ($fund) {

            if (Carbon::now() < $fund->expiary_at) {
             
                return $fund->token;
                
            } else {
               
                return $this->createToken();
            }
        }else{
          
           return $this->createToken();

        }
    }
}

