<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function viewForm()
    {
        return view('auth.register');
    }

    public function postData(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->save();

        event(new Registered($user));

        return to_route('login.get')->with('success', 'Registered successfully! Please click the link sent to your email to verify your email before you login.');
    }
}
