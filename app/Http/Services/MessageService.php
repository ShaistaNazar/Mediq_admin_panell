<?php

namespace App\Http\Services;

use SendSMS;
class MessageService
{
    public $client;
    public $errorMessages = [];
    protected $planetbeyondApiUrl = "https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=923456899831&password=Waqaskhanpitafidevbatch123";
    protected $planetbeyondApiSendSmsUrl="https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id=#session_id#&to=#to_number#&text=#message_to_send#";
    // Please provide correct username and password here of your account
    
    /**
     * @param \MessageBird\Client $client
     * @return void
     */
    public function __construct(\MessageBird\Client $client)
    {
        $this->client = $client;
        $this->errorMessages = $this->getSessionId();
    }

    /**
     *
     * @param $originator
     * @param $recipients
     * @param $body
     * @return string
     */
  
        /**
         *   Returns sessionId required to send quick message
        */
        public function getSessionId()
        {
            
            
            $response = $this->sendApiCall($this->planetbeyondApiUrl);

            if($response && substr($response->response,0,5)!=="Error")
            {
                
                return $response->data;
            }

            return -1;
        }
        // public function yasir()
        // {
        //    return  $this->getSessionId();
        // }

        /**
        * Sends Quick message
        */
        public function sendSmsMessage($messageText, $toNumbersCsv)
        {
          
            $mask = "Home%20Medics";
            $sessionKey = $this->getSessionId();

            $url=str_replace("#message_to_send#", urlencode($messageText), $this->planetbeyondApiSendSmsUrl);

            $url=str_replace("#to_number#",$toNumbersCsv,$url);
           
            $urlWithSessionKey=str_replace("#session_id#",$sessionKey,$url);

            if($mask!=null)
            {
                $urlWithSessionKey = $urlWithSessionKey . "&mask=" . $mask;
            }

            $xml = $this->sendApiCall($urlWithSessionKey);

            return $xml->data;
        }

        /**
        * Sends Http request to api
        */
        public function sendApiCall($url)
        {
            
            $response = file_get_contents($url);
            $xml = simplexml_load_string($response) or die("Error: Cannot create object");

            if($xml && !empty($xml->response))
            {

                return $xml;
            }
            return "";
        }
}
