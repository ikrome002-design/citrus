<?php

namespace App\Shop\Employees;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;

class Employee extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'phone',
        'bio',
        'name',
        'email',
        'password',
        'status',
        'type',
        'citrus_merchant_id',
        'merchant_id',
        'role',
        'shop_id',
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
