<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check() && auth()->user()->is_active && auth()->user()->admin->is_active) {
            return $next($request);
        }
        return redirect(route('admin.login.get', ['redirect' => url()->full()]))->withErrors('You must be an admin to access the page');
    }
}
