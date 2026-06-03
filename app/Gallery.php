<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //
    protected $table = 'gallery';
    protected $fillable = ['image','merchant_id','created_at',
        'updated_at'];
}
