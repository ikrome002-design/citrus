<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Admin;
use App\Shop\Customers\Customer;
use App\Shop\Countries\Country;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Customers\Requests\CreateCustomerRequest;
use App\Shop\Customers\Requests\UpdateCustomerRequest;
use App\Shop\Customers\Transformations\CustomerTransformable;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class CustomerController extends Controller
{
    use CustomerTransformable;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * CustomerController constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepo = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->customerRepo->listCustomers('created_at', 'desc');

        if (!empty(auth('vendor')->user()->id)) {
            $vid = auth('vendor')->user()->id;

            if (request()->has('q')) {
                $list = $this->customerRepo->searchCustomer(request()->input('q'));
            }

            $userAmt = DB::select("SELECT customers.* ,  SUM(order_payment.amount) AS totalAm FROM `customers` LEFT JOIN order_payment ON customers.id = order_payment.user_id where customers.merchant_id = $vid GROUP BY customers.id");


            $userAmt = json_decode(json_encode($userAmt), true);

            $customers = $list->map(function (Customer $customer) {
                return $this->transformCustomer($customer);
            })->all();

            return view('admin.customers.list', [
                'customers' => $this->customerRepo->paginateArrayResults($customers),
                'userAmt' => $this->customerRepo->paginateArrayResults($userAmt)
            ]);
        } else {
            if (request()->has('q')) {
                $list = $this->customerRepo->searchCustomer(request()->input('q'));
            }

            $userAmt = DB::select("SELECT customers.* ,  SUM(order_payment.amount) AS totalAm FROM `customers` LEFT JOIN order_payment ON customers.id = order_payment.user_id GROUP BY customers.id");


            $userAmt = json_decode(json_encode($userAmt), true);

            $customers = $list->map(function (Customer $customer) {
                return $this->transformCustomer($customer);
            })->all();

            return view('admin.customers.customer_all', [
                'customers' => $this->customerRepo->paginateArrayResults($customers),
                'userAmt' => $this->customerRepo->paginateArrayResults($userAmt)
            ]);
        }
    }



    public function customer_index()
    {
        $list = $this->customerRepo->listCustomers('created_at', 'desc');

        $vid = auth('admin')->user()->merchant_id;

        if (request()->has('q')) {
            $list = $this->customerRepo->searchCustomer(request()->input('q'));
        }

        $userAmt = DB::select("SELECT customers.* ,  SUM(order_payment.amount) AS totalAm FROM `customers` LEFT JOIN order_payment ON customers.id = order_payment.user_id where customers.merchant_id = $vid GROUP BY customers.id");

        $userAmt = json_decode(json_encode($userAmt), true);

        $customers = $list->map(function (Customer $customer) {
            return $this->transformCustomer($customer);
        })->all();

        return view('admin.customers.customer_list', [
            'customers' => $this->customerRepo->paginateArrayResults($customers),
            'userAmt' => $this->customerRepo->paginateArrayResults($userAmt)
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderby('id', 'asc')->get();
        $employees = Admin::where('merchant_id', auth('vendor')->user()->id)->get();
        return view('admin.customers.create', [
            'countries' => $countries,
            'employees' => $employees


        ]);
    }

    public function customer_create()
    {
        $countries = Country::orderby('id', 'asc')->get();

        return view('admin.customers.customer_create', [
            'countries' => $countries
            //'employees' => $employees


        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $this->customerRepo->createCustomer($request->except('_token', '_method'));

        return redirect()->route('admin.customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $customer = Customer::join('countries', 'customers.country', '=', 'countries.id')
            ->select('countries.id AS cid', 'countries.name AS cname', 'customers.*')
            ->where('customers.id', $id)
            ->first();

        $ords = DB::table('order_product')
            ->select('order_product.*', 'orders.*', 'addresses.address_1', 'products.cover')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->join('addresses', 'addresses.id', '=', 'orders.address_id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->join('order_payment', 'order_payment.order_id', '=', 'order_product.order_id')
            ->where('orders.customer_id', $id)
            ->get();

        return view('admin.customers.show', [
            'customer' => $customer,
            //'addresses' => $customer->addresses,
            'orders' => $ords

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show_customer(int $id)
    {
        $customer = Customer::join('countries', 'customers.country', '=', 'countries.id')
            ->select('countries.id AS cid', 'countries.name AS cname', 'customers.*')
            ->where('customers.id', $id)
            ->first();

        $ords = DB::table('order_product')
            ->select('order_product.*', 'orders.*', 'addresses.address_1', 'products.cover')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->join('addresses', 'addresses.id', '=', 'orders.address_id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->join('order_payment', 'order_payment.order_id', '=', 'order_product.order_id')
            ->where('orders.customer_id', $id)
            ->get();

        return view('admin.customers.customer_show', [
            'customer' => $customer,
            //'addresses' => $customer->addresses,
            'orders' => $ords

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.customers.edit', ['customer' => $this->customerRepo->findCustomerById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCustomerRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {

        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('customers')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('customers')->ignore($id)]
        ]);
        $customer = $this->customerRepo->findCustomerById($id);

        $update = new CustomerRepository($customer);
        $data = $request->except('_method', '_token', 'password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $update->updateCustomer($data);

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.customers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $customer = $this->customerRepo->findCustomerById($id);

        $customerRepo = new CustomerRepository($customer);
        $customerRepo->deleteCustomer();

        return redirect()->route('admin.customers.index')->with('message', 'Delete successful');
    }

    public function customerApprove($id)
    {

        $customer = $this->customerRepo->findCustomerById($id);
        if ($customer) {
            $customer->status = 1;
            $customer->save();
            return redirect()->back()->with('message', 'Status Approved Successfully');
        }
    }

    public function customerUnapprove($id)
    {
        $customer = $this->customerRepo->findCustomerById($id);
        if ($customer) {
            $customer->status = 0;
            $customer->save();
            return redirect()->back()->with('error', 'Status Unapproved Successfully');
        }
    }
}
