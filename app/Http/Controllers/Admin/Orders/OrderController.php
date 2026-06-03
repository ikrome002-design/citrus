<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Vendors\Vendors;
use App\Shop\Vendors\Repositories\Interfaces\VendorRepositoryInterface;
use App\Shop\Vendors\Repositories\VendorRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
 use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    use AddressTransformable;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var OrderStatusRepositoryInterface
     */
    private $orderStatusRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        VendorRepositoryInterface $vendorRepository,
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderStatusRepositoryInterface $orderStatusRepository
    ) {
        $this->orderRepo = $orderRepository;
        $this->vendorRepo = $vendorRepository;
        $this->courierRepo = $courierRepository;
        $this->customerRepo = $customerRepository;
        $this->orderStatusRepo = $orderStatusRepository;

        $this->middleware(['permission:update-order, guard:employee'], ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        $orders = DB::table('orders')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->join('addresses', 'orders.delivery_address', '=', 'addresses.id')
            ->select('orders.*','orders.id as order_id', 'order_statuses.name as order_status', 'order_statuses.color as status_color', 'addresses.*')
            ->groupBy('orders.id')
            ->orderBy('orders.id','desc')
            ->get();

            $productDetails=array();
            foreach ($orders as $order) {
                $products_list = DB::table('order_product')->select('product_sku', 'product_id')->where('order_id', $order->order_id)->get();
            
                $products =array();
                $i=0;
                foreach ($products_list as $product) {
                    $products[$i]['sku'] = $product->product_sku;
                    $products[$i]['id'] = $product->product_id;
                    $i++;
                }
                 $order->products = $products;

            }
            
        $ordersStatus = $this->orderStatusRepo->listOrderStatuses();

        return view('admin.orders.list', [
            'ordersStatus' => $ordersStatus,
            'orders' => $orders
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorIndex()
    {
      
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        $orders = DB::table('orders')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->join('addresses', 'orders.delivery_address', '=', 'addresses.id')
            ->select('orders.*','orders.id as order_id', 'order_statuses.name as order_status', 'order_statuses.color as status_color', 'addresses.*')
            ->groupBy('orders.id')
            ->get();

            $productDetails=array();
            foreach ($orders as $order) {
                $products_list = DB::table('order_product')->select('product_sku', 'product_id')->where('order_id', $order->order_id)->get();
                // print_r($product_sku);die;
                $products =array();
                $i=0;
                foreach ($products_list as $product) {
                    $products[$i]['sku'] = $product->product_sku;
                    $products[$i]['id'] = $product->product_id;
                    $i++;
                }
                 $order->products = $products;

            }
            
        $ordersStatus = $this->orderStatusRepo->listOrderStatuses();

        return view('vendor.orders.list', [
            'ordersStatus' => $ordersStatus,
            'orders' => $orders
        ]);
    }


      public function order_index()
    {
        $uid=auth('vendor')->user()->id;
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        $merchant_shop=DB::table('shops')->where('merchant_id',$uid)->where('type','default')->first();
        $orders = DB::table('order_product')
            ->select('order_product.order_id', 'order_product.shop_id', 'order_product.date')
            ->where('vendor_id', $uid)
            ->where('shop_id', $merchant_shop->id)
            ->groupBy('order_product.order_id','order_product.shop_id')
            ->get();
            //echo "<pre>";print_r($orders); die();

            $productDetails=array();
            foreach ($orders as $order) {
            $products_list = DB::table('order_product')->select('product_sku', 'product_id', 'product_price', 'quantity', 'shipping', 'order_status')->where('order_id', $order->order_id)->where('shop_id', $order->shop_id)->get();
                
                $products =array();
                $q=0;
                $i=0;
                foreach ($products_list as $product) {
                    $products[$i]['sku'] = $product->product_sku;
                    $products[$i]['id'] = $product->product_id;
                    $products[$i]['product_price'] = $product->product_price;
                    $products[$i]['quantity'] = $product->quantity;
                    $products[$i]['shipping'] = $product->shipping;
                   
                    
                    $i++;
                }
                 $order->products = $products;

            }
            
        $ordersStatus = $this->orderStatusRepo->listOrderStatuses();

        return view('vendor.orders.list', [
            'ordersStatus' => $ordersStatus,
            'orders' => $orders
        ]);
    }


      public function shop_order_index($id)
    {

        $uid=auth('vendor')->user()->id;
        $list = $this->orderRepo->listOrders('created_at', 'desc');
        
        $orders = DB::table('order_product')
            ->select('order_product.order_id', 'order_product.shop_id', 'order_product.date')
            ->where('vendor_id', $uid)
            ->where('shop_id', $id)
            ->groupBy('order_product.order_id','order_product.shop_id')
            ->get();
            

            $productDetails=array();
            foreach ($orders as $order) {
            $products_list = DB::table('order_product')->select('product_sku', 'product_id', 'product_price', 'quantity', 'shipping', 'order_status')->where('order_id', $order->order_id)->where('shop_id', $order->shop_id)->get();
                
                $products =array();
                $q=0;
                $i=0;
                foreach ($products_list as $product) {
                    $products[$i]['sku'] = $product->product_sku;
                    $products[$i]['id'] = $product->product_id;
                    $products[$i]['product_price'] = $product->product_price;
                    $products[$i]['quantity'] = $product->quantity;
                    $products[$i]['shipping'] = $product->shipping;
                   
                    
                    $i++;
                }
                 $order->products = $products;

            }
            
            
        $ordersStatus = $this->orderStatusRepo->listOrderStatuses();

        return view('vendor.orders.shop_list', [
            'ordersStatus' => $ordersStatus,
            'orders' => $orders
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int $orderId
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {

        $order = $this->orderRepo->findOrderById($orderId);

        $orderRepo = new OrderRepository($order);
        $order->courier = $orderRepo->getCouriers()->first();
        $order->address = $orderRepo->getAddresses()->first();
        $items = $orderRepo->listOrderedProducts();

        return view('admin.orders.show', [
            'order' => $order,
            'items' => $items,
            'customer' => $this->customerRepo->findCustomerById($order->customer_id),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order->order_status_id),
            'payment' => $order->payment,
            'user' => auth()->guard('employee')->user()
        ]);
    }


     /**
     * Display the specified resource.
     *
     * @param  int $orderId
     * @return \Illuminate\Http\Response
     */
    public function showw($orderId)
    { 
        $order = $this->orderRepo->findOrderById($orderId);


        $orderRepo = new OrderRepository($order);
        $order->courier = $orderRepo->getCouriers()->first();

        $order->address = $orderRepo->getAddresses()->first();

        $items = $orderRepo->listOrderedProducts();
       

        return view('vendor.orders.show', [
            'order' => $order,
            'items' => $items,
            'customer' => $this->customerRepo->findCustomerById($order->customer_id),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order->order_status_id),
            'payment' => $order->payment,
            'user' => auth()->guard('vendor')->user()
        ]);
    }

    /**
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);
        
        $orderRepo = new OrderRepository($order);
        $order->courier = $orderRepo->getCouriers()->first();
        $order->address = $orderRepo->getAddresses()->first();
        $items = $orderRepo->listOrderedProducts();

        return view('admin.orders.edit', [
            'statuses' => $this->orderStatusRepo->listOrderStatuses(),
            'order' => $order,
            'items' => $items,
            'customer' => $this->customerRepo->findCustomerById($order->customer_id),
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order->order_status_id),
            'payment' => $order->payment,
            'user' => auth()->guard('employee')->user()
        ]);
    }

/**
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order_edit($orderId)
    {
        
        $order=DB::table("orders")->where("id", $orderId)->first();
        $merchant_shop=DB::table('shops')->where('merchant_id',auth('vendor')->user()->id)->where('type','default')->first();
        $order_product = DB::table('products')->join('order_product', 'products.id', '=', 'order_product.product_id')
                        ->select('products.*','order_product.*')
                        ->where('order_product.order_id',$order->id)
                        ->where('order_product.shop_id',$merchant_shop->id)
                        ->get();

                        
        $customer = $this->customerRepo->findCustomerById($order->customer_id);
        $addresses=DB::table("addresses")->where("id", $order->address_id )->first();
        $country_details=DB::table("countries")->where("id", $addresses->country_id )->first();

        return view('vendor.orders.edit', [
           'customer' => $customer,
           'shop_id' => $merchant_shop->id,
            'order' => $order,
            'items' => $order_product,
            'country' => $country_details,
            'address' => $addresses,
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order_product[0]->order_status),
            'statuses' => $this->orderStatusRepo->listOrderStatuses(),
            'user' => auth()->guard('vendor')->user()
        ]);
    }


    public function shop_order_edit($shop_id,$orderId)
    {
        
        $order=DB::table("orders")->where("id", $orderId)->first();
        
        $order_product = DB::table('products')->join('order_product', 'products.id', '=', 'order_product.product_id')
                        ->select('products.*','order_product.*')
                        ->where('order_product.order_id',$order->id)
                        ->where('order_product.shop_id',$shop_id)
                        ->get();

                        
        $customer = $this->customerRepo->findCustomerById($order->customer_id);
        $addresses=DB::table("addresses")->where("id", $order->address_id )->first();
        $country_details=DB::table("countries")->where("id", $addresses->country_id )->first();

        return view('vendor.orders.shop_edit', [
           'customer' => $customer,
           'shop_id' => $shop_id,
            'order' => $order,
            'items' => $order_product,
            'country' => $country_details,
            'address' => $addresses,
            'currentStatus' => $this->orderStatusRepo->findOrderStatusById($order_product[0]->order_status),
            'statuses' => $this->orderStatusRepo->listOrderStatuses(),
            'user' => auth()->guard('vendor')->user()
        ]);
    }


    /**
     * @param Request $request
     * @param $orderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $orderId)
    {
        $order = $this->orderRepo->findOrderById($orderId);
        $orderRepo = new OrderRepository($order);

        if ($request->has('total_paid') && $request->input('total_paid') != null) {
            $orderData = $request->except('_method', '_token');
        } else {
            $orderData = $request->except('_method', '_token', 'total_paid');
        }

        $orderRepo->updateOrder($orderData);

        return redirect()->route('admin.orders.edit', $orderId)->with('message', 'Updated successfully!');
    }


    /**
     * @param Request $request
     * @param $orderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function order_update(Request $request, $orderId)
    {
       
        DB::table("order_product")->where('order_id', $orderId)->where('shop_id', $request->input('total_paid'))->update($request->except('_token', '_method','total_paid')); 


        return redirect()->route('vendor.orders.edit', $orderId)->with('message', 'Status Updated successfully!');
    }

     public function shop_order_update(Request $request, $orderId)
    {
       
        DB::table("order_product")->where('order_id', $orderId)->where('shop_id', $request->input('total_paid'))->update($request->except('_token', '_method','total_paid')); 


        return back()->with('message', 'Status Updated successfully!');
    }


    /**
     * Generate order invoice
     *
     * @param int $id
     * @return mixed
     */
    public function generateInvoice(int $id)
    {
        $order = $this->orderRepo->findOrderById($id);

        $vendor = DB::table('vendors')->where('id', $order->vendor_id)->first();


        $data = [
            'order' => $order,
            'vendor' => $vendor,
            'products' => $order->products,
            'customer' => $order->customer,
            'courier' => $order->courier,
            'address' => $this->transformAddress($order->address),
            'status' => $order->orderStatus,
            'payment' => $order->paymentMethod
        ];
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.orders', $data)->stream();
        return $pdf->stream();
    }


    
    /**
     * @param Collection $list
     * @return array
     */
    private function transFormOrder(Collection $list)
    {
        $courierRepo = new CourierRepository(new Courier());
        $customerRepo = new CustomerRepository(new Customer());
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());

        return $list->transform(function (Order $order) use ($courierRepo, $customerRepo, $orderStatusRepo) {
            $order->courier = $courierRepo->findCourierById($order->courier_id);
            $order->customer = $customerRepo->findCustomerById($order->customer_id);
            $order->status = $orderStatusRepo->findOrderStatusById($order->order_status_id);
            return $order;
        })->all();
    }


      public function transaction()
    {
        $uid=auth('employee')->user()->id;
        
        $orders = DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token','orders.reference','orders.payouts','orders.date')
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->get();
      
        foreach ($orders as $order) {
               
        $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();

        $products_list = DB::table('orders')
            ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference', 'orders.payouts', 'orders.date','order_product.product_sku','order_product.product_id')
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.token', $order->token)
            ->get();
     

                $products =array();
                $i=0;
                foreach ($order_list as $product) {
                    $products[$i]['vendor_id'] = $product->vendor_id;
                    $products[$i]['total_products'] = $product->total_products;
                    $i++;
                }
                 $order->products = $products;

                $products1 =array();
                $ii=0;
                foreach ($products_list as $product1) {
                    $products1[$ii]['sku'] = $product1->product_sku;
                    $products1[$ii]['id'] = $product1->product_id;
                    $products1[$ii]['vendor_id'] = $product1->vendor_id;
                    $products1[$ii]['total_products'] = $product1->total_products;
                    $products1[$ii]['reference'] = $product1->reference;
                    $products1[$ii]['payouts'] = $product1->payouts;
                    $products1[$ii]['date'] = $product1->date;
                    $products1[$ii]['oid'] = $product1->oid;
                    $ii++;
                }
                 $order->products1 = $products1;


            }

        $order_type = DB::table('vendors')->orderby('id', 'desc')->get();

        return view('admin.orders.transaction_report', [
            'orders' => $orders,
            'order_type' => $order_type
        ]);
    }


     public function vendortransaction()
    {
         
        $uid=auth('vendor')->user()->id;
        $orders = DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token','orders.payouts','orders.date')
            ->where('orders.vendor_id', $uid)
            ->groupBy('order_payment.id')
             ->orderBy('order_payment.id','desc')
            ->get();
        
          
            foreach ($orders as $order) {
                $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();
                $products_list = DB::table('orders')
                    ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference','order_product.product_sku','orders.payouts','orders.date','order_product.product_id')
                    ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                    ->where('orders.token', $order->token)
                    ->where('orders.vendor_id', $uid)
                    ->get();

            
                $products =array();
                $i=0;
                foreach ($order_list as $product) {
                    $products[$i]['vendor_id'] = $product->vendor_id;
                    $products[$i]['total_products'] = $product->total_products;
                    $i++;
                }
                 $order->products = $products;

                $products1 =array();
                $ii=0;
                foreach ($products_list as $product1) {
                    $products1[$ii]['sku'] = $product1->product_sku;
                    $products1[$ii]['id'] = $product1->product_id;
                    $products1[$ii]['vendor_id'] = $product1->vendor_id;
                    $products1[$ii]['total_products'] = $product1->total_products;
                    $products1[$ii]['reference'] = $product1->reference;
                    $products1[$ii]['oid'] = $product1->oid;
                    $products1[$ii]['payouts'] = $product1->payouts;
                    $products1[$ii]['date'] = $product1->date;
                    $ii++;
                }
                 $order->products1 = $products1;

            }


        return view('vendor.orders.transaction_report', [
            'orders' => $orders
        ]);
    }

/**
     * Display the specified resource.
     *
     * @param  int $orderId
     * @return \Illuminate\Http\Response
     */

    public function vendortransactionn($orderId)
    {
        $uid=$orderId;
    
        $orders = DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token','orders.payouts','orders.date','orders.release_date')
            ->where('orders.vendor_id', $uid)
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->get();
            //echo Carbon::now()->subDays(14)->toDateTimeString();
    

       $available_payouts =  DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*',DB::raw('SUM(order_payment.amount) as amount'),'orders.token as order_token','orders.payouts')
            ->where('orders.vendor_id', $uid)
            ->where('orders.payouts', '0')
            ->where('orders.release_date','=', NULL)
            ->where('orders.date','<=',Carbon::now()->subDays(14)->toDateTimeString())
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->first();
            if($available_payouts){
                $deductionn= ($available_payouts->amount - 0.30);
            }else{
                $deductionn= 0;
            }


        $flat_deductionn = 0.30;
        $stripe_trns_chargess = 2.9;
        
        $transactionfeess = round(($deductionn * $stripe_trns_chargess)/100, 2);
        $total_feess = $flat_deductionn + $transactionfeess;
        $vendor_amount_after_deductionn= ($deductionn - $transactionfeess);
       
        
       
        $reserve_payouts =  DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token',DB::raw('SUM(order_payment.amount) as amount'),'orders.payouts')
            ->where('orders.vendor_id', $uid)
            ->where('orders.payouts', '0')
           ->where('orders.date','>=',Carbon::now()->subDays(14)->toDateTimeString())
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->first();

           

          
        foreach($orders as $order) {
               
                $order_list = DB::table('orders')->select('vendor_id', 'total_products','date')->where('token', $order->token)->get();
                $products_list = DB::table('orders')
                    ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference','order_product.product_sku','orders.payouts','orders.date','order_product.product_id')
                    ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                    ->where('orders.token', $order->token)
                    ->where('orders.vendor_id', $uid)
                    ->get();

            
                $products =array();
                $i=0;
                foreach ($order_list as $product) {
                    $products[$i]['vendor_id'] = $product->vendor_id;
                    $products[$i]['date'] = $product->date;
                    $products[$i]['total_products'] = $product->total_products;
                    $i++;
                }
                 $order->products = $products;

                $products1 =array();
                $ii=0;
                foreach ($products_list as $product1) {
                    $products1[$ii]['sku'] = $product1->product_sku;
                    $products1[$ii]['id'] = $product1->product_id;
                    $products1[$ii]['vendor_id'] = $product1->vendor_id;
                    $products1[$ii]['total_products'] = $product1->total_products;
                    $products1[$ii]['reference'] = $product1->reference;
                    $products1[$ii]['oid'] = $product1->oid;
                    $products1[$ii]['payouts'] = $product1->payouts;
                    $products1[$ii]['date'] = $product1->date;
                    $ii++;
                }
                 $order->products1 = $products1;

            }

            $order_type = DB::table('vendors')->orderby('id', 'desc')->get();
            return view('admin.orders.transaction_reportt', [
                'orders' => $orders,
                'order_type' => $order_type,
                'available_payouts' => $vendor_amount_after_deductionn,
                'reserve_payouts' => $reserve_payouts
            ]);
    }


    public function releaseAmount(Request $request) {

        $vendor_id=$request->vendor_id;
        $amount=$request->amount;
        $date=date('Y-m-d');
        if($amount!=0 || $amount!=''){
           $vendor_profile_details = DB::table('orders')->where('vendor_id', $vendor_id)->where('payouts','0')->where('date','<=',Carbon::now()->subDays(14)->toDateTimeString())->update(['payouts' => 1, 'release_date' => $date]);
            return redirect()->route('admin.orders.transaction_reportt',$vendor_id)->with('message', 'Amount released successfully');
        }else{
            return redirect()->route('admin.orders.transaction_reportt',$vendor_id)
            ->with('error', 'Amount are not available for release');
        }
     }

    public function transactionHistory()
    {


        $uid=auth('employee')->user()->id;
        
        $orders = DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token','orders.reference','orders.payouts','orders.release_date')
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->where('orders.payouts','1')
            ->get();
      
        foreach ($orders as $order) {
               
        $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();

        $products_list = DB::table('orders')
            ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference', 'orders.payouts','order_product.product_sku','order_product.product_id','orders.release_date')
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.token', $order->token)
            ->get();
     

                $products =array();
                $i=0;
                foreach ($order_list as $product) {
                    $products[$i]['vendor_id'] = $product->vendor_id;
                    $products[$i]['total_products'] = $product->total_products;
                    $i++;
                }
                 $order->products = $products;

                $products1 =array();
                $ii=0;
                foreach ($products_list as $product1) {
                    $products1[$ii]['sku'] = $product1->product_sku;
                    $products1[$ii]['id'] = $product1->product_id;
                    $products1[$ii]['vendor_id'] = $product1->vendor_id;
                    $products1[$ii]['total_products'] = $product1->total_products;
                    $products1[$ii]['reference'] = $product1->reference;
                    $products1[$ii]['payouts'] = $product1->payouts;
                    $products1[$ii]['oid'] = $product1->oid;
                    $products1[$ii]['release_date'] = $product1->release_date;
                    $ii++;
                }
                 $order->products1 = $products1;


            }

        $order_type = DB::table('vendors')->orderby('id', 'desc')->get();

        return view('admin.orders.transaction_history', [
            'orders' => $orders,
            'order_type' => $order_type
        ]);
    }


    public function transactionHistoryy($orderId)
    {

        $uid=$orderId;
    
        $orders = DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token','orders.payouts','orders.release_date')
            ->where('orders.vendor_id', $uid)
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
             ->where('orders.payouts','1')
            ->get();


       $available_payouts =  DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*',DB::raw('SUM(order_payment.amount) as amount'),'orders.token as order_token','orders.payouts')
            ->where('orders.vendor_id', $uid)
            ->where('orders.payouts', '0')
            ->where('orders.date','<=',Carbon::now()->subDays(14)->toDateTimeString())
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->first();
        if(empty($available_payouts)){
            $available_payouts='';
        }
            
       $reserve_payouts =  DB::table('order_payment')
            ->join('orders', 'order_payment.token', '=', 'orders.token')
            ->select('order_payment.*','orders.token as order_token',DB::raw('SUM(order_payment.amount) as amount'),'orders.payouts')
            ->where('orders.vendor_id', $uid)
            ->where('orders.payouts', '0')
           ->where('order_payment.created_at','>=',Carbon::now()->subdays(14))
            ->groupBy('order_payment.id')
            ->orderBy('order_payment.id','desc')
            ->first();

        if(empty($reserve_payouts)){
            $reserve_payouts='';
        }
          
        foreach($orders as $order) {
               
                $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();
                $products_list = DB::table('orders')
                    ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference','order_product.product_sku','orders.payouts','order_product.product_id','orders.release_date')
                    ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                    ->where('orders.token', $order->token)
                    ->where('orders.vendor_id', $uid)
                    ->get();

            
                $products =array();
                $i=0;
                foreach ($order_list as $product) {
                    $products[$i]['vendor_id'] = $product->vendor_id;
                    $products[$i]['total_products'] = $product->total_products;
                    $i++;
                }
                 $order->products = $products;

                $products1 =array();
                $ii=0;
                foreach ($products_list as $product1) {
                    $products1[$ii]['sku'] = $product1->product_sku;
                    $products1[$ii]['id'] = $product1->product_id;
                    $products1[$ii]['vendor_id'] = $product1->vendor_id;
                    $products1[$ii]['total_products'] = $product1->total_products;
                    $products1[$ii]['reference'] = $product1->reference;
                    $products1[$ii]['oid'] = $product1->oid;
                    $products1[$ii]['payouts'] = $product1->payouts;
                    $products1[$ii]['release_date'] = $product1->release_date;
                    $ii++;
                }
                 $order->products1 = $products1;

            }

            $order_type = DB::table('vendors')->orderby('id', 'desc')->get();
            return view('admin.orders.transaction_historyy', [
                'orders' => $orders,
                'order_type' => $order_type,
                'available_payouts' => $available_payouts,
                'reserve_payouts' => $reserve_payouts
            ]);
    }

}


