<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class SendPushNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $notification;

    /**
     * Create a new notification instance.
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * Get the push representation of the notification.
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['title' => $this->notification['title'], 'body' => $this->notification['body']])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($this->notification['title'])
                ->setBody($this->notification['body']));
    }
}
