<?php

namespace App\Services\Notifications;

use App\Services\Vonage\VonageApi;
use Illuminate\Support\Facades\Log;

class SMSNotificationService implements NotificationSenderInterface
{
    /**
     * @var string
     */
    public $clientApi;
    public $phone;
    public $body;

    public function __construct()
    {
        $this->clientApi = new VonageApi();
    }

    public function send($notification, $exceptionCallback = null)
    {
        try {

            return $this->clientApi->send($notification->phone, $notification->body);

        } catch (\Exception $exception) {

            Log::error('send-sms', "The message failed:" . $exception . "\n");

            return false;
        }
    }

}
