<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorBusinessDetail extends Model
{
    
    protected $fillable = [
    	'vendor_id',
    	'gst_no',
    	'pst_no',
    	'address',
    	'city',
    	'state',
    	'postal_code',
    	'office_number',
    	'cell_number',
    	'same_office_add',
    	'billing_address',
    	'billing_city',
    	'billing_state',
    	'billing_postal_code',
    	'billing_office_number',
    	'billing_cell_number',
    	'own_by_vancouver',
    	'head_office_vancouver',
    	'local_community',
    ];
}
