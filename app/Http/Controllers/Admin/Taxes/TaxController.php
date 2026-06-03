<?php

namespace App\Http\Controllers\Admin\Taxes;

use App\Shop\Taxes\TaxRates;
use App\Shop\Taxes\Repositories\TaxRepository;
use App\Shop\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Shop\Taxes\Requests\UpdateTaxRequest;
use App\Shop\Taxes\Requests\CreateTaxRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    private $taxRepo;

    public function __construct(
        TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepo = $taxRepository;
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $list = $this->taxRepo->listTaxes('created_at', 'desc');

        return view('admin.taxes.list', [
           'taxes' => $this->taxRepo->paginateArrayResults($list->all(), 10)
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
        $taxes = $this->taxRepo->findTaxById($id);
        return view('admin.taxes.show', ['taxes' => $taxes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.taxes.edit',['tax' => $this->taxRepo->findTaxById($id)]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.taxes.create');
    }


    public function store(CreateTaxRequest $request)
    {
        $tax = $this->taxRepo->createTax($request->all());
        return redirect()->route('admin.taxes.index')->with('message', 'Created successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxRequest $request, $id)
    {   
        $tax = $this->taxRepo->findTaxById($id);
        $update = new TaxRepository($tax);
        $update->updateTax($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.taxes.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        
        $tax = $this->taxRepo->findTaxById($id);
        $taxRepo = new TaxRepository($tax);
        $taxRepo->deleteTax();

        return redirect()->route('admin.taxes.index')->with('message', 'Delete successful');
    }

}
