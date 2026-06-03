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

class VendorsController extends Controller
{
    use ProductTransformable;
        /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;
    private $customerRepo;


    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository,CustomerRepositoryInterface $customerRepository)
    {
        $this->productRepo = $productRepository;
        $this->customerRepo = $customerRepository;
    }


   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
        $vendors= DB::table('vendors')->orderby('name', 'asc')->get();
       return view('front/vendors/allvendors',["vendors"=>$vendors]);
   }

    

}
