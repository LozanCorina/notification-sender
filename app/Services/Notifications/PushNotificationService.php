<?php

namespace App\Services\Notifications;

class PushNotificationService implements NotificationSenderInterface
{
    private $clientApi;
    public function send($object, $exceptionCallback = null)
    {
        return $this->notify($object->phone, $object->body, $exceptionCallback);
    }

    /**
     * @param $phone
     * @param $body
     * @param $exceptionCallback
     * @return bool
     */
    public function notify($body, $exceptionCallback = null): bool
    {
        try {

        } catch (\Exception $exception) {


            if ($exceptionCallback && is_callable($exceptionCallback)) {
                call_user_func($exceptionCallback, $exception);
            }

            return false;
        }
    }
}
