<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table = 'addresses';
    protected $fillable = ['address_type', 'alias', 'address_1', 'address_2', 'first_name', 'last_name', 'email', 'company_name', 'zip', 'state_code', 'city', 'country_id', 'customer_id', 'status', 'phone'];
}
