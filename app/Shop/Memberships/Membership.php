<?php

namespace App\Shop\Memberships;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'package_expire',
        'monthly_initial_price',
        'monthly_recurring_price',
        'yearly_initial_price',
        'yearly_recurring_price',
        'yearly_recurring_price',
        'tax_id',
        'quantity',
        'display_product',
        'purchase_product',
        'description',
        'feature_list',
        'created_by',
        'updated_by'
    ];

    
   
}
