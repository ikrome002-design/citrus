<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use App\Shop\Brands\Brand;
use App\Shop\Vendors\Vendor;
use Illuminate\Pagination\Paginator;
use Yajra\DataTables\Html\Builder;
//use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {

        // Cashier::useCurrency(config('cart.currency'), config('cart.currency_symbol'));

        Builder::useVite();
        // if (Schema::hasTable('brands')) {
        //     // Code to create table
        //     $all_brands = DB::table('brands')->get();
        // } else {
        //     $all_brands = '';
        // }

        // // if (Schema::hasTable('vendors')) {
        // //     // Code to create table
        // //     $all_vendors = DB::table('vendors')->where('status', 1)->get();
        // // } else {
        // $all_vendors = '';
        // // }

        // // for the footer table in
        // if (Schema::hasTable('footers')) {
        //     $my_account = DB::table('footers')->where('type', 0)->get();
        //     $let_us = DB::table('footers')->where('type', 1)->get();
        //     $other_link = DB::table('footers')->where('type', 2)->get();
        // } else {
        //     $my_account = '';
        //     $let_us = '';
        //     $other_link = '';
        // }

        // if (Schema::hasTable('categories')) {
        //     // Code to create table
        //     //$parent_categories = DB::table('categories')->where('status', 1)->Where('parent_id', '=', NULL)->get();
        //     $parent_categories = DB::table('categories')->where('status', 1)->Where('parent_id', '=', NULL)->get();


        //     /* $parent_categories = DB::table('categories')->where('status', 1)->where('is_visible_main', '1')->where('id', '<>', 1)->limit(6)->get();*/
        //     $all_categories = DB::table('categories')->where('status', 1)->where('is_visible_main', '1')->where('id', '<>', 1)->limit(6)->get();

        //     $all_categories_search = DB::table('categories')->where('status', 1)->get();

        //     $parent_categories_sidebar = DB::table('categories')->where('status', 1)->where('is_visible_main', '1')->where('id', '<>', 1)->get();



        //     $child_categories = DB::table('categories')->where('status', 1)->where('id', 1)->orWhere('parent_id', '<>', NULL)->get();
        // } else {
        //     $all_categories = '';
        //     $all_categories_search = '';
        //     $parent_categories = '';
        //     $child_categories = '';
        //     $parent_categories_sidebar = '';
        // }

        // $parent_child_cat[] = array('id' => '', 'name' => '', 'slug' => '');
        // $subchild_cat = $this->findChildCat($parent_categories, $parent_child_cat);

        // for($i=0; $i < count($subchild_cat) ; $i++){

        //     if(isset($subchild_cat[$i]['child'])){
        //        // print_r($subchild_cat[$i]['child']);
        //         $childArray=$subchild_cat[$i]['child'];

        //         for($j=0; $j < count($childArray); $j++){

        //                $subids[]=$childArray[$j]['id'];

        //                 $sub_categories = DB::table('categories')->where('status', 1)->whereIn('parent_id',$subids)->get();
        //              // print_r( $sub_categories);

        //         }
        //     }else{
        //          $sub_categories='';
        //     }
        // }





        /*$all_brands = DB::table('brands')->get();

            $all_vendors = DB::table('vendors')->where('status', 1)->get();

            $all_categories = DB::table('categories')->where('status', 1)->get();

            $parent_categories = DB::table('categories')->where('status', 1)->where('id', '<>', 1)->limit(6)->get();

            $child_categories = DB::table('categories')->where('status', 1)->where('id', 1)->orWhere('parent_id', '<>', NULL)->get();


            $parent_child_cat[]= array('id' => '', 'name' => '', 'slug' =>'');*/
        // echo "<pre>";print_r($this->findChildCat($parent_categories, $parent_child_cat));die;

        // view()->share('all_brands', $all_brands);
        // view()->share('my_account', $my_account);
        // view()->share('let_us', $let_us);
        // view()->share('other_link', $other_link);
        // view()->share('all_vendors', $all_vendors);
        // view()->share('all_categories', $all_categories);
        // view()->share('all_categories_search', $all_categories_search);
        // view()->share('parent_categories', $parent_categories);
        // view()->share('parent_categories_sidebar', $parent_categories_sidebar);
        // view()->share('child_categories', $child_categories);
        // view()->share('parent_child_cat', $this->findChildCat($parent_categories, $parent_child_cat));
        //view()->share('sub_child_cat', $sub_categories);

        Paginator::useBootstrap();
    }

    /*public function home_data(){

            $all_brands = DB::table('brands')->get();

            $all_vendors = DB::table('vendors')->where('status', 1)->get();

            $all_categories = DB::table('categories')->where('status', 1)->get();

            $parent_categories = DB::table('categories')->where('status', 1)->where('id', '<>', 1)->limit(6)->get();

            $child_categories = DB::table('categories')->where('status', 1)->where('id', 1)->orWhere('parent_id', '<>', NULL)->get();


            $parent_child_cat[]= array('id' => '', 'name' => '', 'slug' =>'');
            // echo "<pre>";print_r($this->findChildCat($parent_categories, $parent_child_cat));die;

            view()->share('all_brands', $all_brands);
            view()->share('all_vendors', $all_vendors);
            view()->share('all_categories', $all_categories);
            view()->share('parent_categories', $parent_categories);
            view()->share('child_categories', $child_categories);
            view()->share('parent_child_cat', $this->findChildCat($parent_categories, $parent_child_cat));
    }
*/
    public function findChildCat($parent_categories, $parent_child_cat)
    {
        $i = 0;
        if (!empty($parent_categories)) {

            foreach ($parent_categories as $parent_cat) {
                $parent_child_cat[$i]['id'] = $parent_cat->id;
                $parent_child_cat[$i]['name'] = $parent_cat->name;
                $parent_child_cat[$i]['slug'] = $parent_cat->slug;
                $child_cats = DB::table('categories')->select('*')->where('parent_id',   $parent_cat->id)->get();
                if ($child_cats) {
                    $j = 0;
                    foreach ($child_cats as $child_cat) {
                        $parent_child_cat[$i]['child'][$j]['id']   = $child_cat->id;
                        $parent_child_cat[$i]['child'][$j]['name'] = $child_cat->name;
                        $parent_child_cat[$i]['child'][$j]['slug'] = $child_cat->slug;
                        $j++;
                    }
                }
                $i++;
            }
            return $parent_child_cat;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }
}
