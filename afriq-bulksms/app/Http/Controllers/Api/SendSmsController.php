<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

//models
use App\Models\SmsReport;
use App\Models\SmsLog;

function checkDestinationFile($destination_file)
{
    $contacts = [];
    $filePath = Storage::path('public/' . $destination_file);
    // dd($filePath);
    $reader = SimpleExcelReader::create($filePath)->getRows();
    foreach ($reader as $row) {
        array_push($contacts, $row['phone_number']);
    }
    //URL-encode comma as %2C
    $data = implode('%2C', $contacts);
    return $data;
}
function sendScheduled($type, $source, $destination, $message, $scheduled)
{
    $date = date('m/d/y', strtotime($scheduled));
    $time = date('h:i A', strtotime($scheduled));
    $app_url = config('app.url');
    $app_username = config('app.username');
    $app_password = config('app.password');
    if ($type == 0 || 1) {
        try {
            $text = $app_url . "bulksms?username=" . $app_username . "&password=" . $app_password . "&type=12&destination=" . $destination . "&source=" . $source . "&message=" . $message . "&dlr=sasd&date=" . $date . "&time=" . $time . "&gmt=GMT +3";
            $url = str_replace(' ', '%20', $text);
            $schedule = new Schedule();
            $schedule->call(function () use ($url) {
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


                if ($http_status == '404') {
                    return "Failed to connect to the server";
                }

                $code = explode("|", $response);

                if ($code[0] == '1701') {
                    return 'success';
                }
                if ($code[0] == '1702') {
                    return 'Invalid URL.';
                }
                if ($code[0] == '1703') {
                    return 'Invalid value in username or password parameter.';
                }
                if ($code[0] == '1025') {
                    return 'Insufficient credit';
                }
                if ($code[0] == '1705') {
                    return 'Invalid message';
                }
                if ($code[0] == '1706') {
                    return 'Invalid destination';
                }
                if ($code[0] == '1707') {
                    return 'Invalid source';
                }
                if ($code[0] == '1704') {
                    return 'Invalid message type.';
                }
            })
                ->timezone('Africa/Nairobi')
                ->at(strval($time . $date));
            $output = \Illuminate\Support\Facades\Artisan::call('schedule:run');
            // \Illuminate\Support\Facades\Artisan::output(); // Get the output of the command
            return $output;
        } catch (Exception $e) {
            return "Failed:" . $e->getMessage();
        }
    }
    if ($type == 2 || 6) {
        try {
            $data = bin2hex($message);

            // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
            $url = strval($app_url . "bulksms?username=" . $app_username . "&password=" . $app_password . "&type=" . $type . "&destination=" . $destination . "&source=" . $source . "&message=" . $data . "&dlr=1&date=" . $date . "&time=" . $time . "&gmt=GMT +3");
            $schedule = new Schedule();
            $schedule->call(function () use ($url) {
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
                if ($http_status == '404') {
                    return "Failed to connect to the server";
                }
                $code = explode("|", $response);
                if ($code[0] == '1701') {
                    return 'success';
                }
                if ($code[0] == '1702') {
                    return 'Invalid URL.';
                }
                if ($code[0] == '1703') {
                    return 'Invalid value in username or password parameter.';
                }
                if ($code[0] == '1025') {
                    return 'Insufficient credit';
                }
                if ($code[0] == '1705') {
                    return 'Invalid message';
                }
                if ($code[0] == '1706') {
                    return 'Invalid destination';
                }
                if ($code[0] == '1707') {
                    return 'Invalid source';
                }
                if ($code[0] == '1704') {
                    return 'Invalid message type.';
                }
            })
                ->timezone('Africa/Nairobi')
                ->at(strval($time . $date));
            $output = \Illuminate\Support\Facades\Artisan::call('schedule:run');
            // \Illuminate\Support\Facades\Artisan::output(); // Get the output of the command
            return $output;
        } catch (Exception $e) {
            return "Failed:" . $e->getMessage();
        }
    }
}

