<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    //
    protected $table = 'business_type';
    protected $fillable = ['title','created_at',
        'updated_at'];
}
