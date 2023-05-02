<?php

namespace App\Services\Vonage;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class VonageApi
{
    private $appID;
    private $secret;
    private $from;
    private $api_key;
    private $client;

    public function __construct()
    {
        $this->api_key = config('sms.vonage.api_key');
        $this->secret = config('sms.vonage.secret');
        $this->from = config('sms.from');

        $basic = new Basic($this->api_key, $this->secret);
        $this->client = new Client($basic);
    }

    public function send($number, $body): int
    {
        $response = $this->client->sms()->send(new SMS($number, $this->from, $body));

        return $response->current()->getStatus();
    }

}
