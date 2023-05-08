<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SendSMSNotification extends Notification
{
    use Queueable;

    private $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['vonage'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message)
            ->statusCallback('https://webhook.site/2ebaa40e-df83-4ed4-a7a9-ce7baeecab18');
    }

    /**
     * @param int $status
     * @return bool
     */
    public static function isFailedPhoneStatus(int $status): bool
    {
        return in_array($status, [
            6, 7, 22
        ]);
    }
}
