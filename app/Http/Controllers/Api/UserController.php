<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PushNotificationRequest;
use App\Http\Requests\Api\SMSNotificationRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Services\Notifications\PushNotificationService;
use App\Services\SendSMSNotificationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

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
        if (!$user->hasPushNotificationToken()) {

            return response()->json([
                'status' => 'Failed to send push. Invalid firebase token',
            ], Response::HTTP_NO_CONTENT);

        }

        $user->notify(new SendPushNotification($request->validated()));

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function pushMulticast(PushNotificationRequest $request)
    {
        User::query()->hasPushNotificationToken()
            ->chunkById(10000, function (Collection $users) use ($request) {
                Notification::send($users, new SendPushNotification($request->validated()));
            });

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function sms(User $user, SMSNotificationRequest $request, SendSMSNotificationService $service)
    {
        if ($user->isPhoneUnreachable()) {
            return response()->json([
                'status' => 'Failed to send SMS. Unreachable phone number',
            ], Response::HTTP_NO_CONTENT);
        }

        $response = $service->send($user, $request->message);

        if (!$response) {
            return response()->json([
                'status' => 'Failed to send SMS',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function smsMulticast(SMSNotificationRequest $request, SendSMSNotificationService $service)
    {
        $message = $request->message;

        User::query()->hasValidPhone()
            ->chunkById(10000, function (Collection $users) use ($message, $service) {
                foreach ($users as $user) {
                    $service->send($user, $message);;
                }
            });

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }
}
