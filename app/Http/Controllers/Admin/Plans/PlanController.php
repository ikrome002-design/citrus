<?php

namespace App\Http\Controllers\Admin\Plans;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PlanController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Plan::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $plans = Plan::all();
        return view('admin.plans.list', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
