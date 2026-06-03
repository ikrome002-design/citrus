<?php

namespace App\Http\Controllers\Admin\ProductRatings;

use App\Shop\ProductRatings\ProductRating;
use App\Shop\ProductRatings\Repositories\ProductRatingRepository;
use App\Shop\ProductRatings\Repositories\Interfaces\ProductRatingRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ProductRatingController extends Controller
{
    private $productratingRepo;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    public function __construct(
        ProductRatingRepositoryInterface $productratingRepository,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->productratingRepo = $productratingRepository;
         $this->customerRepo = $customerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $list = $this->productratingRepo->listProductRatings('created_at', 'desc');
        $list =  DB::table('product_ratings')
           ->join('customers', 'product_ratings.user_id', '=', 'customers.id')
           ->join('products', 'product_ratings.product_id', '=', 'products.id')
           ->select('product_ratings.*', 'customers.id as cid', 'customers.name as cname', 'products.id as pid', 'products.name as pname', 'product_ratings.id as rating_id')
           ->orderBy('product_ratings.id', 'desc')
           ->get();
          
        if(!$list->isEmpty()){
           
            return view('admin.productratings.list', [
                'productratings' => $this->productratingRepo->paginateArrayResults($list->all(), 10)
                // 'user_name'=>$user_name_get,
                // 'product_name_get'=>$product_name_get
            ]);

        }else{
          
            return view('admin.productratings.list',['productratings' =>$this->productratingRepo->paginateArrayResults($list->all(), 10)]);
        }
        
        


    }

    public function productRatingApprove($id) 
    {
        
        $productRating = $this->productratingRepo->findProductRatingById($id);
        if($productRating)
        {
            $productRating->status = 1;
            $productRating->save();
            return redirect()->back()->with('message', 'Approved successfully');
            
        }
    }

    public function productRatingUnapprove($id) 
    {
       $productRating = $this->productratingRepo->findProductRatingById($id);

        if($productRating)
        {
            $productRating->status = 0;
            $productRating->save();
            return redirect()->back()->with('error', 'Unapproved successfully');
        }
    }

    public function update(Request $request) 
    {

        $data=$request->all();
        $id=implode(",",$data['selector']);
        foreach($data['selector'] as $id){
            $productRating = $this->productratingRepo->findProductRatingById($id);
            if($productRating)
            {
                $productRating->status = 1;
                $productRating->save();
               
            }
        }
         return redirect()->back()->with('message', 'Approved successfully');
          
    }

    public function productRatingMultipleUnpprove(Request $request) 
    {

        $data=$request->all();
        $id=implode(",",$data['selector_unapprove']);
        foreach($data['selector_unapprove'] as $id){
            $productRating = $this->productratingRepo->findProductRatingById($id);
            if($productRating)
            {
                $productRating->status = 0;
                $productRating->save();
               
            }
        }
        return redirect()->back()->with('error', 'Unapproved successfully');
    }

    
    public function getRatings()
    {

        $vendor_id=auth('vendor')->user()->id;
        /*$list= ProductRating::join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->join('products', 'products.id', '=', 'product_ratings.product_id')
                    ->where('products.vendor_id',$vendor_id)
                    ->orderBy('product_ratings.id', 'DESC')
                    ->get();*/
        $list= ProductRating::where('vendor_id',$vendor_id)
                    ->orderBy('id', 'DESC')
                    ->get();
                    
                 
        return view('admin.productratings.vendorlist', [
            'productratings' => $this->productratingRepo->paginateArrayResults($list->all(), 10)
        ]);
    }

    public function getVendorRatings()
    {

        $vendor_id=auth('vendor')->user()->id;
        $list= ProductRating::where('vendor_id',$vendor_id)
                    ->where('product_id','=',null)
                    ->orderBy('id', 'DESC')
                    ->get();
        return view('admin.productratings.vendorratinglist', [
            'productratings' => $this->productratingRepo->paginateArrayResults($list->all(), 10)
        ]);
    }

    public function searchratings(Request $request)
    {
        $vendor_id=auth('vendor')->user()->id;
        $status=$request->status;
        if($status=='most_recent'){
            $list= ProductRating::join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->join('products', 'products.id', '=', 'product_ratings.product_id')
                    ->where('products.vendor_id',$vendor_id)
                    ->orderBy('product_ratings.created_at', 'DESC')
                    ->get();
            return view('admin.productratings.listsearch', [
                
                'productratings' => $this->productratingRepo->paginateArrayResults($list->all(), 10)
            ]);

        }
        if($status=='top_rated'){
            $list= ProductRating::join('customers', 'customers.id', '=', 'product_ratings.user_id')
                    ->join('products', 'products.id', '=', 'product_ratings.product_id')
                    ->where('products.vendor_id',$vendor_id)
                    ->orderBy('product_ratings.rating', 'DESC')
                    ->get();

            return view('admin.productratings.listsearch', [
                'productratings' =>  $this->productratingRepo->paginateArrayResults($list->all(), 10)
            ]);

        }
        
    }

   
    public function destroy(int $id)
    {
        DB::table("product_ratings")->where("id", $id)->delete();
        return redirect()->route('admin.productratings.index')->with('message', 'Delete successful');
    }

}
