<?php

namespace App\Shop\Checkout;

use App\Events\OrderCreateEvent;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Orders\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Shop\Orders\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Vendor;
use App\Shop\Products\Product;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockNotify;
class CheckoutRepository
{


    /**
     * @param array $data
     *
     * @return Order
     */
    public function buildCheckoutItems(array $data) : Order
    {
        date_default_timezone_set("Asia/Kolkata");
        $datee=date('Y-m-d');
        $orderRepo = new OrderRepository(new Order);

        $card_products = Cart::content();


        foreach($card_products as $k => $v) { 
            $card_products_groups[$v->product['vendor_id']][]=$v; 
            $ids[$v->product['id']][]=$v; 
            $qty[$v->product['quantity']][]=$v; 
        }


        $cc=count($card_products_groups);

        $vendor_ids = array_keys($card_products_groups);//vendorIds
        $idsNew = array_keys($ids);//ProductsIds
        $qtyNew = array_keys($qty);//QuantityIds

        $lid =  DB::table('orders')->orderBy('id', 'desc')->get();
        $lcount=count($lid);
        $token='ORD'.$lcount;
        
            $total = 0;
            $price = 0;
            $qty = 0;
            $amount = 0;

            foreach ( $card_products as $card_products_group) {
                
                $qty = $card_products_group->qty;
                $amount = $card_products_group->product->flat_amount;
                $price = $card_products_group->sale_price ? $card_products_group->sale_price : $card_products_group->price;
               
                $total= $price*$qty + $amount +$total;
               
            }

        //end for loop
        $order = $orderRepo->create([
                'reference' => rand('10000', '99999'),
                'courier_id' => $data['courier_id'],
                'customer_id' => $data['customer_id'],
                'address_id' => $data['address_id'],
                'delivery_address' => $data['delivery_address'],
                'order_status_id' => $data['order_status_id'],
                'payment' => $data['payment'],
                'discounts' => $data['discounts'],
                'total_products' => json_encode($idsNew), //productId
                'total' =>$total,
                'total_paid' => $data['total_paid'],
                'total_shipping' => isset($data['total_shipping']) ? $data['total_shipping'] : 0,
                'tax' => $data['tax'],
                'vendor_id' => json_encode($vendor_ids),
                'date' => $datee,
                'token' => $token
            ]);
         $oid= $order->id;
         foreach ($card_products as $card_products_group) {
            //out of stock
            $stock=$card_products_group->product->quantity - $card_products_group->qty;
            $stock_product=Product::where('id',$card_products_group->id)->update(['quantity'=>$stock]);

            if($stock <= 0){
                $vendor_email=Vendor::where('id',$card_products_group->product->vendor_id)->first();
                $email=$vendor_email->email;
                $name=$vendor_email->first_name.' '.$vendor_email->last_name;
                $mailData = [
                'product_id' => $card_products_group->id,
                'product_name' => $card_products_group->name,    
                'product_sku' => $card_products_group->product->sku,
                'name' => $name
                
               ];
      
               Mail::to($email)->send(new StockNotify($mailData));

            }

            //order products
            $order_products = DB::table('order_product')->insert([
            'order_id'            => $oid,
            'product_id'          => $card_products_group->id,
            'quantity'            => $card_products_group->qty,
            'vendor_id'           => $card_products_group->product->vendor_id,
            'date'                => $datee,
            'product_name'        => $card_products_group->name,
            'product_sku'         => $card_products_group->product->sku,
            'product_description' => $card_products_group->product->description,
            'product_price'       =>$card_products_group->product->sale_price,

            'shop_id'         => $card_products_group->product->shop_id,
            'shipping'         => $card_products_group->product->flat_amount,
            'order_status'  => $data['order_status_id'],
            'product_attribute_id'=>$data['customer_id'] //customerId
               
            ]);
        } //end foreach
        
        return $order;
    }
}
