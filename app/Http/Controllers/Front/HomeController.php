<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Requests\InsertUserReview;
use App\Shop\Customers\Requests\InsertUserReviewOnVendor;
use App\Http\Controllers\Controller;
use App\productRating;
use Illuminate\Support\Facades\DB;
use Session;

class HomeController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */

 
    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    )
    {

      
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $business_types = DB::table('business_type')->orderby('id', 'desc')->get();
        $banner_contents = DB::table('banner_settings')->orderby('id', 'desc')->get();
        $blogs = DB::table('blogs')->orderby('id', 'desc')->get();
        $testimonials = DB::table('testimonials')->orderby('id', 'desc')->get();
            
        return view('front.index', compact('banner_contents', 'blogs', 'testimonials','business_types'));
       
    }
    public function shipping_info()
    {
        return view('front.shipping_info');
    }
    public function return_policy()
    {
        return view('front.return_policy');
    }
    public function internat_help()
    {
        return view('front.internat_help');
    }
    public function accessibility()
    {
        return view('front.accessibility');
    }
    public function mission()
    {
        return view('front.mission');
    }
    public function terms_condition()
    {
        return view('front.terms_condition');
    }

}
