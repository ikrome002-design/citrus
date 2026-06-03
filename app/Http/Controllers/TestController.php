<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestController extends Controller
{

    public function index()
    {
        $k =  AccountType::destroy(1);

        // Permission::insert([
        //     ['name' => 'create account type', 'guard_name' => 'admin'],
        //     ['name' => 'update account type', 'guard_name' => 'admin'],
        //     ['name' => 'delete account type', 'guard_name' => 'admin'],
        //     ['name' => 'restore account type', 'guard_name' => 'admin'],
        // ]);
    }
}
