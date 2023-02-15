<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Exception;

class SendSmsController extends Controller
{
    public function sendSms($type="1", $source="AFRIQNET", $destination="254708357878", $message="HI4", $schedule="false", $scheduled=" ") {
        if($schedule == 'true'){
            $date = date('m/d/y', strtotime($scheduled));
            $time = date('h:i A', strtotime($scheduled));
            if($type == 0 || 1){
                try{
                    $text = "http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=12&destination=".$destination."&source=".$source."&message=".$message."&dlr=sasd&date=".$date."&time=".$time."&gmt=GMT +3";
                    $url = str_replace(' ', '%20', $text);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    if($http_status == '404') {
                        return "Failed to connect to the server";
                    }
                    $code = explode("|",$response);
                    if($code[0] == '1701'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'success']
                        );
                    }
                    if($code[0] == '1702'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'Invalid URL.']
                        );
                    }
                    if($code[0] == '1703'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid value in username or password parameter.']
                        );
                    }
                    if($code[0] == '1025'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Insufficient credit']
                        );
                    }
                    if($code[0] == '1705'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message']
                        );
                    }
                    if($code[0] == '1706'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid destination']
                        );
                    }
                    if($code[0] == '1707'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid source']
                        );
                    }
                    if($code[0] == '1704'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message type.']
                        );
                    }
                
                }catch (Exception $e){
                    return "Failed:".$e->getMessage();
                    
                } 
            }
            if($type == 2 || 6){
                try{
                    $data = bin2hex($message);

                    // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
                    $url = strval("http://rslr.connectbind.com/bulksms/schedulemsg?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$message."&dlr=1&date=".$date."&time=".$time."&gmt=GMT +3");
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    if($http_status == '404') {
                        return "Failed to connect to the server";
                    }
                    $code = explode("|",$response);    
                    if($code[0] == '1701'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'success']
                        );
                    }
                    if($code[0] == '1702'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'Invalid URL.']
                        );
                    }
                    if($code[0] == '1703'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid value in username or password parameter.']
                        );
                    }
                    if($code[0] == '1025'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Insufficient credit']
                        );
                    }
                    if($code[0] == '1705'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message']
                        );
                    }
                    if($code[0] == '1706'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid destination']
                        );
                    }
                    if($code[0] == '1707'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid source']
                        );
                    }
                    if($code[0] == '1704'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message type.']
                        );
                    }
                
                    
                }catch (Exception $e){
                    return "Failed:".$e->getMessage();
                    
                } 
            }
        }
        else {
            if($type == 0 || 1){
                try{
                    $text = "http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$message."&dlr=1";
                    $url = str_replace(' ', '%20', $text);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    if($http_status == '404') {
                        return "Failed to connect to the server";
                    }
                    $code = explode("|",$response);    
                    if($code[0] == '1701'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'success']
                        );
                    }
                    if($code[0] == '1702'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'Invalid URL.']
                        );
                    }
                    if($code[0] == '1703'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid value in username or password parameter.']
                        );
                    }
                    if($code[0] == '1025'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Insufficient credit']
                        );
                    }
                    if($code[0] == '1705'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message']
                        );
                    }
                    if($code[0] == '1706'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid destination']
                        );
                    }
                    if($code[0] == '1707'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid source']
                        );
                    }
                    if($code[0] == '1704'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message type.']
                        );
                    }
                
                    
                }catch (Exception $e){
                    return "Failed:".$e->getMessage();
                    
                } 
            }
            if($type == 2 || 6){
                try{
                    $data = bin2hex($message);

                    // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
                    $url = strval("http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$data."&dlr=1");
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    if($http_status == '404') {
                        return "Failed to connect to the server";
                    }
                    $code = explode("|",$response);    
                    if($code[0] == '1701'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'success']
                        );
                    }
                    if($code[0] == '1702'){
                        return response()->json([
                            'code'=> 200,
                            'status' => 'Invalid URL.']
                        );
                    }
                    if($code[0] == '1703'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid value in username or password parameter.']
                        );
                    }
                    if($code[0] == '1025'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Insufficient credit']
                        );
                    }
                    if($code[0] == '1705'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message']
                        );
                    }
                    if($code[0] == '1706'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid destination']
                        );
                    }
                    if($code[0] == '1707'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid source']
                        );
                    }
                    if($code[0] == '1704'){
                        return response()->json([
                            'code'=> 500,
                            'status' => 'Invalid message type.']
                        );
                    }
                
                    
                }catch (Exception $e){
                    return "Failed:".$e->getMessage();
                    
                } 
            }
        }
    }
}