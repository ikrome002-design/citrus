<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function viewForm()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->markEmailAsVerified();
        event(new Verified($user));

        return to_route('login.get')->with('success', 'You have successfully verified your email. You can now login');
    }

    public function resendLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $user = User::where('email', $request->email)->first();
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
