<?php

namespace App\Services\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class PushNotificationService extends Notification
{
    private $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['title' => $this->notification['title'], 'body' => $this->notification['body']])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($this->notification['title'])
                ->setBody($this->notification['body']));
    }
}
