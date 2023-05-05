<?php

namespace App\Services\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class PushNotificationService extends Notification
{
    private $notification;
    private $token;

    public function __construct($notification, $token)
    {
        $this->notification = $notification;
        $this->token = $token;
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

    public function failed($notifiable, $exception)
    {
        Log::error('Failed to send push notification: ' . $exception->getMessage());

        User::query()->where('push_notifications_token', $this->token)->update([
            'push_notifications_token' => null
        ]);
    }
}
