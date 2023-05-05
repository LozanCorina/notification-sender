<?php

namespace App\Services;

use App\Models\User;
use App\Services\Notifications\NotificationSenderInterface;
use App\Services\Notifications\PushNotificationService;

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
    public function notifyPush(array $data)
    {
        $notification = [
            'title' => $data['title'],
            'body' => $data['body']
        ];

        if ($this->user->notify(new PushNotificationService($notification))) {
            $this->user->push_notifications_token = null;
            $this->user->save();
            return false;
        }

        return true;
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
