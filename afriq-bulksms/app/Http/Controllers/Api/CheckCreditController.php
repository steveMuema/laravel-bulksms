<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Exception;

class CheckCreditController extends Controller
{
    function checkCredit() {
        $app_url = config('app.url');
        $app_username = env('APP_USERNAME');
        $app_password = env('APP_PASSWORD');
        try{
            $url = $app_url."/CreditCheck/checkcredits?username=".$app_username."&password=".$app_password;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            $response = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($http_status == '404') {
                return "Failed to connect to the server";
            }
            $balance = explode(":", $response);
            if($response == 'AUTHORIZATION_FAILED'){
                return 'User is inactive or the credentials provided (username or password or both) are wrong.';
            }
            if($balance[0] == 'BALANCE'){
                return $balance[1];
            }
            if($response == 'INVALID_URL'){
                return 'Username or Password or both are incorrect.';
            }
            if($balance[0] == 'INTERNAL_ERROR'){
                return 'Cannot fetch credit balance.';
            }
            if($balance[0] == 'PERMISSION_DENIED'){
                return 'You have reached the maximum number of allowed hits.';
            }
        }catch (Exception $e){
            return "Failed:".$e->getMessage();
        } 
    }
}