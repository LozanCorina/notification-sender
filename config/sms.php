<?php
return [
    'from' => env('APP_SENDER'),

    'vonage' => [
        'api_key' => env('VONAGE_KEY'),
        'secret' => env('VONAGE_SIGNATURE_SECRET')
    ]

];

