<?php

namespace Laravelpackage\Twilio;

interface TwilioInterface {

    /**
     * @param string $to
     * @param string $message
     *
     * @return \Services_Twilio_Rest_Message
     */
    public function message($to, $message);

    /**
     * @param string $to
     * @param string|callable $message
     *
     * @return \Services_Twilio_Rest_Call
     */
    public function call($to, $from, $url, $failurl = '', $callback = '');

    public function voiceMail($call_sid, $url);

    public function stopCall($call_sid);
    public function conference($to, $from, $url, $callback = '');
}
