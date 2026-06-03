<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function show()
    {

        return view('auth.verify-customer');
    }

    public function request()
    {
        auth()->user()->sendEmailVerificationNotification();

        return back()
            ->with('success', 'Verification link sent!');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->to('/login'); // <-- change this to whatever you want
    }
}