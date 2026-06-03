<?php

namespace App\Http\Controllers\Front\Payments;

use Stripe;
use App\Http\Controllers\Controller;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Shipping\ShippingInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use DB;
use Shippo_Shipment;
use Shippo_Transaction;
use App\OrderPayment;

class CashOnDelivController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var int $shipping
     */
    private $shippingFee;

     /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;


    private $rateObjectId;

    private $shipmentObjId;

    private $billingAddress;

    private $carrier;

    /**
     * CashOnDelivController constructor.
     *
     * @param Request $request
     * @param CartRepositoryInterface $cartRepository
     * @param ShippingInterface $shippingRepo
     */
    public function __construct(
        Request $request,
        CartRepositoryInterface $cartRepository,
        CustomerRepositoryInterface $customerRepository,
        ShippingInterface $shippingRepo
    )
    {
        $this->cartRepo = $cartRepository;
        $this->customerRepo = $customerRepository;
        $fee = 0;
        $rateObjId = null;
        $shipmentObjId = null;
        $billingAddress = $request->input('billing_address');

        if ($request->has('rate')) {
            if ($request->input('rate') != '') {

                $rate_id = $request->input('rate');
                $rates = $shippingRepo->getRates($request->input('shipment_obj_id'));
                $rate = collect($rates->results)->filter(function($rate) use ($rate_id) {
                    return $rate->object_id == $rate_id;
                })->first();

                $fee = $rate->amount;
                $rateObjId = $rate->object_id;
                $shipmentObjId = $request->input('shipment_obj_id');
                $this->carrier = $rate;
            }
        }

        $this->shippingFee = $fee;
        $this->rateObjectId = $rateObjId;
        $this->shipmentObjId = $shipmentObjId;
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $count = Cart::count();
        if($count==0)
        {
            $card_products = Cart::content();
            return view('front.carts.cart',['cartItems'=>$card_products]);
        }
        //$tax=$_GET['taxx'];
        $subtotal=$_GET['newSub'];
        return view('front.cash-transfer-redirect', [
            'subtotal' => $subtotal,
            'shipping' => $this->shippingFee,
            //'tax' => $tax,
            'total' => $this->cartRepo->getTotal(2, $this->shippingFee),
            'rateObjectId' => $this->rateObjectId,
            'shipmentObjId' => $this->shipmentObjId,
            'billingAddress' => $this->billingAddress
        ]);
    }

    /**
     * @param Request $request
    

     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $count = Cart::count();
        if($count==0)
        {
            $card_products = Cart::content();
            return view('front.carts.cart',['cartItems'=>$card_products]);
        }
        
        $payment = $_POST['payment']; 
        if($payment=='stripe')
        {
            $oId = 3;
        }else{
            $oId = 1;
        }
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findOrderStatusById($oId);
        date_default_timezone_set("Asia/Kolkata");
        $datee=date('Y-m-d');
        
  
        $order = $checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => 1, // @deprecated
            'customer_id' => $request->user()->id,
            'address_id' => $request->input('billing_address'),
            'delivery_address' => $request->input('delivery_address'),
            'order_status_id' => $os->id,
            'payment' => $payment,
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            //'total' => $this->cartRepo->getTotal(2, $this->shippingFee),
            'total' => $_POST['NewamountSum'],
            'total_shipping' => $_POST['shippingAmt'],
            'total_paid' => 0,
            'date' => $datee,
            'tax' => $this->cartRepo->getTax()
        ]);

        $card_products = Cart::content();
        foreach($card_products as $k => $v) { 
            $card_products_groups[$v->product['vendor_id']][]=$v; 
        }
        
        $cc=count($card_products_groups);
        $vendor_ids = array_keys($card_products_groups);
      
        for($i=0; $i < count($vendor_ids) ; $i++){
            $total = 0;
            $price = 0;
            $qty = 0;
            foreach ($card_products_groups[$vendor_ids[$i]] as $card_products_group) {
                
                $qty = $card_products_group->qty;
                $price = $card_products_group->sale_price ? $card_products_group->sale_price : $card_products_group->price;
               
                $total = $price*$qty + $total ;
            }
        }
        
        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = Shippo_Shipment::retrieve($this->shipmentObjId);

            $details = [
                'shipment' => [
                    'address_to' => json_decode($shipment->address_to, true),
                    'address_from' => json_decode($shipment->address_from, true),
                    'parcels' => [json_decode($shipment->parcels[0], true)]
                ],
                'carrier_account' => $this->carrier->carrier_account,
                'servicelevel_token' => $this->carrier->servicelevel->token
            ];

            $transaction = Shippo_Transaction::create($details);

            if ($transaction['status'] != 'SUCCESS') {
                Log::error($transaction['messages']);
                return redirect()->route('checkout.index')->with('error', 'There is an error in the shipment details. Check logs.');
            }

            $orderRepo = new OrderRepository($order);
            $orderRepo->updateOrder([
                'courier' => $this->carrier->provider,
                'label_url' => $transaction['label_url'],
                'tracking_number' => $transaction['tracking_number']
            ]);
        }
        
        
        // Cart::destroy();
        $order=DB::table("orders")->where("id", $order->id)->first();
        // $order_product1=DB::table("order_product")->where("order_id", $order->id)->get();
        $order_product = DB::table('products')->join('order_product', 'products.id', '=', 'order_product.product_id')
           ->select('products.cover','order_product.quantity','order_product.product_name','order_product.product_price','order_product.quantity')
            ->where('order_product.order_id',$order->id)
           ->get();
    
        $customer = $this->customerRepo->findCustomerById($order->customer_id);
        $addresses=DB::table("addresses")->where("id", $order->address_id )->first();
        $country_details=DB::table("countries")->where("id", $addresses->country_id )->first();

        $del_address = $_POST['delivery_address'];  
        $shippingAmt = $_POST['shippingAmt']; 
        
        if($payment == 'stripe'){
        // return view('front.stripe',[
        //     'customer' => $customer,
        //     'order' => $order,
        //     'order_product' => $order_product,
        //     'country' => $country_details,
        //     'address' => $addresses,
        //     'card_products_groups'=>$card_products,
        //     'delivery_address' =>$del_address,
        //     'vendor_ids' =>$vendor_ids,
        //     'shippingAmt' =>$shippingAmt,
        //     //'tax' =>$tax

        // ]);

        Cart::destroy();
            $data['user_id'] = $order->customer_id;
            $data['order_id'] = $order->id;
            $data['name'] = $customer->name;
            $data['amount'] = $_POST['NewamountSum'];
            $token = $order->token;
            $data['token'] = $token;
            OrderPayment::create($data);
            return view('front.thankyou',[
                'customer' => $customer,
                'order' => $order,
                'order_product' => $order_product,
                'country' => $country_details,
                'address' => $addresses,
                'card_products_groups'=>$card_products,
                'delivery_address' =>$del_address,
                'vendor_ids' =>$vendor_ids,
                'amount' =>$data['amount']

            ]);    
        }else{
            Cart::destroy();
            $data['user_id'] = $order->customer_id;
            $data['order_id'] = $order->id;
            $data['name'] = $customer->name;
            $data['amount'] = $_POST['NewamountSum'];

            $token = $order->token;
            $data['token'] = $token;
            OrderPayment::create($data);
            return view('front.thankyou',[
                'customer' => $customer,
                'order' => $order,
                'order_product' => $order_product,
                'country' => $country_details,
                'address' => $addresses,
                'card_products_groups'=>$card_products,
                'delivery_address' =>$del_address,
                'vendor_ids' =>$vendor_ids,
                'amount' =>$data['amount']

            ]);
        }
        
        //return redirect()->route('accounts', ['tab' => 'orders'])->with('message', 'Order successful!');
    }
}