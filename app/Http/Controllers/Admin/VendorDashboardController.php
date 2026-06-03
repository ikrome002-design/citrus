<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Admins\Requests\CreateEmployeeRequest;
use App\Shop\Admins\Requests\UpdateEmployeeRequest;
use App\Shop\Employees\Requests\UpdateProfileRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Illuminate\Validation\Rule;

class VendorDashboardController extends Controller
{
    //

    /**
     * @var OrderStatusRepositoryInterface
     */
    private $orderStatusRepo;
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepo;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param RoleRepositoryInterface $roleRepository
     * @param OrderStatusRepositoryInterface $orderStatusRepository
     */

    public function __construct(

        EmployeeRepositoryInterface $employeeRepository,
        RoleRepositoryInterface $roleRepository,
        OrderStatusRepositoryInterface $orderStatusRepository
    ) {
        $this->employeeRepo = $employeeRepository;
        $this->roleRepo = $roleRepository;
        $this->orderStatusRepo = $orderStatusRepository;

        //$this->middleware(['permission:update-order, guard:employee'], ['only' => ['edit', 'update']]);
    }



    public function index(Request $request)
    {
        $uid = auth('vendor')->user()->id;
        date_default_timezone_set("Asia/Kolkata");
        $ddate = date('d-M-Y');

        $merchant_shop = DB::table('shops')->where('merchant_id', $uid)->where('type', 'default')->orderby('id', 'asc')->first();

        $plans =  DB::table('memberships')->orderby('id', 'asc')->get();

        $vendor_msg =  DB::table('vendor_msg')->where('vendor_id', $uid)->where('reply_id', NULL)->orderBy('id', 'desc')->limit(4)->get();

        $vendor_msg_count = DB::table("vendor_msg")->where('vendor_id', $uid)->where('status', 'replied')->where('read_status', '1')->count();


        $replied_at = date('Y-m-d ');

        $payout =  DB::table('order_product')
            ->join('shops', 'order_product.shop_id', '=', 'shops.id')
            ->select('shops.id AS sId', 'order_product.*')
            ->where('shops.type', 'default')
            ->where('order_product.vendor_id', $uid)
            ->where('order_product.date', $replied_at)
            ->get();

        $orders_count = count($payout);


        $product =  DB::table('products')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->select('shops.id AS sId', 'products.*')
            ->where('vendor_id', $uid)
            ->where('shops.type', 'default')
            ->orderBy('id', 'desc')
            ->limit(3)->get();

        $shops =  DB::table('shops')
            ->join('business_type', 'shops.title', '=', 'business_type.id')
            ->select('business_type.title AS business_title', 'business_type.id AS bid', 'shops.*')
            ->where('shops.merchant_id', $uid)
            ->where('shops.type', NULL)
            ->orderby('shops.id', 'desc')
            ->get();

        $totalorder =  DB::table('order_product')
            ->join('shops', 'order_product.shop_id', '=', 'shops.id')
            ->select('shops.id AS sId', 'order_product.*')
            ->where('order_product.vendor_id', $uid)
            ->where('shops.type', 'default')
            ->get();


        $total = count($totalorder);

        $best_product = DB::table('order_product')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->select('products.id', 'products.name', 'products.cover', 'order_product.product_price', 'order_product.product_id', 'shops.id AS sId', 'order_product.id AS oId', DB::raw('COUNT(order_product.product_id) as total'))
            ->where('order_product.vendor_id', $uid)
            ->where('shops.type', 'default')
            ->groupBy('products.id', 'order_product.product_id', 'products.name')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();
        $cdate = date("Y");
        $orders_chart = DB::table('order_product')
            ->select(DB::raw('count(distinct(order_id)) as orderData'),  DB::raw('YEAR(date) as year, MONTHNAME(date) as month_name'))
            ->where('shop_id', $merchant_shop->id)
            ->where('vendor_id', $uid)
            ->whereYear('date', $cdate)
            ->groupBy('year', 'month_name')
            ->get();


        $output = [];
        foreach ($orders_chart as $order_chart) {
            $output[] = array(
                'month_name'   => $order_chart->month_name,
                'orderData'  => $order_chart->orderData
            );
        }

        if (!empty($output)) {
            $newData = '';
            foreach ($output as $key => $value) {
                if (isset($value['month_name'])) {
                    $month_name = $value['month_name'];
                } else {
                    $month_name = 0;
                }
                if (isset($value['orderData'])) {
                    $orderData = $value['orderData'];
                } else {
                    $orderData = 0;
                }
                $newData .= '[' . "'" . $month_name . "'" . ',' . $orderData . '],';
            }
            $newData = rtrim($newData, ',');
        } else {

            $month_name = 0;
            $orderData = 0;
            $newData = '[' . "'" . $month_name . "'" . ',' . $orderData . ']';
        }

        //echo "<pre>";print_r($newData); die();

        return view('vendor.dashboard', ["vendor_msg" => $vendor_msg, "ddate" => $ddate, "payout" => $payout, "product" => $product, "totalorder" => $totalorder, "total" => $total, "orders_count" => $orders_count, "best_product" => $best_product, "vendor_msg_count" => $vendor_msg_count, "shops" => $shops, "plans" => $plans, "newData" => $newData]);
    }

