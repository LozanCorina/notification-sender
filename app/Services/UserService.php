<?php

namespace App\Services;

use App\Models\User;
use App\Services\Notifications\NotificationSenderInterface;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

class UserService
{
    public $user;
    public $sender;

    /**
     * @param User $user
     * @param null|NotificationSenderInterface $sender
     */
    public function __construct(User $user, NotificationSenderInterface $sender = null)
    {
        $this->user = $user;
        $this->sender = $sender;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function notifyPush(array $data): bool
    {
        $notification = [
            'title' => $data['title'],
            'body' => $data['body']
        ];

        try {
            $this->user->notify(new PushNotificationService($notification));
             return true;
        } catch (CouldNotSendNotification $exception) {

            $this->user->push_notifications_token = null;
            $this->user->save();

            Log::error('Failed to send push notification: ' . $exception->getMessage());

            return false;
        }

    }

    /**
     * @param array $data
     * @return bool
     */
    public function notifySMS(array $data): bool
    {
        $notification = [
            'phone' => $this->user->phone,
            'body' => $data['body']
        ];

        return $this->sender->send($notification);
    }

}
