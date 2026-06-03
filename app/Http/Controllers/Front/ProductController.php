<?php

namespace App\Http\Controllers\Front;

use App\Shop\Products\Product;
use App\productRating;
use App\Vendor;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Support\Facades\DB;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;


class ProductController extends Controller
{
    use ProductTransformable;

        /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;
    private $customerRepo;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;


    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository,CustomerRepositoryInterface $customerRepository,CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepo = $productRepository;
        $this->customerRepo = $customerRepository;
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {   
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;

        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }

        if ( (request()->has('q') && request()->input('q') != '' ) || ( request()->has('categories') && request()->input('categories') != '' ) ) {
            $search_text = request()->has('q') ? request()->input('q') : '';
            $category = request()->has('categories') ? request()->input('categories') : '';

            $products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->where(function($q) use ($category) {
                    if($category){
                     $q->where('category_product.category_id',   $category  );
                     $this->findChildCat($category,$q);
                    }
                 })
                ->where(function($q) use ($search_text) {
                     $q->where('products.name',   'like', "%$search_text%");
                        //->orWhere('products.description',   'like', "%$search_text%");
                 })
                ->offset($product_from)
                ->limit($product_perpage)
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->orderBy($order_by, $order_type)
                ->groupBy('products.id')
                ->get();
                
               
                $all_products = DB::table('products')
                    ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                    ->where('products.status', 1)
                    ->where(function($q) use ($vendors) {
                        if($vendors){
                            $q->whereIn('products.vendor_id', $vendors);
                        }
                     })
                    ->where(function($q) use ($category) {
                        if($category){
                         $q->where('category_product.category_id',   $category  );
                         $this->findChildCat($category,$q);
                        }
                     })
                    ->where(function($q) use ($search_text) {
                         $q->where('products.name',   'like', '%$search_text%' );
                            //->orWhere('products.description',   'like', '%'.$search_text.'%' );
                     })
                    ->whereBetween('sale_price', [$price_from, $price_to])
                    ->groupBy('products.id')
                    ->orderBy('products.id', 'DESC')
                    ->get();


        } else {
            $products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->offset($product_from)
                ->limit($product_perpage)
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->orderBy($order_by, $order_type)
                ->groupBy('products.id')
                ->get();

            $all_products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->groupBy('products.id')
                ->orderBy('products.id', 'DESC')
                ->get();
        }

         $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

