<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Vendor extends Authenticatable
{
 
    protected $guard = 'vendor';
	protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'password',
        'email',
        'business_name',
        'business_type',
        'business_location',
        'phone_number',
        'country',
        'role',
        'agree',
        'business_about',
        'user_type',
        'account_type',
        'citrus_merchant_id',
        'payment_status',
        'company_overview',
        'business_year',
        'location',
        'cover_image',
        'contact_person_name',
        'contact_no',
        'contact_email',
        'contact_address',
        'otp',
        'otp_expires_at',
        'status',
        'verify_status',
        'created_at',
        'updated_at',
        ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
