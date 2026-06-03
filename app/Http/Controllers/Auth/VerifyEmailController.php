<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\Admin;
use App\Models\User;
use App\Shop\Vendors\Vendor;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;


class VerifyEmailController extends Controller
{
    public function viewForm(Request $request)
    {
        $host = $request->getHost();
        $view = $host === 'business.' . env('APP_DOMAIN') ? 'auth.vendor.verify-email' : ($host === 'admin.' . env('APP_DOMAIN') ? 'auth.admin.verify-email' : 'auth.customer.verify-email');
        return view($view);
    }
    public function verifyEmail(EmailVerificationRequest $request, $id)
    {

        $user = User::findOrFail($id);
        $user->markEmailAsVerified();
        event(new Verified($user));
        $vendor = Vendor::where('user_id', $user->id)->first();
        $admin = Admin::where('user_id', $user->id)->first();
        $to_route = $vendor ? 'vendor.login' : ($admin ? 'admin.login' : 'login.get');
        return to_route($to_route)->with('success', 'You have successfully verified your email. You can now login.');
    }

    public function resendLink(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user->hasVerifiedEmail()) {
            return back()->withErrors('The email is verified. Please you can login.');
        }

        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
