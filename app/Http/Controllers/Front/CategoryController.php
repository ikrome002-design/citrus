<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Find the category via the slug
     *
     * @param string $slug
     * @return \App\Shop\Categories\Category
     */
    public function getCategory(string $slug)
    {


        if($slug=='services'){
            $product_type='services';
        }else{
             $product_type='virtual';
        }
        
        if(empty($slug)){
             $categories         =  $this->categoryRepo->listCategories('created_at', 'desc');
        }else{
             // $category = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);
        $categories         = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);
        }
       

        $category           = $categories->id;

        $paged              = isset($_GET['product_from'])? $_GET['product_from'] : 1 ;

        $max_price          = DB::table('products')->max('price');
        $product_perpage    = isset($_GET['product_perpage'])?$_GET['product_perpage']:'10';
        $product_to         = isset($_GET['product_from'])?$_GET['product_from']*$product_perpage:$product_perpage;
        $product_from       = $product_to - $product_perpage;

        $sort_by            = isset($_GET['sort'])? $_GET['sort'] : 'default' ;
        $price_from         = isset($_GET['price_from'])? $_GET['price_from'] : '0' ;
        $price_to           = isset($_GET['price_to']) && $_GET['price_to']!= ''? $_GET['price_to'] : $max_price ;
        // $vendors            = isset($_GET['vendors']) ? $_GET['vendors'] : '' ;
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

        if($sort_by=='most_popular'){
            $products = DB::table('products')
                    ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                        ->where('products.status', 1)
                        ->where('products.product_type', $product_type)
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
                        ->where('products.product_type', $product_type)
                        ->where(function($q) use ($vendors) {
                                if($vendors){
                                    $q->whereIn('products.vendor_id', $vendors);
                                }
                             })
                        ->orderBy('total','desc')
                        ->groupBy('products.id')
                        ->get();
            $product_to = count($all_products) < $product_to ? count($all_products) : $product_to;

           
    }
       


        if($slug!='services'){

            $products = DB::table('products')
                ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where('products.product_type', $product_type)
                ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
                ->where(function($q) use ($category) {
                        if($category){
                         $q->where('category_product.category_id', $category);
                         $this->findChildCat($category,$q);
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
                ->join('category_product', 'products.id', '=', 'category_product.product_id')
                ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
                ->where('products.status', 1)
                ->where('products.product_type', $product_type)
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
               
               ->orderBy('products.id', 'DESC')
                ->whereBetween('sale_price', [$price_from, $price_to])
                ->groupBy('products.id')
                ->get();

            $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;
           
        }else{
            $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where('products.product_type', $product_type)
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
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where('products.product_type', $product_type)
            ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->groupBy('products.id')
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;
    }
        return view('front.categories.category', [
            'category'              => $categories,
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
     * Find the category via the slug
     *
     * @param string $slug
     * @return \App\Shop\Categories\Category
     */
    public function getCategoryFilter(string $slug)
    {



        if($slug=='services'){
            $product_type='services';
        }else{
             $product_type='virtual';
        }
        //echo "2";
        // $category = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);
        $categories         = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);
        $category           = $categories->id;
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
    
        if($sort_by=='most_popular'){


          $products = DB::table('products')
                    ->Join('vendors', 'products.vendor_id', '=', 'vendors.id')
                    ->Join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->Join('category_product', 'products.id', '=', 'category_product.product_id')
                    ->select('products.*','vendors.*','products.id as pid','vendors.id as vid','order_product.id as oid','category_product.id as cid','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname',DB::raw('Count(order_product.product_id) as total') )
                        ->where('products.status', 1)
                         ->where('products.product_type', $product_type)
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
                        ->where('products.product_type', $product_type)
                        ->where(function($q) use ($vendors) {
                                if($vendors){
                                    $q->whereIn('products.vendor_id', $vendors);
                                }
                             })
                        ->orderBy('total','desc')
                        ->groupBy('products.id')
                        ->get();
            $product_to = count($all_products) < $product_to ? count($all_products) : $product_to;

           
    }
       


    if($slug!='services'){

        $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
            ->where('products.status', 1)
             ->where('products.product_type', $product_type)
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
            ->where('products.product_type', $product_type)
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
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->groupBy('products.id')
            ->get();

        $product_to = count($all_products) < $product_to ? count($all_products) : $product_to ;

    }else{
          $products = DB::table('products')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
            ->where('products.status', 1)
             ->where('products.product_type', $product_type)
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
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->select('products.*','vendors.*','products.name as productname', 'products.id as product_id', 'vendors.name as vendorname')
            ->where('products.status', 1)
            ->where('products.product_type', $product_type)
            ->where(function($q) use ($vendors) {
                    if($vendors){
                        $q->whereIn('products.vendor_id', $vendors);
                    }
                 })
            ->orderBy('products.id', 'DESC')
            ->whereBetween('sale_price', [$price_from, $price_to])
            ->groupBy('products.id')
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
    
}
