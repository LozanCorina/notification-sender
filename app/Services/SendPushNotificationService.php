<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;

class SendPushNotificationService
{
     protected $notification;
     public function __construct($notification)
     {
          $this->notification = $notification;

     }

    public function send(array $tokens)
    {
        $message = CloudMessage::fromArray($tokens);

        $response = Firebase::messaging()->sendMulticast($message, $message);

        if (!$response->hasFailures()) {
            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);
        }

        Log::error('Failed to send push notification: ' );
    }

}
