<?php

namespace App\Http\Controllers\Merchant;

use App\BusinessType;
use App\Http\Controllers\Controller;
use App\Shop\Vendors\Vendor;
use Illuminate\Http\Request;

class RegisterMerchantController extends Controller
{
    public function registerForm()
    {

        $vendor = Vendor::where('user_id', auth()->user->id)->first();

        if ($vendor) {
            return to_route('vendor.dashboard')->withErrors("Sorry! You already have merchant account.");
        }

        $business_types = BusinessType::all();
        return view('auth.vendor.register', compact('business_types'));
    }

    public function register(Request $request)
    {

        $vendor = Vendor::where('user_id', auth()->user->id)->first();

        if ($vendor) {
            return to_route('vendor.dashboard')->withErrors("Sorry! You already have merchant account.");
        }

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email',
            'business_location' => 'nullable|string|max:255',
            'business_about' => 'required|string|max:2500',
            'business_role' => 'required|string|max:255',
            'business_type' => 'required|exists:business_types,id',
        ]);

        $vendor = new Vendor();
        $vendor->user_id = auth()->user()->id;
        $vendor->business_name = $request->business_name;
        $vendor->business_email = $request->business_email;
        $vendor->business_location = $request->business_location;
        $vendor->business_about = $request->business_about;
        $vendor->business_role = $request->business_role;
        $vendor->business_type_id = $request->business_type;
        $vendor->save();

        return back()->with('success', 'Thank you for registering as merchnat. You will be contacted shortly by out team for approval.');
    }
}
