<?php

namespace App\Http\Controllers\Admin\Memberships;

use App\Shop\Memberships\Membership;
use App\Shop\Taxes\TaxRates;
use App\Shop\Memberships\Repositories\MembershipRepository;
use App\Shop\Memberships\Repositories\Interfaces\MembershipRepositoryInterface;
use App\Shop\Taxes\Repositories\TaxRepository;
use App\Shop\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Shop\Memberships\Requests\UpdateMembershipRequest;
use App\Shop\Memberships\Requests\CreateMembershipRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    private $membershipRepo;
    private $taxRepo;

    public function __construct(
        MembershipRepositoryInterface $membershipRepository, TaxRepositoryInterface $taxRepository)
    {
        $this->membershipRepo = $membershipRepository;
        $this->taxRepo = $taxRepository;
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $list = $this->membershipRepo->listMemberships('created_at', 'desc');
        $max_plan_id= DB::table('vendors')
                ->select('plan_id')
                ->groupBy('plan_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->first();

         $max_plan = $this->membershipRepo->findMembershipById($max_plan_id->plan_id);

        return view('admin.memberships.list',[
            'memberships' =>$this->membershipRepo->paginateArrayResults($list->all(), 10),
            'max_plan' => $max_plan,
            'taxs'=>$this->taxRepo->listTaxes('created_at', 'desc')
        ]);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $membership = $this->membershipRepo->findMembershipById($id);
       
        return view('admin.memberships.show', ['memberships' => $membership]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      
        return view('admin.memberships.edit', 
            [
                'membership' => $this->membershipRepo->findMembershipById($id),
                'tax'=>$this->taxRepo->listTaxes('created_at', 'desc')
               
                
            ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.memberships.create',['tax'=>$this->taxRepo->listTaxes('created_at', 'desc')]);
    }


    /**
     * create the specified resource in storage.
     *
     * @param  CreateMembershipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMembershipRequest $request)
    {
 
        if($request->product_display=='checked'){
            $request['display_product']=$request->quantity;
        }
        if($request->product_purchased=='checked'){
            $request['purchase_product']=$request->quantity;
        }
        
        $membership = $this->membershipRepo->createMembership($request->all());

        return redirect()->route('admin.memberships.index')->with('message', 'Created successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembershipRequest $request, $id)
    {

        
        $membership = $this->membershipRepo->findMembershipById($id);
        
        $update = new MembershipRepository($membership);
        $update->updateMembership($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.memberships.edit', $id);
    }
}