    public function shop_index(Int $id)
    {

        $shop_show =  DB::table('shops')
            ->join('business_type', 'shops.title', '=', 'business_type.id')
            ->select('business_type.title AS business_title', 'business_type.id AS bid', 'shops.*')
            ->where('shops.id', $id)
            ->first();
        $uid = auth('vendor')->user()->id;

        $plans =  DB::table('memberships')->orderby('id', 'asc')->get();

        date_default_timezone_set("Asia/Kolkata");
        $ddate = date('d-M-Y');

        $replied_at = date('Y-m-d ');

        $payout =  DB::table('order_product')
            ->join('shops', 'order_product.shop_id', '=', 'shops.id')
            ->select('shops.id AS sId', 'order_product.*')
            ->where('shops.id', $id)
            ->where('order_product.vendor_id', $uid)
            ->where('order_product.date', $replied_at)
            ->get();
        $orders_count = count($payout);

        $shops =  DB::table('shops')
            ->join('business_type', 'shops.title', '=', 'business_type.id')
            ->select('business_type.title AS business_title', 'business_type.id AS bid', 'shops.*')
            ->where('shops.merchant_id', $uid)
            ->where('shops.id', '!=', $id)
            ->where('shops.type', NULL)
            ->orderby('shops.id', 'desc')
            ->get();

        $totalorder =  DB::table('order_product')
            ->join('shops', 'order_product.shop_id', '=', 'shops.id')
            ->select('shops.id AS sId', 'order_product.*')
            ->where('order_product.vendor_id', $uid)
            ->where('shops.id', $id)
            ->get();

        $total = count($totalorder);

        $product_count = DB::table('products')->where('vendor_id', auth('vendor')->user()->id)->where('shop_id', $id)->count();

        $best_product = DB::table('order_product')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->select('products.id', 'products.name', 'products.cover', 'order_product.product_price', 'order_product.product_id', 'shops.id AS sId', 'order_product.id AS oId', DB::raw('COUNT(order_product.product_id) as total'))
            ->where('order_product.vendor_id', $uid)
            ->where('shops.id', $id)
            ->groupBy('products.id', 'order_product.product_id', 'products.name')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        $cdate = date("Y");
        $orders_chart = DB::table('order_product')
            ->select(DB::raw('count(distinct(order_id)) as orderData'),  DB::raw('YEAR(date) as year, MONTHNAME(date) as month_name'))
            ->where('shop_id', $id)
            ->where('vendor_id', $uid)
            ->whereYear('date', $cdate)
            ->groupBy('year', 'month_name')
            ->get();

        $output = [];
        foreach ($orders_chart as $order_chart) {
            $output[] = array(
                'month_name'   => $order_chart->month_name,
                'orderData'  => $order_chart->orderData
            );
        }

        if (!empty($output)) {
            $newData = '';
            foreach ($output as $key => $value) {
                if (isset($value['month_name'])) {
                    $month_name = $value['month_name'];
                } else {
                    $month_name = 0;
                }
                if (isset($value['orderData'])) {
                    $orderData = $value['orderData'];
                } else {
                    $orderData = 0;
                }
                $newData .= '[' . "'" . $month_name . "'" . ',' . $orderData . '],';
            }
            $newData = rtrim($newData, ',');
        } else {

            $month_name = 0;
            $orderData = 0;
            $newData = '[' . "'" . $month_name . "'" . ',' . $orderData . ']';
        }


        return view('vendor.dashboard', ["ddate" => $ddate, "payout" => $payout, "totalorder" => $totalorder, "total" => $total, "orders_count" => $orders_count, "shops" => $shops, "shop_show" => $shop_show, "product_count" => $product_count, "plans" => $plans, "best_product" => $best_product, "newData" => $newData]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staff_index()
    {

        // $list = $this->employeeRepo->listEmployees('created_at', 'desc');
        $list = Admin::where('merchant_id', auth('vendor')->user()->id)->where('shop_id', NULL)->orderBy('id', 'desc')->get();

        return view('admin.staffs.list', [
            'employees' => $list
        ]);
    }

    public function shop_staff_index(int $id)
    {

        // $list = $this->employeeRepo->listEmployees('created_at', 'desc');
        $list = Admin::where('merchant_id', auth('vendor')->user()->id)->where('shop_id', $id)->orderBy('id', 'desc')->get();

        return view('admin.staffs.list', [
            'employees' => $list
        ]);
    }


    public function create()
    {
        $roles = $this->roleRepo->listRoles();

        return view('admin.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEmployeeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);
            $id = Admin::max('id') + 1;
            $destinationPath = 'storage/profile/users/' . $id;
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        $employee = $this->employeeRepo->createEmployee($request->all());

        // if ($request->has('role')) {
        //     $employeeRepo = new EmployeeRepository($employee);
        //     $employeeRepo->syncRoles([$request->input('role')]);
        // }

        return redirect()->back()->with('message', 'Created successfully');
    }


    public function show(int $id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.staffs.show', ['admin' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $roles = $this->roleRepo->listRoles('created_at', 'desc');
        //$isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        return view(
            'admin.staffs.edit',
            [
                'admin' => $employee,
                'roles' => $roles,
                'selectedIds' => $employee->roles()->pluck('role_id')->all()
            ]
        );
    }

    public function shop_edit(int $shopId, $employeeId)
    {
        $employee = $this->employeeRepo->findEmployeeById($employeeId);
        $roles = $this->roleRepo->listRoles('created_at', 'desc');

        return view(
            'admin.staffs.edit',
            [
                'admin' => $employee,
                'roles' => $roles,
                'selectedIds' => $employee->roles()->pluck('role_id')->all()
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('employees')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('employees')->ignore($id)]
        ]);

        $employee = $this->employeeRepo->findEmployeeById($id);
        //$isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password')) {

            return redirect()->route('staffs.edit', $id)
                ->with('error', 'Password and confirmed password do not match');
        }

        $empRepo = new EmployeeRepository($employee);
        $empRepo->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && !empty($request->input('password'))) {
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
        }

