<?php

return [
    'name' => 'paypal',
    'description' => 'PayPal - Safe, Secured and Easy to pay online!',
    'account_id' => env('PP_ACCOUNT_ID', ''),
    'client_id' => env('PP_CLIENT_ID', ''),
    'client_secret' => env('PP_CLIENT_SECRET', ''),
    'api_url' => env('PP_API_URL', 'https://api.sandbox.paypal.com'),
    'redirect_url' => env('PP_REDIRECT_URL', ''),
    'cancel_url' => env('PP_CANCEL_URL', ''),
    'failed_url' => env('PP_FAILED_URL', ''),
    'mode' => env('PP_MODE', 'sandbox'),
];
