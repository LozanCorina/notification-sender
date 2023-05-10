<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SendSMSNotification;
use Illuminate\Support\Facades\Log;
class SendSMSNotificationService
{

    /**
     * @param User $user
     * @param $message
     * @return bool
     */
    public function send(User $user, $message): bool
    {
        try {
            $user->notify(new SendSMSNotification($message));

          return true;
        } catch (\Exception $exception) {

            if (SendSMSNotification::isFailedPhoneStatus($exception->getCode())) {
                $user->setUnreachablePhoneNumber();
            }

            Log::error('Failed to send sms notification: ' . $exception->getMessage());

            return false;
        }

    }

}
