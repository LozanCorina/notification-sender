<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PushNotificationRequest;
use App\Http\Requests\Api\SMSNotificationRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Notifications\SendSMSNotification;
use App\Services\Notifications\PushNotificationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use Symfony\Component\HttpFoundation\Response;
use Vonage\Client\Exception\Exception;

class UserController extends Controller
{
    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function push(User $user, PushNotificationRequest $request)
    {
        if (!$user->push_notifications_token) {

            return response()->json([
                'status' => 'Failed to send push. Invalid firebase token',
            ], Response::HTTP_NO_CONTENT);

        }

        try {

            $user->notify(new SendPushNotification($request->validated()));

            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);

        } catch (CouldNotSendNotification $exception) {

            $user->push_notifications_token = null;
            $user->save();

            Log::error('Failed to send push notification: ' . $exception->getMessage());

            return response()->json([
                'status' => 'Failed to send push notification',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function sms(User $user, SMSNotificationRequest $request)
    {
        if ($user->phone_unreachable) {

            return response()->json([
                'status' => 'Failed to send SMS. Unreachable phone number',
            ], Response::HTTP_NO_CONTENT);

        }

        try {
            $user->notify(new SendSMSNotification($request->get('message')));

            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {

            if ($this->isFailedPhoneStatus($exception->getCode())) {
                $user->invalidatePhoneNumber();
            }
            return response()->json([
                'status' => 'Failed to send SMS',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param int $status
     * @return bool
     */
    public function isFailedPhoneStatus(int $status): bool
    {
        return in_array($status, [
            6, 7, 22
        ]);
    }
}
