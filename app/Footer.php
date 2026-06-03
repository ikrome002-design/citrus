<?php

namespace App;


use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = ['title', 'link','created_at','updated_at'];

    
}
