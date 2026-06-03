<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'vendor')
    {

        if (!auth()->guard($guard)->check()) {
            $request->session()->flash('error', 'You must be a merchant to see this page');
            return redirect(route('vendor.login'));
        }elseif(auth()->guard($guard)->user()->payment_status == 0){
            return redirect()->route('vendor.register.payment');
        }

        return $next($request);


    }
}
