<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $this->ensureIsNotRateLimited($request);

        $user = User::where('email', $request->email)->first();
        if (!$user->hasVerifiedEmail()) {
            return to_route('verification.notice')->withErrors('You have not verified your email. Please enter your email to receive a verification link.');
        }

        if (!$user->is_active) {
            return back()->withErrors('You are not allowed to log in. Please contact support');
        }

        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password, 'is_active' => 1],
            $request->remember
        )) {

            RateLimiter::clear($this->throttleKey($request));

            $admin = Admin::where('user_id', $user->id)->first();

            if (!$admin) {
                return back()->withErrors("You are not allowed to login from this url. Please go to the home page.");
            }
            if (!$admin->is_active) {
                return back()->withErrors('You are not allowed as admin. Please contact your admin.');
            }

            if ($request->redirect) {
                session()->forget('redirect');
                return redirect($request->redirect);
            }

            return to_route('admin.dashboard');
        }

        RateLimiter::hit($this->throttleKey($request));

        return back()->withErrors('Invalid email and/or password');
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            event(new Lockout($request));

            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
