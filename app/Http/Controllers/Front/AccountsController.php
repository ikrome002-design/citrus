<?php

namespace App\Http\Controllers\Front;

use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Customers\Requests\UpdateProfileRequest;
use App\Shop\Customers\Requests\UpdateProfilePassword;
use App\Http\Controllers\Controller;
use App\Shop\Orders\Order;
use App\Gallery;
use App\Shop\Customers\Customer;
use App\Shop\Countries\Country;
use App\Vendor;
use Illuminate\Http\Request;
use DB;
use App\Shop\Orders\Transformers\OrderTransformable;

class AccountsController extends Controller
{
    use OrderTransformable;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepo;

    /**
     * AccountsController constructor.
     *
     * @param CourierRepositoryInterface $courierRepository
     * @param CustomerRepositoryInterface $customerRepository
     */

    public function __construct(
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository
    ) {
        
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
        $this->countryRepo = $countryRepository;
    }

    public function index()
    {
        //$customer = $this->customerRepo->findCustomerById(auth()->user()->id);
         $customer = Customer::join('countries', 'customers.country', '=', 'countries.id')
        ->select('countries.id AS cid','countries.name AS cname','customers.*')
        ->where('customers.id', auth()->user()->id)
        ->first();

        $countriess=Country::where('id','!=',$customer->cid)->orderby('id','asc')->get();
        $customerRepo = new CustomerRepository($customer);
        $orders = $customerRepo->findOrders(['*'], 'created_at');
        $orders->transform(function (Order $order) {
            return $this->transformOrder($order);
        });
        $orders->load('products');
        $addresses = $customerRepo->findAddresses();
        $shops = DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->orderby('shops.id', 'desc')
        ->get();
       
        return view('front.accounts', [
            'customer' => $customer,
            'orders' => $this->customerRepo->paginateArrayResults($orders->toArray(),20),
            'addresses' => $addresses,
            'countriess' => $countriess,
            'countries' => $this->countryRepo->listCountries(),
            'shops' => $shops
        ]);
    }

     public function shop_list()
    {
       $shops = DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->orderby('shops.id', 'desc')
        ->get();

        $merchants = DB::table('business_type')->orderby('id', 'desc')->get();

        return view('front.shop_list', [
            'shops' => $shops,
            'merchants' => $merchants
        ]);
    }

