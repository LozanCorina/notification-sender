<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PushNotificationRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Models\User;
use App\Services\Notifications\SMSNotificationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
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
        (new UserService($user))->notifyPush($request->validated());

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function sms(User $user, PushNotificationRequest $request, SMSNotificationService $notificationService)
    {
        (new UserService($user, $notificationService))->notifySMS($request->validated());

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }
}
