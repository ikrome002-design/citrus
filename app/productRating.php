<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productRating extends Model
{
    protected $fillable = [
        'product_id','vendor_id','user_id','rating','review','status'];
}
