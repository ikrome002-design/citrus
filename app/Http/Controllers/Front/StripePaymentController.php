<?php
   
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\OrderPayment;
use App\Shop\Orders\Repositories\OrderRepository;
use Session;
use Stripe;
use DB;
use SendGrid;


class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $count = Cart::count();
        if($count==0)
        {
            $card_products = Cart::content();
            return view('front.carts.cart',['cartItems'=>$card_products]);
        }
        return view('front.stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

        
            $count = Cart::count();

        if($count==0)
        {
            $card_products = Cart::content();
            return view('front.carts.cart',['cartItems'=>$card_products]);
        }

      
           $amount = $_POST['amount'];
           
            $a = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $srtipeResponse = Stripe\Charge::create ([
                    "amount" => $amount * 100,
                    "currency" => "INR",
                    "source" => $request->stripeToken,
                    "description" => "Stripe payment"
            ]);


            try {

            $data['stripe_response'] = $srtipeResponse;
            $data['user_id'] = $_POST['custId'];
            $data['order_id'] = $_POST['orderId'];
            $data['name'] = $_POST['nameOnCard'];
            $data['stripe_id'] = $request->stripeToken;
            $data['amount'] = $amount;


            $stripe_cost = ($amount - 0.30);
            $admin_deducted = ($stripe_cost * 2.9)/100;
            $vendor_withdraw = ($stripe_cost - $admin_deducted);

            $product_id = json_decode($_POST['data1']);
            $vendor_ids = json_decode($_POST['vendor_ids'],true);
            $proIdCount = count($product_id);

            foreach($vendor_ids as $id){
                $vendor = DB::table('vendors')->where('id',$id)->first();
                $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif;'>
                   <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border:solid #ddddddb5 2px;'>
                      <tbody>
                         <tr>
                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                               <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                                  <tbody>
                                   
                                     <tr>
                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                           <table style='width:100%;border-collapse:collapse'>
                                              <tbody>
                                                 <tr style='background-color:#93EB8B'>
                                                    <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                                       <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'>Details of your latest order through ".getenv('APP_SHORT_NAME')."!</b> </p>
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                   <td>
                                                     <h2 style='color:#206080;line-height: 1;text-align: center;'>NEW ORDER NOTIFICATION</h2>
                                                   </td>
                                                 </tr>
                                              </tbody>
                                           </table>
                                        </td>
                                     </tr>

                                     <tr>
                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                           <table style='width:100%;border-collapse:collapse'>
                                           </table>
                                        </td>
                                     </tr>
                                        <tr>
                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                           <table style='width:100%;border-collapse:collapse'>
                                              <tbody>
                                                 <tr>
                                                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                                       <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$vendor->name."! </h3>
                                                       <p style='margin:5px 0 0 0;font:16px Arial,sans-serif'> A customer just placed a new order on your BuyVi page. Log into your vendor account now to view the details and start processing their order!</p>
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
                                                 </tr>
                                              </tbody>
                                           </table>
                                        </td>
                                     </tr>
                                      <tr>
                                          <td style='width:70%;text-align:left!important;line-height:50px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
                                              <a style='text-decoration: none;border: 1px solid black;padding: 10px;font-weight: 700;background-color: #206080;color:#93EB8B;' href= ' ". route('vendor.login')." '>VENDOR LOGIN </a>
                                          </td>
                                       </tr>                   
                                     <tr>
                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                           <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                              <tbody>
                                                 <tr>
                                                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                                       <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'>Still having technical issues? Please contact us at support@buyvi.ca </p>
                                                    </td>
                                                 </tr>
                                              </tbody>
                                           </table>
                                        </td>
                                     </tr>
                                  </tbody>
                               </table>
                            </td>
                         </tr>
                      </tbody>
                   </table>
                </div>";
                $emails = $vendor->email;
                $subject = 'You Just Received A New order!';
                $senderEmail = getenv('SENDGRID_EMAIL'); //SENDER_EMAIL
                $senderName = getenv('APP_NAME'); //SENDER_NAME
               
                $emailReports = [];
                $addressesArray = $emails;
                $email = new SendGrid\Mail\Mail();
                $email->setFrom($senderEmail, $senderName);
                $email->setSubject($subject);
                $email->addTo($addressesArray);
                $email->addContent("text/html", $html );
                $apiKey = getenv('SENDGRID_API_KEY');
                $sendgrid = new \SendGrid($apiKey);
                
                try {
                    $response = $sendgrid->send($email);
                    array_push($emailReports, $addressesArray . " => " . $response->statusCode());
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }//endMailForeach


            $order=DB::table("orders")->where("id", $data['order_id'])->first();
            $customer=DB::table("customers")->where("id", $data['user_id'])->first();
            $addresses=DB::table("addresses")->where("id", $order->address_id )->first();
            $country_details=DB::table("countries")->where("id", $addresses->country_id )->first();
            $token = $order->token;
            $data['token'] = $token;
            OrderPayment::create($data);
            DB::table('orders')->where('token', $token)->update(array('order_status_id' => 1)); 
            Cart::destroy();

            Session::flash('success', 'Payment successful!');
            return view('front.thankyou',[
                'order' => $order,
                'customer' => $customer,
                'country' => $country_details,
                'address' => $addresses,
                'amount' => $amount
            ]);   
        } catch (Exception $e) {
           echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        // return back();

    }
}