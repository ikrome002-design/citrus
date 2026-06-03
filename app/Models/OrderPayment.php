<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
 
    protected $table = 'order_payment';

    protected $fillable = ['user_id','order_id','name','card_brand','stripe_id','amount','stripe_response','token','created_at','updated_at'];
}
