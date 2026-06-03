<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessDetails extends Model
{
  
    protected $fillable = [
        'employee_id','business_name','office_address','business_logo'];
}
