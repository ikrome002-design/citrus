<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\User;
use App\Shop\Customers\Customer;
use App\Shop\Vendors\Vendor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //admin dashboard
    public function index()
    {

        $customers = User::take(5)->orderBy('created_at', 'desc')->get();
        $merchants = Merchant::take(5)->orderBy('created_at', 'desc')->get();
        $merchant_count = Merchant::count();

        return view('admin.dashboard', compact('customers', 'merchants', 'merchant_count'));
    }

    public function staff_index()
    {

        $breadcumb = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'fa fa-dashboard'],
            ['name' => 'Home', 'url' => route('admin.dashboard'), 'icon' => 'fa fa-home'],
        ];
        populate_breadcumb($breadcumb);

        // get newly signed up customers
        $customers = Customer::take(5)->orderBy('created_at', 'desc')->get();
        // get newly signed up customers
        $vendors = Vendor::take(5)->orderBy('created_at', 'desc')->get();

        if (isset(auth('vendor')->user()->id)) {
            $uid = auth('vendor')->user()->id;

            $vendor_msg = DB::table('vendor_msg')->where('vendor_id', $uid)->where('reply_id', null)->orderBy('id', 'desc')->limit(3)->get();
            $vendor_msg_count = 0;
        } else {

            $vendor_msg = DB::table('vendor_msg')->where('reply_id', null)->orderBy('id', 'desc')->limit(3)->get();
            $vendor_msg_count = 0;
        }

        date_default_timezone_set('Asia/Kolkata');
        $replied_at = date('Y-m-d ');
        $firstdate = date('Y-m-01');

        $orders = DB::table('orders')
            ->where('date', $replied_at)
            ->join('order_payment', 'order_payment.token', '=', 'orders.token')
            ->orderBy('orders.id', 'desc')
            ->get();
        $orders_count = count($orders);

        $fdate = DB::table('orders')
            ->whereBetween('orders.date', [$firstdate, $replied_at])
            ->select('orders.total', 'orders.total_shipping', 'orders.tax', 'orders.token')
            ->join('order_payment', 'order_payment.token', '=', 'orders.token')
            ->get();
        $fdate_count = count($fdate);

        $spent = DB::table('orders')
            ->selectRaw("customers.id, COUNT('orders.*') as ordersCount")
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->groupBy('customers.id')
            ->orderBy('ordersCount', 'desc')
            ->take(1)
            ->first();

        if (isset($spent)) {
            $sid = $spent->id;
        } else {
            $sid = 0;
        }
        $spent_detail = DB::table('orders')
            ->where('customer_id', $sid)
            ->join('order_payment', 'order_payment.token', '=', 'orders.token')->get();
        $user_detail = DB::table('customers')->where('id', $sid)->first();

        $date = date('Y-m-d');

        $allPlans = DB::select("select month(date) as month, plan_name from vendorplan_info WHERE '$date' BETWEEN date AND expiry_date group by plan_name");

        $end_date = date('Y-m-d');
        //FOR VENDOR CHART

        $TotalSpent = DB::select("select year(date) as year, month(date) as month, sum(price) as total_amount from vendorplan_info WHERE '$date' BETWEEN date AND expiry_date group by year(date), month(date)");

        $TotalSpent1 = DB::select("select month(date) as month, sum(price) as total_amount from vendorplan_info WHERE '$date' BETWEEN date AND expiry_date group by plan_id ");

        if (isset(auth('admin')->user()->id)) {
            $idd = auth('admin')->user()->id;
            $admintype = Admin::where('id', $idd)->first();
            $type = $admintype->type;
        }

        return view('admin.dashboard', [
            'customers' => $customers,
            'vendors' => $vendors,
            'vendor_msg' => $vendor_msg,
            'orders_count' => $orders_count,
            'fdate' => $fdate,
            'fdate_count' => $fdate_count,
            'spent' => $spent,
            'spent_detail' => $spent_detail,
            'user_detail' => $user_detail,
            'TotalSpent' => $TotalSpent,
            'allPlans' => $allPlans,
            'TotalSpent1' => $TotalSpent1,
            'type' => $type,
            'vendor_msg_count' => $vendor_msg_count,

        ]);
    }
}
