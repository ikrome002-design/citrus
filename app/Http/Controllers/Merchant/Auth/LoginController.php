<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function loginForm(Request $request)
    {
        $redirect = '';
        if ($request->redirect) {
            $redirect = $request->redirect;
        }
        return view('auth.merchant.login', compact('redirect'));
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

        if (!$user->user_is_active) {
            return back()->withErrors('You are not allowed to log in. Please contact support');
        }
        if (auth()->attempt(
            ['email' => $request->email, 'password' => $request->password, 'user_is_active' => 1],
            $request->remember
        )) {

            $vendor = Merchant::where('user_id', $user->id)->first();

            if (!$vendor) {
                return to_route('vendor.register.signed')->withErrors("You don't have merchant account. Please register here");
            }
            if (!$vendor->business_is_active) {
                return back()->withErrors('Your merchant account is not active. Please contact support');
            }

            if (auth()->attempt(
                ['email' => $request->email, 'password' => $request->password, 'user_is_active' => 1],
                $request->remember
            )) {
                if ($request->redirect) {
                    session()->forget('redirect');
                    return redirect($request->redirect);
                }

                return to_route('merchant.dashboard');
            }
        }

        return back()->withErrors('Invalid email and/or password');
    }
}