     public function action(Request $request)
    {
   
     if($request->ajax())
     {
          
      $output = '';
      $query = $request->get('query');
      $type=$request->get('type');
      $img_url=$request->get('img_url');
     
      
      if($query != '')
      { 
        if($type=='search'){
        $data=DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->where('business_type.title', 'like', '%'.$query.'%')
        ->orderby('shops.id', 'desc')
        ->get();
        
       }

       if($type=='merchant'){
        $data=DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->where('business_type.id', $query)
        ->orderby('shops.id', 'desc')
        ->get();
        
       }

       if($type=='range'){
        $data=DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->orderby('shops.id', $query)
        ->get();
        
       }

       

       
    }  

      else
      { 
       $data= DB::table('shops')->join('vendors', 'vendors.id', '=', 'shops.merchant_id')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('vendors.id AS vid','vendors.first_name AS fname','vendors.last_name AS lname','vendors.citrus_shop_id AS cid','vendors.shop_image AS merchant_shop','business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->orderby('shops.id', 'desc')
        ->get();   
        
      }
      $total_row = $data->count();
      if($total_row > 0)
      { $i=1;
       foreach($data as $row)
       {
        if($row->shop_image!=''){
       
       $output .= '
<div class="ci-productWrap">
  <div class="product-img">
    <img src="storage/shop/'.$row->shop_image.'">
  </div>
  <div class="product-content">
    <div class="left">
      <a class="ci-productTitle" href="merchant/shop/'.$row->id.'/products"><h5>'.strtoupper($row->business_title).'</h5></a>
      <a href="merchant/detail/'.$row->vid.'"><p class="mb-1 text-primary font-14 font-500">'.$row->fname.' '.$row->lname.'</p></a>
      <p class="text-primary font-14 font-500">'.$row->citrus_shop_id.'</p>
    </div>
    <div class="right">
      
    </div>
  </div>
</div>';

         }else{

            $output .= '
            <div class="ci-productWrap">
  <div class="product-img">
    <img src="images/placeholder-square.png" height="130" width="190">
  </div>
  <div class="product-content">
    <div class="left">
      <a class="ci-productTitle" href="merchant/shop/'.$row->id.'/products"><h5>'.strtoupper($row->business_title).'</h5></a>
      <a href="merchant/detail/'.$row->vid.'"><p class="mb-1 text-primary font-14 font-500">'.$row->fname.' '.$row->lname.'</p></a>
      <p class="text-primary font-14 font-500">'.$row->citrus_shop_id.'</p>
    </div>
    <div class="right">
      
    </div>
  </div>
</div>';
         }
       $i++;
       }
       
      }
      else
      {
       $output = '
       <div class="col-md-12">
       <h3 style="color:red;">No Shop found.</h3>
       </div>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );
      echo json_encode($data);
     }
    }

    public function product_list(int $id){

     $products=DB::table('products')->where('shop_id',$id)->orderby('id', 'desc')->get();
     //echo "<pre>"; print_r($products); die();
      return view('front.product_list', [
            'products' => $products
            
        ]);
    }


      public function product_action(Request $request)
    {
    
     if($request->ajax())
     {
          
      $output = '';
      $query = $request->get('query');
      $type=$request->get('type');
      $shop_id=$request->get('shop_id');
      
      
      if($query != '')
      { 
        if($type=='search'){
        $data=DB::table('products')->where('shop_id',$shop_id)->where('name', 'like', '%'.$query.'%')->where('quantity','>',0)->orderby('id', 'desc')->get();
        
       }

       if($type=='merchant'){
        $data=DB::table('products')->where('shop_id',$shop_id)->where('quantity','>',0)->orderby('name', $query)->get();
        
       }

       if($type=='range'){
        $data=DB::table('products')->where('shop_id',$shop_id)->where('quantity','>',0)->orderby('sale_price', $query)->get();
        
       }
       
    }  
  else
      { 
       $data= DB::table('products')->where('shop_id',$shop_id)->where('quantity','>',0)->orderby('id', 'desc')->get();
        //echo "<pre>"; print_r($data); die();
      }
      $total_row = $data->count();
      if($total_row > 0)
      { $i=1;
       foreach($data as $row)
       {
        //$wish= DB::table('wishlist')->where('user_id',auth()->user()->id)->where('product_id',$row->id)->count();
        
        if($row->cover!=''){
       
       $output .= '
      
            <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="product-grid product_list_wrap pb-2">
                <div class="product-image">
                <a href="product-detail/'.$row->id.'">
                 	<img class="pic-1 product-img" src="'.env('APP_URL').'storage/'.$row->cover.'">
                	<img class="pic-2 product-img" src="'.env('APP_URL').'storage/'.$row->cover.'" >
             </a>
            <ul class="social">
                <li><a href="product-detail/'.$row->id.'" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                <li><button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn myBtnCls" product-id="'.$row->id.'" id="product-wishlist-btn-'. $row->id.'"><i class="fa fa-heart"></i></button></li>
                <input type="hidden" name="uId" id="uId" value="'.auth()->user()->id.'">
                <li>
                    <form action="'.route('cart.store').'" method="post">
                    '.csrf_field().'
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="product" value="'. $row->id.'">
                    <button type="submit" class="mr-2 btn btn-info" ><i class="fa fa-shopping-cart"></i>  </button>
                  </form>
                </li>
            </ul>  
        </div> 
        <div class="product-content">
            <a href="product-detail/'.$row->id.'"><h5 class="product_title">'.strtoupper($row->name).'</h5></a>
            <div class="product-content-inner">
                <div class="price mb-0">$'.$row->sale_price.'
                    <span>$ '.$row->price.'</span>
                </div>
                <div class="product_CartBox">
                    <form action="'.route('cart.store').'" method="post">
                    '.csrf_field().'
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="product" value="'. $row->id.'">
                    <button type="submit" class=""><i class="fa fa-cart-plus"></i>  </button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>';

         }else{

            $output .=' 
            <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="product-grid product_list_wrap pb-0">
                <div class="product-image">
                    <a href="product-detail/'.$row->id.'">
                 <img class="pic-1 product-img" src="images/placeholder-square.png" style="height:200px;">
                <img class="pic-2 product-img" src="images/placeholder-square.png" >

             </a>
                    <ul class="social">
                        <li><a href="product-detail/'.$row->id.'" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                        <li><button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn myBtnCls" product-id="'.$row->id.'"><i class="fa fa-heart-o"></i></button></li>
                        <input type="hidden" name="uId" id="uId" value="'.auth()->user()->id.'">
                        <li><form action="'.route('cart.store').'" method="post">
                            '.csrf_field().'
                            <input type="hidden" name="quantity" value="1" />
                            <input type="hidden" name="product" value="'. $row->id.'">
                            <button type="submit" class="mr-2 btn btn-info" ><i class="fa fa-shopping-cart"></i>  </button>
                          </form>
                      </li>
                    </ul>
                </div>
                
                <div class="product-content">
                    <a href="product-detail/'.$row->id.'"><h5 class="product_title">'.strtoupper($row->name).'</h5></a>
                    <div class="product-content-inner">
                          <div class="price mb-0">$'.$row->sale_price.'
                            <span>$ '.$row->price.'</span>
                        </div>
                    <div class="product_CartBox">
                          <form action="'.route('cart.store').'" method="post">
                                    '.csrf_field().'
                            <input type="hidden" name="quantity" value="1" />
                            <input type="hidden" name="product" value="'. $row->id.'">
                            <button type="submit" class=""><i class="fa fa-cart-plus"></i>  </button>
                      </form>   
                    </div>
                 </div>  
              </div> 
            </div>
          </div>
        </div>';
         }
       $i++;
       }
       
      }
      else
      {
       $output = '
       <div class="col-md-12">
       <h3 style="color:red;">No Product found.</h3>
       </div>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );
      echo json_encode($data);
     }
    }

    public function destroyAddress($id)
    {
        DB::table("addresses")->where("id", $id)->delete();
        return redirect()->route('accounts', ['tab' => 'v-pills-my-addresses'])->with('message', 'Delete successful');
    }


    public function track_order(int $id)
    {

        

        $order=DB::table("orders")->where("id", $id)->first();

        //$order_product=DB::table("order_product")->where("order_id", $order->id)->get();
        $order_product = DB::table('products')->join('order_product', 'products.id', '=', 'order_product.product_id')
                        ->select('products.*','order_product.*')
                        ->where('order_product.order_id',$order->id)
                        ->get();
                         
      
        $customer = $this->customerRepo->findCustomerById($order->customer_id);
        $addresses=DB::table("addresses")->where("id", $order->address_id )->first();
        $country_details=DB::table("countries")->where("id", $addresses->country_id )->first();

        return view('front.track-order-details', [
            'customer' => $customer,
            'order' => $order,
            'order_product' => $order_product,
            'country' => $country_details,
            'address' => $addresses
        ]);
        //return view('front.track-order-details');
    }

    public function updateProfile(UpdateProfileRequest $request){
       

        if ($request->has('avatar') && $request->file('avatar') != ''){
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            $destinationPath = 'public/storage/profile/customer/';
            $file->move($destinationPath,$file->getClientOriginalName());

        }
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);
      
        if($request->has('password') && $request->input('password') != '' && !password_verify($request->input('old-password'), $customer->password)){
           
            return redirect()->to('accounts?tab=v-pills-account-details')->with('error', 'Invalid old password');
        }

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password') ){
            
            return redirect()->to('accounts?tab=v-pills-account-details')->with('error', 'Password and confirmed password do not match');
        }


