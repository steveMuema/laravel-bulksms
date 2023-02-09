<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;
use BenMorel\GsmCharsetConverter\Converter;
use Exception;

class SendSmsController extends Controller
{
    
    public function sendSms($type, $source, $destination, $message, $schedule) {
        // $sms = Sms::all();
        // foreach($sms as $msg) 
        if($schedule){
            try
            {
                if($type == 0 || 1){
                    $text = "http://rslr.connectbind.com/bulksms/schedulemsg?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$message."&dlr=1";
                    $url = str_replace(' ', '%20', $text);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);

                    curl_close($ch);

                    $data = array();
                    $record = explode("\n",$response);
                    foreach($record as $r){
                    $r = str_replace("\t"," ",$r);
                    $isi = explode("|",$r);
                    array_push($data, $isi);

                    }
                    $arr = [];
                    foreach($data as $sms){
                        if(isset($sms[1])){
                            $arr[] = [
                                'response_code' => $sms[0],
                                'phone_number' => $sms[1],
                                'sent_sms_id' => $sms[2]
                            ];
                        }
                    }                
                    foreach($arr as $code){
                        if(isset($code[0]) == 1701){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'success']
                            );
                        }
                        if(isset($code[0]) == 1702){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'Invalid URL.']
                            );
                        }
                        if(isset($code[0]) == 1703){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid value in username or password parameter.']
                            );
                        }
                        if(isset($code[0]) == 1025){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Insufficient credit']
                            );
                        }
                        if(isset($code[0]) == 1705){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid message']
                            );
                        }
                        if(isset($code[0]) == 1706){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid destination']
                            );
                        }
                        if(isset($code[0]) == 1707){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid source']
                            );
                        }
                    }
                }
                if($type == 2 || 6){
                    $data = bin2hex($message);

                    // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
                    $url = strval("http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$data."&dlr=1");
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);

                    curl_close($ch);
                    $data = array();
                    $record = explode("\n",$response);
                    foreach($record as $r){
                    $r = str_replace("\t"," ",$r);
                    $isi = explode("|",$r);
                    array_push($data, $isi);

                    }
                    $arr = [];
                    foreach($data as $sms){
                        if(isset($sms[1])){
                            $arr[] = [
                                'response_code' => $sms[0],
                                'phone_number' => $sms[1],
                                'sent_sms_id' => $sms[2]
                            ];
                        }
                    }                
                    foreach($arr as $code){
                        if(isset($code[0]) == 1701){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'success']
                            );
                        }
                        if(isset($code[0]) == 1702){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'Invalid URL.']
                            );
                        }
                        if(isset($code[0]) == 1703){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid value in username or password parameter.']
                            );
                        }
                        if(isset($code[0]) == 1025){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Insufficient credit']
                            );
                        }
                        if(isset($code[0]) == 1705){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid message']
                            );
                        }
                        if(isset($code[0]) == 1706){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid destination']
                            );
                        }
                        if(isset($code[0]) == 1707){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid source']
                            );
                        }
                    }
                    // return mb_convert_encoding($data, 'UTF-8', 'UTF-16BE');
                    
                }
            }
            catch(Exception $e) {
                return 'error' .$e->getMessage();
            }
        }
        else {
            try
            {
                if($type == 0 || 1){
                    $text = "http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$message."&dlr=1";
                    $url = str_replace(' ', '%20', $text);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);

                    curl_close($ch);

                    $data = array();
                    $record = explode("\n",$response);
                    foreach($record as $r){
                    $r = str_replace("\t"," ",$r);
                    $isi = explode("|",$r);
                    array_push($data, $isi);

                    }
                    $arr = [];
                    foreach($data as $sms){
                        if(isset($sms[1])){
                            $arr[] = [
                                'response_code' => $sms[0],
                                'phone_number' => $sms[1],
                                'sent_sms_id' => $sms[2]
                            ];
                        }
                    }                
                    foreach($arr as $code){
                        if(isset($code[0]) == 1701){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'success']
                            );
                        }
                        if(isset($code[0]) == 1702){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'Invalid URL.']
                            );
                        }
                        if(isset($code[0]) == 1703){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid value in username or password parameter.']
                            );
                        }
                        if(isset($code[0]) == 1025){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Insufficient credit']
                            );
                        }
                        if(isset($code[0]) == 1705){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid message']
                            );
                        }
                        if(isset($code[0]) == 1706){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid destination']
                            );
                        }
                        if(isset($code[0]) == 1707){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid source']
                            );
                        }
                    }
                }
                if($type == 2 || 6){
                    $data = bin2hex($message);

                    // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
                    $url = strval("http://rslr.connectbind.com/bulksms/bulksms?username=qnet-oneconnect&password=Onec0nn!&type=".$type."&destination=".$destination."&source=".$source."&message=".$data."&dlr=1");
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);

                    curl_close($ch);
                    $data = array();
                    $record = explode("\n",$response);
                    foreach($record as $r){
                    $r = str_replace("\t"," ",$r);
                    $isi = explode("|",$r);
                    array_push($data, $isi);

                    }
                    $arr = [];
                    foreach($data as $sms){
                        if(isset($sms[1])){
                            $arr[] = [
                                'response_code' => $sms[0],
                                'phone_number' => $sms[1],
                                'sent_sms_id' => $sms[2]
                            ];
                        }
                    }                
                    foreach($arr as $code){
                        if(isset($code[0]) == 1701){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'success']
                            );
                        }
                        if(isset($code[0]) == 1702){
                            return response()->json([
                                'code'=> 200,
                                'status' => 'Invalid URL.']
                            );
                        }
                        if(isset($code[0]) == 1703){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid value in username or password parameter.']
                            );
                        }
                        if(isset($code[0]) == 1025){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Insufficient credit']
                            );
                        }
                        if(isset($code[0]) == 1705){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid message']
                            );
                        }
                        if(isset($code[0]) == 1706){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid destination']
                            );
                        }
                        if(isset($code[0]) == 1707){
                            return response()->json([
                                'code'=> 500,
                                'status' => 'Invalid source']
                            );
                        }
                    }
                    // return mb_convert_encoding($data, 'UTF-8', 'UTF-16BE');
                    
                }
            }
            catch(Exception $e) {
                return 'error' .$e->getMessage();
            }
        }
    }
}