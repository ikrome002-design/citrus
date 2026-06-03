<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderCreateEvent' => [
            'App\Listeners\OrderCreateEventListener',
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],

         'Illuminate\Auth\Events\Verified' => [
        'App\Listeners\LogVerifiedUser',
    ],
    ];

   

    public function boot()
    {
        parent::boot();

        //
    }
}
