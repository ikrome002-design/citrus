<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subadmin extends Model
{
    
     protected $fillable = [
        'name','email','password','phone','avatar'];
}
