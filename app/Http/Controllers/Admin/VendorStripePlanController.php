<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Stripe;
use Illuminate\Support\Facades\DB;

class VendorStripePlanController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    { 
        return view('vendor.vendor_plan_stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor_planStripePost(Request $request)
    {
        $data['price'] = $_POST['totAmt'];
        $data['plan_name'] = $_POST['planName'];
        $data['plan_id'] = $_POST['planId'];
        $data['vendor_id'] = $_POST['vendorId'];
        $plan_variant = $_POST['plan_variant'];

        $data['date'] = date('Y-m-d');
        $dt = strtotime(date("Y-m-d"));
        if($plan_variant==1){
            $data['expiry_date'] = date("Y-m-d", strtotime("+1 month", $dt));
        }else{
            $data['expiry_date'] = date("Y-m-d", strtotime("+1 year", $dt));
        }
        

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $srtipeResponse = Stripe\Charge::create ([
                "amount" => $data['price'] * 100 ,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "Payment" 
        ]);

        $venInfoCount = DB::table('vendorplan_info')
            ->where('plan_id', '=', $data['plan_id'])
            ->where('vendor_id', '=', $data['vendor_id'])
            ->count();
        if($venInfoCount == 0){
            DB::table('vendorplan_info')->insert($data);    
        }else{
            DB::table('vendorplan_info')->update($data); 
        }

        $plan_id=$data['plan_id'];
        $plan_upgrade = DB::table('vendors')->where('vendors.id', $data['vendor_id'])->update(['plan_id' => $plan_id]);
        return redirect()->route('vendor.plan')->with('message', 'Your plan upgrade successfully');

    }
}