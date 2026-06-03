<?php

namespace App\Shop\Vendors;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\ServiceProvider;

class Vendor extends Authenticatable
{
    use Notifiable, SoftDeletes, LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];
}
