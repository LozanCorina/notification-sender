<?php

namespace App\Services\Notifications;

interface NotificationSenderInterface
{

    public function send($notification, $exceptionCallback = null);
}
