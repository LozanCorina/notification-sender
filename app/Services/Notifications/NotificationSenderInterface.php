<?php

namespace App\Services\Notifications;

interface NotificationSenderInterface
{

    public function send($object, $exceptionCallback = null);
}
