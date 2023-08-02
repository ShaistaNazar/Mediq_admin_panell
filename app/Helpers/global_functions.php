<?php
use Illuminate\Support\Facades\Log;
function sendSms($mobile , $message){
    
    $mobile = $mobile ;
    $sender = "Devbatch";
    $message = $message;
    $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
    $url = "http://sendpk.com/api/sms.php?username=923018428882&password=5368";
    $ch = curl_init();
    $timeout = 30; 
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $result = curl_exec($ch);
    if (preg_match("/OK/", $result))
        {
            Log::channel('message')->info('Message sent '.$result);
           
        }else
        {
            Log::channel('message')->error('Message not sent '.$result);
        }
    return;
    }

    function responseMsg($rescode , $message , $param , $values){
        return response()->json([ 
            'ResponseHeader' => [
                'ResponseCode' => $rescode,
                'ResponseMessage' =>  $message,
                $param =>  $values
            ]
                ], 200);
        }
?>