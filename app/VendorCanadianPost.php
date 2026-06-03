<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCanadianPost extends Model
{
    
    protected $fillable = [
    	'user_name',
    	'password',
    	'customer_id',
    	'vendor_id',
    	
    ];
}