        // if ($request->has('roles') and !$isCurrentUser) {
        //     $employee->roles()->sync($request->input('roles'));
        // } elseif (!$isCurrentUser) {
        //     $employee->roles()->detach();
        // }
        if ($request->has('avatar') && $request->file('avatar') != '') {
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            $destinationPath = 'storage/profile/users/' . $id;
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        return redirect()->back()->with('message', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->deleteEmployee();
        DB::table("employees")->where("id", $id)->delete();
        //DB::table("role_user")->where([  ['user_id', $id],  ['role_id', 2] ])->delete();

        return redirect()->back()->with('message', 'Delete successfully');
    }

    public function employeeApprove($id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        if ($employee) {
            $employee->status = 1;
            $employee->save();
            return redirect()->back()->with('message', 'Status Approved Successfully');
        }
    }

    public function employeeUnapprove($id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        if ($employee) {
            $employee->status = 0;
            $employee->save();
            return redirect()->back()->with('error', 'Status Unapproved Successfully');
        }
    }

    public function package(int $id)
    {

        $plan = DB::table('memberships')->where('id', $id)->get();
        if ($id == 1) {
            $newDateTime = Carbon::now()->addMonths(1);
        } elseif ($id == 2) {
            $newDateTime = Carbon::now()->addMonths(6);
        } else {
            $newDateTime = Carbon::now()->addMonths(12);
        }
        $data = DB::table('plan_in')->insert(
            array(

                'plan_id'    =>  $id,
                'vendor_id'  => auth('vendor')->user()->id,
                'price'      =>  $plan[0]->price,
                'expiry_date' => $newDateTime
            )
        );
        $current_timestamp = Carbon::now();

        $plans_in =  DB::table('plan_in')->where('vendor_id', auth('vendor')->user()->id)->where('expiry_date', '>=', $current_timestamp)->orderby('id', 'desc')->count();
        Session::put('plans_in', $plans_in);

        return redirect()->back()->with('message', 'Package buy successfully');
    }
}