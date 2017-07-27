<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laravelpackage\Twilio;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException,
    ConfigurationException,
    DeserializeException,
    EnvironmentException,
    HttpException,
    RestException,
    TwimlException;

class Twilio implements TwilioInterface{

    protected $token;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var bool
     */
    protected $sslVerify;
    protected $client;
    protected $twilio;

    /**
     * @param string $token
     * @param string $from
     * @param string $sid
     * @param bool $sslVerify
     */
    public function __construct() {
        $this->sid = config('twilio.twilio.connections.twilio.sid');
        $this->token = config('twilio.twilio.connections.twilio.token');

        $this->from = config('twilio.twilio.connections.twilio.from');

        $this->sslVerify = config('twilio.twilio.connections.twilio.ssl_verify');

        $this->client = new Client($this->sid, $this->token);
    }

    public function message($to, $message) {
        $client = $this->client;
        $data = [];
        try {
            $sms = $client->account->messages->create(
                    // the number we are sending to - Any phone number
                    $to, array(
                // Step 6: Change the 'From' number below to be a valid Twilio number 
                // that you've purchased
                'from' => $this->from,
                // the sms body
                'body' => $message
                    )
            );
            $data['type'] = 'success';
            $data['data'] = $sms;
        } catch (ConfigurationException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (DeserializeException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (EnvironmentException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (HttpException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (RestException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (TwilioException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    /* After connecting the call voicemail would be processed */

    public function voiceMail($call_sid, $url) {
        $client = $this->client;
        $data = [];
        try {
            $call = $client
                    ->calls($call_sid)
                    ->update(
                    array(
                        "url" => "http://demo.twilio.com/docs/voice.xml",
                        "method" => "POST"
                    )
            );
            $data['type'] = 'success';
            $data['data'] = $call;
        } catch (ConfigurationException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (DeserializeException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (EnvironmentException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (HttpException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (RestException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (TwilioException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    public function call($to, $from, $url, $failurl = '', $callback = '') {
        /*   Ex. of Failurl(send mp3) FailUrl=http://myapp.com/please-try-later.mp3 */
        $client = $this->client;
        $data = [];
        if ($from == '') {
            $from = $this->from;
        }
        $url = 'http://twimlets.com/forward?PhoneNumber=' . $from;
        if (isset($failurl) && $failurl != '') {
            $url = 'http://twimlets.com/forward?PhoneNumber=' . $from . '&FailUrl=http://myapp.com/please-try-later.mp3';
        }
        $data_parameter = array(
//            'url' => 'http://twimlets.com/callme?PhoneNumber=%2B917908805317&Message=Hello%20pick%20up%20the%20phone&FailUrl=http%3A%2F%2Ftwimlets.com%2Fcallme',
            "url" => $url,
            "method" => "GET",
            "statusCallbackMethod" => "POST",
            "statusCallback" => $callback,
            "statusCallbackEvent" => array(
                "initiated",
                "ringing",
                "answered",
                "completed")
        );
        try {
            // Initiate a new outbound call
            $call = $client->account->calls->create(
                    // Step 4: Change the 'To' number below to whatever number you'd like 
                    // to call.
                    $to,
                    // Step 5: Change the 'From' number below to be a valid Twilio number 
                    // that you've purchased or verified with Twilio.
                    $from,
                    // Step 6: Set the URL Twilio will request when the call is answered.
                    $data_parameter
            );
            $data['type'] = 'success';
            $data['data'] = $call;
        } catch (ConfigurationException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (DeserializeException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (EnvironmentException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (HttpException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (RestException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (TwilioException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    public function stopCall($call_sid) {
        $client = $this->client;
        $data = [];
        try {
            $call = $client
                    ->calls($call_sid)
                    ->update(
                    array("status" => "completed")
            );
            $data['type'] = 'success';
            $data['data'] = $call;
        } catch (ConfigurationException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (DeserializeException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (EnvironmentException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (HttpException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (RestException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (TwilioException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    /* Type=> Moderator AND Others */

    public function conference($to, $from, $url, $callback = '') {
       
        $client = $this->client;
        $data = [];
        if ($from == '') {
            $from = $this->from;
        }
        $data_parameter = array(
//            'url' => 'http://twimlets.com/callme?PhoneNumber=%2B917908805317&Message=Hello%20pick%20up%20the%20phone&FailUrl=http%3A%2F%2Ftwimlets.com%2Fcallme',
            "url" => $url,
            "method" => "GET",
            "statusCallbackMethod" => "POST",
            "statusCallback" => $callback,
            "statusCallbackEvent" => array(
                "initiated",
                "ringing",
                "answered",
                "completed")
        );
        try {
            $call = $client->account->calls->create(
                    // Step 4: Change the 'To' number below to whatever number you'd like 
                    // to call.
                    $to,
                    // Step 5: Change the 'From' number below to be a valid Twilio number 
                    // that you've purchased or verified with Twilio.
                    $this->from,
                    // Step 6: Set the URL Twilio will request when the call is answered.
                    $data_parameter
            );
            $data['type'] = 'success';
            $data['data'] = $call;
        } catch (ConfigurationException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (DeserializeException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (EnvironmentException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (HttpException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (RestException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        } catch (TwilioException $e) {
            $data['type'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

}