        return view('front.products.product-search',[
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchFilter()
    {   
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;

        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }

        if ( (request()->has('q') && request()->input('q') != '' ) || ( request()->has('categories') && request()->input('categories') != '' ) ) {
            $search_text = request()->has('q') ? request()->input('q') : '';
            $category = request()->has('categories') ? request()->input('categories') : '';

            $products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->where(function($q) use ($category) {
                    if($category){
                     $q->where('category_product.category_id',   $category  );
                     $this->findChildCat($category,$q);
                    }
                 })
                ->where(function($q) use ($search_text) {
                     $q->where('products.name',   'like', '%$search_text%' );
                        //->orWhere('products.description',   'like', '%'.$search_text.'%' );
                 })
                ->offset($product_from)
                ->limit($product_perpage)
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->orderBy($order_by, $order_type)
                ->groupBy('products.id')
                ->get();

                $all_products = DB::table('products')
                    ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                    ->where('products.status', 1)
                    ->where(function($q) use ($vendors) {
                        if($vendors){
                            $q->whereIn('products.vendor_id', $vendors);
                        }
                     })
                    ->where(function($q) use ($category) {
                        if($category){
                         $q->where('category_product.category_id',   $category  );
                         $this->findChildCat($category,$q);
                        }
                     })
                    ->where(function($q) use ($search_text) {
                         $q->where('products.name',   'like', '%$search_text%' );
                           // ->orWhere('products.description',   'like', '%'.$search_text.'%' );
                     })
                    ->whereBetween('price', [$price_from, $price_to])
                    ->groupBy('products.id')
                    ->orderBy('products.id', 'DESC')
                    ->get();


        } else {
           
            $products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->offset($product_from)
                ->limit($product_perpage)
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->orderBy($order_by, $order_type)
                ->groupBy('products.id')
                ->get();

            $all_products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->whereBetween('price', [$price_from, $price_to])
                ->groupBy('products.id')
                ->orderBy('products.id', 'DESC')
                ->get();
        }

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

        return view('front.products.product-list',[
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
        ]);
    }

    public function findChildCat($category, $q){
        $child_cats = DB::table('categories')->select('id')->where('parent_id',   $category  )->get();
        if($child_cats){
            foreach ($child_cats as $child_cat) {
                $category = $child_cat->id; 
                $q->orWhere('category_product.category_id',   $category  );
                $this->findChildCat($category, $q);
            }
        }
        return $q;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shop()
    {

   
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;

        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }



        $categories         =  $this->categoryRepo->listCategories('created_at', 'desc');

         if($sort_by=='most_popular'){


          $products = DB::table('products')
                    ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                        ->where('products.status', 1)
                        ->where(function($q) use ($vendors) {
                            if($vendors){
                                $q->whereIn('products.vendor_id', $vendors);
                            }
                         })
                    ->offset($product_from)
                    ->limit($product_perpage)
                    ->orderBy('total','desc')
                    ->groupBy('products.id')
                    ->get();
                
            $all_products = DB::table('products')
                        ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                        ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                        ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                        ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                            ->where('products.status', 1)
                        ->where(function($q) use ($vendors) {
                                if($vendors){
                                    $q->whereIn('products.vendor_id', $vendors);
                                }
                             })
                        ->orderBy('total','desc')
                        ->groupBy('products.id')
                        ->get();
            $product_to = count($all_products) < $product_to ? count($all_products) : $product_to;

           
    }else{
        
        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->offset($product_from)
            ->limit($product_perpage)
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->orderBy($order_by, $order_type)
            ->groupBy('products.id')
            ->get();
            


        $all_products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;
        

        /*$categories         =  $this->categoryRepo->listCategories('created_at', 'desc');
        //print_r($categories);
        $i=0;
        foreach ($categories  as $value) {
           $category['id']=$value->id;
           $category['slug']=$value->slug;
           $category['name']=$value->name;
           $i++;
        }*/
       
       // $category           = $categories->id;
    }

        return view('front.products.product-shop', [
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopFilter()
    { 
 
        
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;
        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }elseif($sort_by == 'most_popular'){
            
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }


        if($sort_by=='most_popular'){


          $products = DB::table('products')
                    ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                        ->where('products.status', 1)
                        ->where(function($q) use ($vendors) {
                            if($vendors){
                                $q->whereIn('products.vendor_id', $vendors);
                            }
                         })
                    ->offset($product_from)
                    ->limit($product_perpage)
                    ->orderBy('total','desc')
                    ->groupBy('products.id')
                    ->get();
                
            $all_products = DB::table('products')
                        ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                        ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                        ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                        ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                            ->where('products.status', 1)
                        ->where(function($q) use ($vendors) {
                                if($vendors){
                                    $q->whereIn('products.vendor_id', $vendors);
                                }
                             })
                        ->orderBy('total','desc')
                        ->groupBy('products.id')
                        ->get();
            $product_to = count($all_products) < $product_to ? count($all_products) : $product_to;

           
    }else{
        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->offset($product_from)
            ->limit($product_perpage)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->orderBy($order_by, $order_type)
            ->groupBy('products.id')
            ->get();
        

        $all_products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

       
    }
        return view('front.products.product-list', [
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
        ]);
    }


    public function priceFilter()
    {
       

   
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;

        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }

        $categories         =  $this->categoryRepo->listCategories('created_at', 'desc');


        
        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->offset($product_from)
            ->limit($product_perpage)
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->orderBy($order_by, $order_type)
            ->groupBy('products.id')
            ->get();


        $all_products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;
        

        return view('front.products.product-shop', [
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
        ]);
    }

     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brand(string $slug)
    {
        $brand_id           = DB::table('brands')->select('id')->where('slug', $slug)->first();
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;
        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }

        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where('products.brand_id', $brand_id->id)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->offset($product_from)
            ->limit($product_perpage)
            ->whereBetween('price', [$price_from, $price_to])
            ->orderBy($order_by, $order_type)
            ->groupBy('products.id')
            ->get();

        $all_products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.brand_id', $brand_id->id)
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->whereBetween('price', [$price_from, $price_to])
            ->get();



        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

        return view('front.products.product-brand', [
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
            'slug'                  => $slug,
        ]);
    }

     /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function brandFilter(string $slug)
    {
        
        $brand_id           = DB::table('brands')->select('id')->where('slug', $slug)->first();
        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;
        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;
        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        $vendors            = isset($_GET['vendors']) && $_GET['vendors']!= ''? $_GET['vendors'] : '' ;
        if($sort_by == 'default'){
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }elseif($sort_by == 'recency_desc'){
            $order_by   =   'products.created_at';
            $order_type =   'DESC';
        }elseif($sort_by == 'price_asc'){
            $order_by   =   'products.sale_price';
            $order_type =   'ASC';
        }elseif($sort_by == 'price_desc'){
            $order_by   =   'products.sale_price';
            $order_type =   'DESC';
        }else{
            $order_by   =   'products.id';
            $order_type =   'RAND';
        }

        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where('products.brand_id', $brand_id->id)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->offset($product_from)
            ->limit($product_perpage)
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->orderBy($order_by, $order_type)
            ->groupBy('products.id')
            ->get();

        $all_products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->select('products.*','products.name as productname', 'products.id as product_id', 'vendors.*', 'vendors.name as vendorname')
            ->where('products.brand_id', $brand_id->id)
            ->where('products.status', 1)
            ->where(function($q) use ($vendors) {
                if($vendors){
                    $q->whereIn('products.vendor_id', $vendors);
                }
             })
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

        return view('front.products.product-list', [
            'all_products'          => $all_products,
            'products'              => $products,
            'product_from'          => $product_from,
            'product_to'            => $product_to,
            'product_perpage'       => $product_perpage,
            'paged'                 => $paged,
            'slug'                  => $slug,
        ]);
    }


    
    /**
     * Get the product
     *
     * @param id $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $shop_id,$id)
    {
        $product = DB::table('products')->where([  ['id', $id] ])->first();
        
        
        $rating=productRating::where('product_id',$product->id)->first();

        if(!empty($rating)){
            $rating['user_id']= $this->customerRepo->findCustomerById($rating->user_id);
        }
        $images = DB::table('product_images')->where([  ['product_id', $id] ])->get();
        $category = '';
        $productAttributes = '';

        $vendor_id = $product->vendor_id;
        $vendor=DB::table('vendors')->where([  ['id', $vendor_id] ])->first();
        $company_detail=DB::table('vendors')->where([  ['id', $vendor_id] ])->first();

        
        $rate=DB::table('products')
                    ->Join('product_ratings', 'product_ratings.product_id', '=', 'products.id')
                    ->Join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->where('products.id',$product->id)
                    ->where('product_ratings.status',1)
                    ->select(['product_ratings.*','customers.*'])
                    ->get();

        $ratecount=count($rate);

        $ratingAvg = productRating::where('product_id',$product->id)->where('status',1)->avg('rating');
        
    
        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category',
            'vendor',
            'company_detail',
            'rate',
            'ratecount',
            'ratingAvg',
            'rating'
            
        ));
    }

// vendor product details here
    public function show_vendor_product(int $id)
    {

        $details=Vendor::where('id',$id)->first();
        $vendor_product = DB::table('products')->where('status', 1)->where('vendor_id', $id)->get();

        $vendor_sales= DB::table('products')->join('order_product', 'order_product.product_id', '=', 'products.id')
            ->selectRaw("COUNT('order_product.*') as sales")
            ->first();

        $avg_rating = DB::table('products')->leftJoin('product_ratings', 'product_ratings.vendor_id', '=', 'products.vendor_id')
                    ->select(['products.*',DB::raw('AVG(product_ratings.rating) as ratings_average'),DB::raw('COUNT(product_ratings.rating) as count_ratings')])
                    ->first();

        $user_details = DB::table('product_ratings')
                    ->Join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->select('product_ratings.*', 'product_ratings.id as pid', 'customers.*')
                    ->where('product_ratings.vendor_id',$id)
                    ->where('product_ratings.product_id', NULL)
                    ->where('product_ratings.status',1)
                    ->get();

                    //echo "<pre>"; print_r($user_details); die();
        $users = DB::table('product_ratings')->simplePaginate(5);
        return view('front.vendor-details',['vendor'=>$details, 'vendor_product'=>$vendor_product, 'vendor_sales'=>$vendor_sales, 'avg_rating'=>$avg_rating,'user_details'=>$user_details, 'users'=>$users ]);
    }


    public function searchFrontRating()
    {
        $vendor_id=$_GET['vendor_id'];
        if($_GET['status']=='most_recent'){
            
           
           
            $user_details = DB::table('products')
                    ->Join('product_ratings', 'product_ratings.product_id', '=', 'products.id')
                    ->Join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->where('products.vendor_id',$vendor_id)
                    ->select(['product_ratings.*','customers.*'])
                    ->orderBy('product_ratings.created_at', 'DESC')
                    ->get();


                    $html = '';
                    foreach($user_details as $row):
                    $html .= '<li class="media mb-5">';
                            if(isset($row->avatar)):
                    $html .= '<img class="mr-3" src="'.asset("storage/$row->avatar").'">';
                            else:
                    $html .='<img class="mr-3" src="'.asset("images/dummy-user.png").'" width="100" height="100">';
                                endif;
                    $html .='<div class="media-body">
                            <h3 class=""><u>'.$row->name.'</u> '.date('j M, Y', strtotime($row->created_at)).'</h3>';
                            for ($i = 1; $i <= $row->rating; $i++):
                    $html .='<i class="fa fa-star text-golden font-18"></i>';
                            endfor;
                            for ($i = 1; $i <=5-$row->rating; $i++):
                    $html .='<i class="fa fa-star font-18"></i>';
                            endfor;     
                    $html .='<div class="profile-mini-box">
                            <figure>';
                            if(isset($row->image)):
                    $html .='<img class="product-img" src="'.asset("storage/$row->image").'">';
                                   else:
                    $html .='<img class="product-img" src="'.asset("images/product-placeholder.jpg").'" width="100" height="100">';
                                    endif;
                    $html .='</figure>
                                  <p class="product-discription">'.$row->review.'</p>
                              </div>
                            </div>
                        </li>';
                        endforeach;
                    return $html;
            

        }
        if($_GET['status']=='top_rated'){
           
            $user_details = DB::table('products')
                    ->Join('product_ratings', 'product_ratings.product_id', '=', 'products.id')
                    ->Join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->where('products.vendor_id',$vendor_id)
                    ->select(['product_ratings.*','customers.*'])
                    ->orderBy('product_ratings.rating', 'DESC')
                    ->get();
                   
            $html = '';
            foreach($user_details as $row):
            $html .= '<li class="media mb-5">';
                    if(isset($row->avatar)):
            $html .= '<img class="mr-3" src="'.asset("storage/$row->avatar").'">';
                    else:
            $html .='<img class="mr-3" src="'.asset("images/dummy-user.png").'" width="100" height="100">';
                        endif;
            $html .='<div class="media-body">
                    <h3 class=""><u>'.$row->name.'</u> '.date('j M, Y', strtotime($row->created_at)).'</h3>';
                    for ($i = 1; $i <= $row->rating; $i++):
            $html .='<i class="fa fa-star text-golden font-18"></i>';
                    endfor;
                    for ($i = 1; $i <=5-$row->rating; $i++):
            $html .='<i class="fa fa-star font-18"></i>';
                    endfor;     
            $html .='<div class="profile-mini-box">
                    <figure>';
                    if(isset($row->image)):
            $html .='<img class="product-img" src="'.asset("storage/$row->image").'">';
                           else:
            $html .='<img class="product-img" src="'.asset("images/product-placeholder.jpg").'" width="100" height="100">';
                            endif;
            $html .='</figure>
                          <p class="product-discription">'.$row->review.'</p>
                      </div>
                    </div>
                </li>';
                endforeach;
            return $html;

            

        }
        
       
    }


}
