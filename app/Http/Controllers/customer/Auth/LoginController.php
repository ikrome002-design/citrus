<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function viewForm(Request $request)
    {
        $redirect = '';
        if (auth()->check()) {
            if ($request->redirect) {
                return redirect(urldecode($request->redirect));
            }
            $user = User::find(auth()->user()->id);

            if ($user->hasAnyRole('super_admin', 'admin')) {
                return redirect(env('ADMIN_URL'));
            }
            return to_route('home');
        }
        if ($request->redirect) {
            $redirect = session(['redirect' => $request->redirect]);
        }
        if (session()->has('redirect')) {
            $redirect = session()->get('redirect');
        }
        return view('auth.login', compact('redirect'));
    }
    public function postData(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user->hasVerifiedEmail()) {
            return to_route('verification.notice')->withErrors('You have not verified your email. Please enter  your email to receive verification link.');
        }
        if (!$user->is_active) {
            return back()->withErrors('You are not allowed to log in. Please contact support');
        }

        if (auth()->attempt(
            ['email' => $request->email, 'password' => $request->password, 'is_active' => 1],
            $request->remember
        )) {

            if ($request->redirect) {
                return redirect($request->redirect);
            }

            if ($user->hasAnyRole('super_admin', 'admin')) {
                return redirect(env('ADMIN_URL'));
            }
            return to_route('home');
        }

        return back()->withErrors('Invalid email and/or password');
    }
    public function logout()
    {
        auth()->logout();
        return to_route('login.get');
    }
}
