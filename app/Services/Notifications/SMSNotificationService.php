<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Services\Vonage\VonageApi;
use Illuminate\Support\Facades\Log;

class SMSNotificationService implements NotificationSenderInterface
{
    /**
     * @var string
     */
    public $clientApi;
    public $phone;
    public $body;

    public function __construct()
    {
        $this->clientApi = new VonageApi();
    }

    public function send($notification, $exceptionCallback = null)
    {
        try {

            $status = $this->clientApi->send($notification->phone, $notification->body);

            if ($this->isFailedPhoneStatus($status)) {

                $this->updateUserStatusPhone($notification->phone);

                return false;
            }

            return true;

        } catch (\Exception $exception) {

            Log::error('send-sms', "The message failed:" . $exception . "\n");

            return false;
        }
    }

    public function isFailedPhoneStatus(int $status): bool
    {
        return in_array($status, [
            6, 7, 22
        ]);
    }

    protected function updateUserStatusPhone(string $phone): void
    {
        User::query()->where('phone', $phone)->update([
            'phone_unreachable' => true
        ]);
    }

}
