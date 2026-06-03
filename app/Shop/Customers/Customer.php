<?php

namespace App\Shop\Customers;

use App\Shop\Addresses\Address;
use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Nicolaslopezj\Searchable\SearchableTrait;


class Customer extends Authenticatable implements MustVerifyEmail
{
    //use Notifiable, SoftDeletes, SearchableTrait, Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
       'first_name',
        'last_name',
        'phone_number',
        'country',
        'agree',
        'user_type',
        'national_id',
        'dob',
        'gender',
        'email',
        'password',
        'status',
        'avatar',
        'merchant_id',
        'staff_id',
        'citrus_customer_id',
        'newsletter',
        'email_verified_at',
        'csrf_token'
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

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'customers.first_name' => 10,
            'customers.email' => 5
        ]
    ];

  

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class)->whereStatus(true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function searchCustomer($term)
    {
        return self::search($term);
    }
}
