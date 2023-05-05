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

    public function __construct()
    {
        $this->clientApi = new VonageApi();
    }

    public function send($notification, $exceptionCallback = null): bool
    {
        try {

           return  $this->clientApi->send($notification['phone'], $notification['body']);

        } catch (\Exception $exception) {

            Log::error("The message failed: " . $exception . "\n");

            if ($exceptionCallback && is_callable($exceptionCallback)) {
                call_user_func($exceptionCallback, $exception);
            }

            return false;
        }
    }

}