function sendNow($type, $source, $destination, $message)
{


    $sms_id = '';
    $api_url = env('BULKSMS_API_URL');
    $bulksms_username = env('BULKSMS_USERNAME');
    $bulksms_password = env('BULKSMS_PASSWORD');
    if ($type == 0 || 1) {
        try {

            $text = $api_url . "bulksms?username=" . $bulksms_username . '&password=' . $bulksms_password . "&type=" . $type . "&destination=" . $destination . "&source=" . $source . "&message=" . $message . "&dlr=1";
            $url = str_replace(' ', '%20', $text);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $check_error = curl_errno($ch);
            curl_close($ch);

            if ($http_status == '404') {
                return "Failed to connect to the server";
            }
            $code = explode("|", $response);

            if ($code[0] == '1701') {
                return logSms($code = 1701, $message = 'Sucess', $sms_id, $source);
            }
            if ($code[0] == '1702') {
                return logSms($code = 1702, $message = 'Invalid URL', $sms_id, $source);
            }
            if ($code[0] == '1703') {
                return logSms($code = 1703, $message = 'Invalid value in username or password parameter.', $sms_id = 1, $source);
            }
            if ($code[0] == '1025') {
                Log::info('code is ' . $code[0]);
                return logSms($code = 1025, $message = 'Insufficient credit', $sms_id, $source);
            }
            if ($code[0] == '1705') {
                return logSms($code = 1705, $message = 'Invalid message', $sms_id, $source);
            }
            if ($code[0] == '1706') {
                return logSms($code = 1706, $message = 'Invalid destination', $sms_id, $source);
            }
            if ($code[0] == '1707') {
                return logSms($code = 1707, $message = 'Invalid Source', $sms_id, $source);
            }
            if ($code[0] == '1704') {
                return logSms($code = 1704, $message = 'Invalid message type', $sms_id, $source);
            }
        } catch (Exception $e) {
            return "Failed:" . $e->getMessage();
        }
    }
    if ($type == 2 || 6) {
        try {
            $data = bin2hex($message);

            // $text = mb_convert_encoding($data, 'UTF-16BE', 'UTF-8');
            $url = strval($api_url . "bulksms?username=" . $bulksms_username . "&password=" . $bulksms_password . "&type=" . $type . "&destination=" . $destination . "&source=" . $source . "&message=" . $data . "&dlr=1");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $response = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($http_status == '404') {
                return "Failed to connect to the server";
            }
            $code = explode("|", $response);

            if ($code[0] == '1701') {
                return logSms($code = 1701, $message = 'Sucess', $sms_id, $source);
            }
            if ($code[0] == '1702') {
                return logSms($code = 1702, $message = 'Invalid URL', $sms_id, $source);
            }
            if ($code[0] == '1703') {
                return logSms($code = 1703, $message = 'Invalid value in username or password parameter.', $sms_id = 1, $source);
            }
            if ($code[0] == '1025') {
                return logSms($code = 1025, $message = 'Insufficient credit', $sms_id, $source);
            }
            if ($code[0] == '1705') {
                return logSms($code = 1705, $message = 'Invalid message', $sms_id, $source);
            }
            if ($code[0] == '1706') {
                return logSms($code = 1706, $message = 'Invalid destination', $sms_id, $source);
            }
            if ($code[0] == '1707') {
                return logSms($code = 1707, $message = 'Invalid Source', $sms_id, $source);
            }
            if ($code[0] == '1704') {
                return logSms($code = 1704, $message = 'Invalid message type', $sms_id, $source);
            }
        } catch (Exception $e) {
            return "Failed:" . $e->getMessage();
        }
    }
}

class SendSmsController extends Controller
{
    public function sendSms($type = "12", $source = "", $destination = "", $message = "", $scheduled = "", $destination_file = null)
    {
        if ($scheduled !== null) {
            if ($destination_file) {
                $destination = checkDestinationFile($destination_file);
                $textSend = sendScheduled($type, $source, $destination, $message, $scheduled);
                return $textSend;
            } else {
                $textSend = sendScheduled($type, $source, $destination, $message, $scheduled);
                return $textSend;
            }
        } else {
            if ($destination_file) {
                $destination = checkDestinationFile($destination_file);
                $textSend = sendNow($type, $source, $destination, $message);
                return $textSend;
            } else {
                $textSend = sendNow($type, $source, $destination, $message);
                return $textSend;
            }
        }
    }
}
function logSms($code, $sms_status, $sms_id, $source)
{
    $report = SmsLog::create([
        'code' => $code,
        'sms_status' => $sms_status,
        'sms_id' => 1,
        'sender_id' => $source
    ]);

    return $report;
}
