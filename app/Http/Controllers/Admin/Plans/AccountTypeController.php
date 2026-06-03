<?php

namespace App\Http\Controllers\Admin\Plans;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\User;
use App\Repositories\AccountTypeRepository;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class AccountTypeController extends Controller
{
    private AccountTypeRepository $accountTypeRespository;

    public function __construct(AccountTypeRepository $accountTypeRespository)
    {
        $this->accountTypeRespository =  $accountTypeRespository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->onlyTrashed  && $user->can('restore account type', 'admin')) {
            return   $account_types = $this->accountTypeRespository->onlyTrashed()->get();
        }
        if ($request->withTrashed &&  $user->can('restore account type', 'admin')) {
            return   $account_types = $this->accountTypeRespository->withTrashed();
        } else {
            $account_types = $this->accountTypeRespository->all();
        }

        return view('admin.account-types.list', compact('account_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.account-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:active,inactive'
        ]);
        try {
            $this->accountTypeRespository->create($request->only('status', 'name'));
            return to_route('admin.account.types.index')->with('messsage', 'Account type successfully created.');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountType $accountType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountType $accountType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountType $accountType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountType $accountType)
    {
        //
    }
}
