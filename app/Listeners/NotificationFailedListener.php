<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Log;

class NotificationFailedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel === 'NotificationChannels\Fcm\FcmChannel' && $event->notifiable instanceof User) {
            $event->notifiable->setPushNotificationTokenNull();
        }

        Log::error('Failed to send notification for user_id=' . $event->notifiable->id);
    }
}
