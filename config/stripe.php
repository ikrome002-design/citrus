<?php

return [
    'name' => 'stripe',
    'description' => 'The new standard in online payments',
    'key' => env('STRIPE_KEY', ''),
    'secret' => env('STRIPE_SECRET', ''),
    'redirect_url' => env('STRIPE_REDIRECT_URL', ''),
    'cancel_url' => env('STRIPE_CANCEL_URL', ''),
    'failed_url' => env('STRIPE_FAILED_URL', ''),
];
