<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wishlist;
use DB;
use Session;

class WishlistController extends Controller
{

	public function index()
    {

    	$data['user_id'] 	= $_POST['uId'];
    	$user_id 			= $data['user_id'];
    	$data['product_id'] = $_POST['prod_id'];
    	$product_id 		= $data['product_id'];
    	if($user_id!='' && isset($user_id)){
	    	$res = DB::table('wishlist')
	    		->where('user_id',$user_id)
	    		->where('product_id', $product_id)
	    		->first();
	    	if($res==''){
	    		Wishlist::create($data);
	    		echo 1;
	    	}else{
	    		//Wishlist::destroy($res->id);
	    		echo 2;
	    	}
	    }else{

	    	echo 0 ;

	    }
    }

    public function wishlist_details()
    { 

    	$uid=auth()->user()->id;
        if(isset($uid)){

            
    	$wish = DB::table('wishlist')
            ->join('products', 'wishlist.product_id', '=', 'products.id')
            ->select('wishlist.*','wishlist.id as oid','wishlist.created_at as date','products.*')
            ->where('wishlist.user_id', $uid)
            ->Orderby('wishlist.id', 'DESC')
            ->get();

    	 return view('front.wishlist_detail',[
            'wish' => $wish
            
        ]);

        }else{

         
            return redirect()->back()->with('message', 'Please Login First.');
        }
}

/**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function wishlist_destroy(int $id)
    {
        $idd= $id;
        
        DB::table("wishlist")->where('id', $idd)->delete();

        return redirect()->route('wishlist_detail')->with('message', 'Successfully Removed From Wishlist.');
    }
    
   
    

}