        $update = new CustomerRepository($customer);
        $update->updateCustomer($request->except('_token', '_method', 'password'));

        if ($request->has('password') && $request->input('password') != '') {
            $update->updateCustomer($request->only('password'));
        }

         return redirect()->to('accounts?tab=v-pills-account-details')->with('message', 'Update successful');
    }

    public function updatePassword(UpdateProfilePassword $request){

        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        if ($request->has('password') && $request->input('password') != '' && !password_verify($request->input('old-password'), $customer->password)){
            return redirect()->route('accounts')
            ->with('error', 'Invalid Old Password');
        }

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password') ){
            
            return redirect()->route('accounts')
            ->with('error', 'Password and confirmed password do not match');
        }
        
        $update = new CustomerRepository($customer);

        if ($request->has('password') && $request->input('password') != '') {
            $update->updateCustomer($request->only('password'));
        }
        return redirect()->route('accounts')->with('message', 'Password changed successful');
    }

     public function merchant_view(int $id)
    {  
        $vendor_details=Vendor::join('countries', 'vendors.country', '=', 'countries.id')->select('countries.id AS cid','countries.name AS cname','vendors.*')->where('vendors.id', $id)->first();
        
        $galleries=Gallery::where('merchant_id', $id)->get();

        return view('front.merchant_view', ['vendor_details' => $vendor_details, 'galleries' => $galleries]);
    }

    public function customerInvoice(int $id)
    {
        $order = Order::where('id', $id)->first();
        $vendors=DB::table('order_product')->where('order_id', $order->id)->groupBy('vendor_id')->get();
      
        $address=DB::table('addresses')->where('customer_id', $order->customer_id)->first();
        $country=DB::table('countries')->where('id', $address->country_id)->first();
 

        $data = [
            'order' => $order,
            'vendors' => $vendors,
            'products' => $order->products,
            'customer' => $order->customer,
            'courier' => $order->courier,
            'country'=> $country->name,
            'address' => $address,
            'status' => $order->orderStatus,
            'payment' => $order->paymentMethod
        ];
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('invoices.orders', $data)->stream();
        return $pdf->stream();
    }


    

}
  