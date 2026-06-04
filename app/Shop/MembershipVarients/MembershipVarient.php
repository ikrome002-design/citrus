<?php

namespace App\Shop\MembershipVarients;

use Laratrust\Models\Role as LaratrustRole;

class MembershipVarient extends LaratrustRole
{
    protected $fillable = [
        'varient_type',

    ];
}
