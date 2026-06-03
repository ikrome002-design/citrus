<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\BusinessType;
use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\Merchant;
use App\Models\User;
use App\Shop\Vendors\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showForm()
    {
        $business_types = BusinessType::all();
        $acc_types = AccountType::all();
        return view('auth.merchant.register', compact('business_types', 'acc_types'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'account_type' => 'required|exists:acccount_types,id',
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email',
            'business_location' => 'nullable|string|max:255',
            'business_about' => 'required|string|max:2500',
            'business_role' => 'required|string|max:255',
            'business_type' => 'required|exists:business_types,id',
            'agree' => 'required'
        ]);

        $user_exist = User::where('email', $request->email);

        if ($user_exist) {
            return to_route('merchant.login')->withErrors('Your email is already registerd. Please login to register as merchant');
        }

        $user = new User();
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->save();

        $vendor = new Merchant();
        $vendor->user_id = $user->id;
        $vendor->business_name = $request->business_name;
        $vendor->business_email = $request->business_email;
        $vendor->business_location = $request->business_location;
        $vendor->business_about = $request->business_about;
        $vendor->business_role = $request->business_role;
        $vendor->business_type_id = $request->business_type;
        $vendor->save();


        event(new Registered($user));
        return to_route('vendor.login')->with('success', 'Registered successfully! Please click the link sent to your email to verify your email before you login.');
    }
}
