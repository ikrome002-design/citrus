<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function viewForm(Request $request)
    {
        $host = $request->getHost();
        $view = $host === 'business.' . env('APP_DOMAIN') ? 'auth.vendor.forgot-password' : ($host === 'admin.' . env('APP_DOMAIN') ? 'auth.admin.forgot-password' : 'auth.customer.forgot-password');
        return view($view);
    }
    public function postData(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
