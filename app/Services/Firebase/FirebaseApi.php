<?php

namespace App\Services\Firebase;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class FirebaseApi extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['title' => $notifiable->title, 'body' => $notifiable->body])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($notifiable->title)
                ->setBody($notifiable->body));
    }
}
