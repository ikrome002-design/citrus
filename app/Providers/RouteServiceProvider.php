<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapMerchantRoutes();
        $this->mapAdminRoutes();
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        //
    }


    //admin

    protected function mapAdminRoutes()
    {
        Route::domain('admin.' . env('APP_DOMAIN'))
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }


    //merchant

    protected function mapMerchantRoutes()
    {
        Route::domain('business.' . env('APP_DOMAIN'))
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/merchant.php'));
    }



    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::domain('api' . env('APP_DOMAIN'))
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        // Apply rate limiting to the login route
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email'));
        });
    }
}
