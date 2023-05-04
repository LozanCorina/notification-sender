<?php

namespace App\Services;

use App\Models\User;
use App\Services\Notifications\NotificationSenderInterface;
use App\Services\Notifications\SMSNotificationService;

class UserService
{
    public $user;
    public $sender;

    public function __construct(User $user, NotificationSenderInterface $sender)
    {
        $this->user = $user;
        $this->sender = $sender;
    }


    public function notifyPush(array $data)
    {
        return $this->sender->send();
    }

    public function notifySMS(array $data): bool
    {
        $notification = new SMSNotificationService();

        $notification->phone = $this->user->phone;
        $notification->body = $data['body'];

        return $this->sender->send($notification, true);

    }

}
