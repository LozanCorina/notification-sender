<?php
return [
    'from' => env('VONAGE_APP_NAME'),

    'vonage' => [
        'app_id' => env('VONAGE_APPLICATION_ID'),
        'secret' => env('VONAGE_SIGNATURE_SECRET')
    ]

];

