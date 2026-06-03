<?php

namespace App\Shop\ProductRatings;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'vendor_id',
        'rating',
        'review',
        'status'
    ];

    
   
}
