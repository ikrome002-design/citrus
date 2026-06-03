<?php

namespace App\Shop\Taxes;

use Illuminate\Database\Eloquent\Model;

class TaxRates extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_code',
        'state_code',
        'city',
        'postal_code',
        'rate_percentage',
        'tax_name',
        'compound',
        'description',
        'shipping'
    ];

    
   
}
