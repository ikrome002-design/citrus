<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    public function index()
    {

        $uid=auth('vendor')->user()->id;
        date_default_timezone_set("Asia/Kolkata");
        $ddate=date('d-M-Y');

        $replied_at=date('Y-m-d ');
        $firstdate= date('Y-m-01'); 
        $payout =  DB::table('order_product')->where('vendor_id', $uid)->where('date', $replied_at)->get();
        $orders_count= count($payout);
    
        $totalorder =  DB::table('order_product')->where('vendor_id', $uid)->get();
        $total_order=count($totalorder);

         $fdate =  DB::table('orders')->whereBetween('date', [$firstdate, $replied_at])->select('orders.total')->where('vendor_id', $uid)->get();
         $fdate_count= count($fdate);
        
           
        $dateS = Carbon::now()->startOfMonth()->subMonth(12);
        $dateE = Carbon::now()->startOfMonth(); 

        $TotalSpent = DB::select("select year(date) as year, month(date) as month, sum(product_price) as total_amount from order_product where vendor_id='$uid' group by year(date), month(date)");

        $category =DB::table('categories')
            ->join('category_product', 'categories.id', '=', 'category_product.category_id')
            ->join('products', 'category_product.product_id', '=', 'products.id')
            ->join('order_product', 'products.id', '=', 'order_product.product_id', )
            ->select('categories.*', 'category_product.*', 'products.*', 'order_product.*', 'categories.name as category_name')
            ->where('order_product.vendor_id', $uid)
            ->groupBy('categories.id', 'category_product.category_id', 'products.id', 'order_product.product_id')
            ->get();
            $category_count=count($category);

        return view('vendor.report',["ddate" => $ddate, "payout" => $payout, "totalorder" => $totalorder, "total_order" => $total_order, "orders_count" => $orders_count, "TotalSpent" => $TotalSpent, "fdate" => $fdate, "fdate_count" => $fdate_count, "category" => $category]);

    }

     public function search()
    {
       $uid=auth('vendor')->user()->id;
       $replied_at=date('Y-m-d ');
       $ddate=date('Y-m-d', strtotime("-1 month"));
       $ddate1=date('Y-m-d', strtotime("-6 month"));
       $ddate2=date('Y-m-d', strtotime("-1 year"));
      
       $month=$_POST['month'];
       $from=$_POST['from_date'];
       $from_date=date("Y-m-d", strtotime($from));  
       $to=$_POST['to_date'];
       $to_date=date("Y-m-d", strtotime($to));  
       if($month=='Monthly'){
        $items =  DB::table('order_product')->whereBetween('date', [$ddate, $replied_at])->select('order_product.*')->where('vendor_id', $uid)->get();
         $pdf = PDF::loadView('vendor.pdfview',["items" => $items, "from_date" => $ddate, "to_date" => $replied_at]);
       }

       if($month=='HalfYearly'){
        $items =  DB::table('order_product')->whereBetween('date', [$ddate1, $replied_at])->select('order_product.*')->where('vendor_id', $uid)->get();
          $pdf = PDF::loadView('vendor.pdfview',["items" => $items, "from_date" => $ddate1, "to_date" => $replied_at]);
       }

       if($month=='Yearly'){
        $items =  DB::table('order_product')->whereBetween('date', [$ddate2, $replied_at])->select('order_product.*')->where('vendor_id', $uid)->get();
          $pdf = PDF::loadView('vendor.pdfview',["items" => $items, "from_date" => $ddate2, "to_date" => $replied_at]);
       }


       if($month=='Custom'){
       $items =  DB::table('order_product')->whereBetween('date', [$from_date, $to_date])->select('order_product.*')->where('vendor_id', $uid)->get();

        $pdf = PDF::loadView('vendor.pdfview',["items" => $items, "from_date" => $from_date, "to_date" => $to_date]);
   }
     
        return $pdf->download('pdfview.pdf');
        return redirect()->back();

    }

    public function pdfview(Request $request)
    {

      $uid=auth('vendor')->user()->id;
      $from_date=$_GET['from_date'];
      
      $to_date=$_GET['to_date'];
      $items =  DB::table('order_product')->whereBetween('date', [$from_date, $to_date])->select('order_product.*')->where('vendor_id', $uid)->get();
    
      view()->share('items',$items);
      if($request->has('download')){
     
      $pdf = PDF::loadView('vendor.pdfview');
       print_r($from_date);
      die();
      return $pdf->download('pdfview.pdf');
      }
      return view('vendor.pdfview');
    }

    public function gen_trans_report()
    {
      $uid=auth('vendor')->user()->id;
      $orders = DB::table('order_payment')
          ->join('orders', 'order_payment.token', '=', 'orders.token')
          ->select('order_payment.*','orders.token as order_token')
          ->where('orders.vendor_id', $uid)
          ->groupBy('order_payment.id')
           ->orderBy('order_payment.id','desc')
            ->get();
        
      foreach ($orders as $order) {
          $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();
          $products_list = DB::table('orders')
              ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference','order_product.product_sku','order_product.product_id')
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
              $ii++;
          }
          $order->products1 = $products1;

          $pdf = PDF::loadView('vendor.transReportPdf',["orders" => $orders]);
      }
      return $pdf->download('transReportPdf.pdf');
      return redirect()->back();
    }


public function admin_gen_trans_report()
    {
      
      $orders = DB::table('order_payment')
          ->join('orders', 'order_payment.token', '=', 'orders.token')
          ->select('order_payment.*','orders.token as order_token')
          ->groupBy('order_payment.id')
           ->orderBy('order_payment.id','desc')
            ->get();
        
      foreach ($orders as $order) {
          $order_list = DB::table('orders')->select('vendor_id', 'total_products')->where('token', $order->token)->get();
          $products_list = DB::table('orders')
              ->select('orders.id AS oid','orders.vendor_id', 'orders.total_products', 'orders.reference','order_product.product_sku','order_product.product_id')
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
              $products1[$ii]['oid'] = $product1->oid;
              $ii++;
          }
          $order->products1 = $products1;

          $pdf = PDF::loadView('vendor.transReportPdf',["orders" => $orders]);
      }
      return $pdf->download('transReportPdf.pdf');
      return redirect()->back();
    }



}
