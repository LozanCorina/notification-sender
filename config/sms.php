<?php
return [
    'from' => env('VONAGE_APP_NAME'),

    'vonage' => [
        'api_key' => env('VONAGE_KEY'),
        'secret' => env('VONAGE_SIGNATURE_SECRET')
    ]

];

