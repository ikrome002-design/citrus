<?php
namespace App\Http\Controllers\Vendor;
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Stripe;
use DB;
use App\Vendor; 
   
class VendorStripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    { 
        return view('front.vendor_stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor_stripePost(Request $request)
    {
        $data['price'] = $_POST['totAmt'];
        $data['plan_name'] = $_POST['planName'];
        $data['plan_id'] = $_POST['planId'];
        $data['vendor_id'] = $_POST['vendorId'];
        $data['date'] = date('Y-m-d');

        $dt = strtotime(date("Y-m-d"));
        $data['expiry_date'] = date("Y-m-d", strtotime("+1 month", $dt));
        

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $srtipeResponse = Stripe\Charge::create ([
                "amount" => $data['price'] * 100 ,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "Payment" 
        ]);

        DB::table('vendorplan_info')->insert($data);

        $res['payment_status'] = 1;
        $vendor = Vendor::where('id', $data['vendor_id'])->update($res);
        return redirect()->route('vendor.dashboard')->with('message', 'Payment successfully');

        // Session::flash('success', 'Payment successful!');
        // return view('front.thankyou',[
        //     'order' => $order,
        //     'customer' => $customer,
        //     'country' => $country_details,
        //     'address' => $addresses,
        //     'amount' => $amount
        // ]);
        // return back();

    }
}