<?php

namespace App\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactUSMeta extends Model
{
    public $table = 'contact_meta';
	public $fillable = ['contact_id','name','value'];
}


