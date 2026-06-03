<?php

namespace App\Shop\Orders\Repositories;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Events\OrderCreateEvent;
use App\Mail\sendEmailNotificationToAdminMailable;
use App\Mail\SendOrderToCustomerMailable;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Transformers\OrderTransformable;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use SendGrid;


class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params) : Order
    {   
       
        try {

            $order = $this->create($params);
     
            $orderRepo = new OrderRepository($order);
            $orderRepo->buildProductOrder($params['product_order'],$order->id );

            event(new OrderCreateEvent($order));

            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }
    // for order table
    public function createNewOrder(array $params) : Order
    {   
        try {

            $order = $this->create($params);
            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }




    /**
     * @param array $items
     * @param INT $order_id
     *
     * @return bool
     * @throws OrderInvalidArgumentException
     */
    public function buildProductOrder($items, $order_id){

        for ($i=0; $i< count($items); $i++) {

      

            $productRepo = new ProductRepository(new Product);
            $product = $productRepo->find($items[$i]->id);
            if ($items[$i]->options->has('product_attribute_id')) {
                $this->associateProduct($product, $item->qty, [
                    'product_attribute_id' => $items[$i]->options->product_attribute_id
                ]);
            } else {
                $this->associateProduct($product, $items[$i]->qty);
            }
            
        }
        

    }


    /**
     * @param array $params
     *
     * @return bool
     * @throws OrderInvalidArgumentException
     */
    public function updateOrder(array $params) : bool
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findOrderById(int $id) : Order
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e);
        }
    }


    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function findProducts(Order $order) : Collection
    {
        return $order->products;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param array $data
     */
    public function associateProduct(Product $product, int $quantity = 1, array $data = [])
    {

        date_default_timezone_set("Asia/Kolkata");
        $ddate=date('Y-m-d');
        $this->model->products()->attach($product, [
            'quantity' => $quantity,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_description' => $product->description,
            'product_price' => $product->sale_price,
            'vendor_id' => $product->vendor_id,
            'date' => $ddate,
            'product_attribute_id' => isset($data['product_attribute_id']) ? $data['product_attribute_id']: null,
        ]);
        $product->quantity = ($product->quantity - $quantity);
        $product->save();
    }

    /**
     * Send email to customer
     */
    public function sendEmailToCustomer()
    {
        $customer = $this->model->customer;
        $result = $this->findOrderById($this->model->id);
            
        $products = $result->products;
        $customer = $result->customer;
        $courier = $result->courier;
        $address = $result->address;
        $status = $result->orderStatus;
        $payment = $result->paymentMethod;
        $country = \App\Shop\Countries\Country::find($address->country_id);
        $created = date("Y-m-d");
        $newDate = date('d F Y', strtotime($created));
        $message1 = "<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
                      <img src='#'>
                       <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse'>
                          <tbody>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table  style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table  style='width:100%;border-collapse:collapse'>
                                                  <tbody>
                                                     <tr>
                                                        <td><img class='site-logo' src='#' alt='ShopLocal'></td>
                                                        <td colspan='3' style='text-align:right;padding:7px 0 5px 0;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                                           <h2 style='font-size:20px;line-height:24px;margin:0;padding:0;font-weight:normal;color:rgb(0,0,0)!important'> Order Confirmation </h2>
                                                           Order # <a href='#' style='display:inline-block;text-decoration:none;color:rgb(0,102,153);font:12px/16px Arial,sans-serif' rel='noreferrer' target='_blank' data-saferedirecturl='#'>
                                                           ".$result->token."
                                                           </a>
                                                            <br> 
                                                        </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>
                                         <tr>";
                            $message1 .=  "<td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:100%;border-collapse:collapse'>
                                                  <tbody>
                                                     <tr>
                                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                                           <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$customer->name.", </h3>
                                                           <p style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Thank you for visiting us and making your purchase! We’re glad that you found what you were looking for. It is our goal that you are always happy with what you bought from us, so please let us know if your buying experience was anything short of excellent. We look forward to seeing you again. Have a great day! </p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:100%;border-collapse:collapse'> 
                                               </table>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:100%;border-collapse:collapse;background:#206080;'>
                                                  <tbody>
                                                     <tr style='background-color:#588e43'>
                                                        <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                                           <p style='margin:2px 0 9px 0;font:12px/16px Arial,sans-serif'> <span style='color:#fff'>Placed Date:</span> <br> <b style='color:#fff'> ".$newDate." </b> </p>
                                                           <p style='margin:2px 0 9px 0;font:12px/16px Arial,sans-serif'> <span style='color:#fff'>payment method:</span> <br> <b style='color:#fff'> ".strtoupper($result->payment)." </b> </p>
                                                        </td>
                                                        <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                                           <p style='margin:2px 0 9px 0;color: #fff; font:12px/16px Arial,sans-serif; float: right;'> <span style='color:#fff'>Your order will be sent to:</span> <br> <b> ".$customer->name."</b> 
                                                                <br>".
                                                                 $address->address_1.",".$address->address_2.",".$address->city.$address->state_code.",". $country->name." 
                                                            </p>
                                                        </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>
                                         <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-top: -2px !important; padding: 0 1px;'>         
                                            <thead>
                                               <tr style='background: #206080;'>
                                                  <th style='color: #fff; padding: 20px 0; font-size: 12px;'>SKU</th>
                                                  <th style='color: #fff; padding: 20px 0; font-size: 12px;'>Name</th>
                                                  
                                                  <th style='color: #fff; padding: 20px 0; font-size: 12px;'>Quantity</th>
                                                  <th style='color: #fff; padding: 20px 0; font-size: 12px;'>Price</th>
                                               </tr>
                                            </thead>
                                            <tbody>";
                                            $newSum = 0;
                                            foreach($products as $product) {
                                $message1 .=    "<tr>
                                                  <td style='vertical-align: top; width: 25%; border-right: 1px solid #c7baba; border-left: 1px solid #c7baba; padding: 15px; text-align: center; font-size: 12px;'>".$product->sku."</td>
                                                  <td style='vertical-align: top; width: 25%; border-right: 1px solid #c7baba; padding: 15px; text-align: center; font-size: 12px;'>".$product->name."</td>
                                                  
                                                  <td style='vertical-align: top; width: 12%; border-right: 1px solid #c7baba; padding: 15px; text-align: center; font-size: 12px;'>".$product->pivot->quantity."</td>
                                                  <td style='vertical-align: top; width: 25%; border-right: 1px solid #c7baba; padding: 15px; text-align: center; font-size: 12px;'>".config('cart.currency')." ". number_format($product->sale_price * $product->pivot->quantity, 2) ."</td>
                                               </tr>";
                                                $pricePerProduct = $product->sale_price * $product->pivot->quantity ;
                                                $newSum =  $pricePerProduct + $newSum ;
                                                
                                           }
                                           
                                $message1 .=  "</tbody>
                                         </table>
                                         
                                         <tr>
                                            <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5;margin-top:0;'>Order summary</h3>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style=' vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
                                                  <tbody>
                                                     <tr>
                                                        <td style='padding-left: 15px; vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> Order #<a href='#'>".$result->token."</a> <br> <span style='font-size:12px;color:rgb(102,102,102)'>Placed on : ".$newDate."</span> </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>
                                            <td style='padding-left:15px;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:95%;border-collapse:collapse'>
                                                  <tbody>
                                                     <tr>
                                                        <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Item Subtotal: </td>
                                                        <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$newSum." </td>
                                                     </tr>
                                                     <tr>
                                                        <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Shipping &amp; Handling: </td>
                                                        <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$result->total_shipping." </td>
                                                     </tr>
                                                     
                                                     <tr>
                                                        <td colspan='2' style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                                           <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td colspan='2' style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                                           <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td style='font-size:14px;font-weight:bold;font:12px/16px Arial,sans-serif;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-family:Arial,sans-serif'> <strong> Order Total: </strong> </td>
                                                        <td style='font-size:14px;font-weight:bold;font:12px/16px Arial,sans-serif;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-family:Arial,sans-serif'> <strong> ".
                                                        $totAmt = $newSum + $result->total_shipping ." </strong> </td>
                                                     </tr>
                                                     <tr>
                                                        <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                                           <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                                           <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td colspan='2' style='padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
                                                     </tr>
                                                     <tr>
                                                        <td colspan='2' style='border-top:1px solid rgb(234,234,234);padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>                     
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                                  <tbody>
                                                     <tr>
                                                        <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                                           <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We hope to see you again soon. <br> <span style='font-size:16px;font-weight:bold'> <a style='color: #000; text-decoration: none;' href='#'><strong>".getenv('APP_NAME')."</strong> </a></span> </p>
                                                        </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                          </tbody>
                       </table>
                       <img src='#'>
                    </div>";

        $emails = $customer->email;
        $subject = 'Order Related'; 
        $senderEmail = getenv('SENDGRID_EMAIL');
        $senderName = getenv('APP_NAME'); 

        $emailReports = [];
        $addressesArray = $emails;
        $email = new SendGrid\Mail\Mail();
        $email->setFrom($senderEmail, $senderName);
        $email->setSubject($subject);
        $email->addTo($addressesArray);
        $email->addContent("text/html", $message1 );
          $apiKey = getenv('SENDGRID_API_KEY');
          $sendgrid = new \SendGrid($apiKey);
        try {
            $response = $sendgrid->send($email);
            array_push($emailReports, $addressesArray . " => " . $response->statusCode());
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


    }

    /**
     * Send email notification to the admin
     */
    public function sendEmailNotificationToAdmin()
    {
        $employeeRepo = new EmployeeRepository(new Employee);
        $employee = $employeeRepo->findEmployeeById(1);

        Mail::to($employee)
            ->send(new sendEmailNotificationToAdminMailable($this->findOrderById($this->model->id)));
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchOrder(string $text) : Collection
    {
        if (!empty($text)) {
            return $this->model->searchForOrder($text)->get();
        } else {
            return $this->listOrders();
        }
    }

    /**
     * @return Order
     */
    public function transform()
    {
        return $this->transformOrder($this->model);
    }

    /**
     * @return Collection
     */
    public function listOrderedProducts() : Collection
    {
        return $this->model->products->map(function (Product $product) {
            $product->name = $product->pivot->product_name;
            $product->sku = $product->pivot->product_sku;
            $product->description = $product->pivot->product_description;
            $product->price = $product->pivot->product_price;
            $product->quantity = $product->pivot->quantity;
            $product->product_attribute_id = $product->pivot->product_attribute_id;
            return $product;
        });
    }

    /**
     * @param Collection $items
     */
    public function buildOrderDetails(Collection $items)
    {
        $items->each(function ($item) {
            $productRepo = new ProductRepository(new Product);
            $product = $productRepo->find($item->id);
            if ($item->options->has('product_attribute_id')) {
                $this->associateProduct($product, $item->qty, [
                    'product_attribute_id' => $item->options->product_attribute_id
                ]);
            } else {
                $this->associateProduct($product, $item->qty);
            }
        });
    }

    /**
     * @return Collection $addresses
     */
    public function getAddresses() : Collection
    {
        return $this->model->address()->get();
    }

    /**
     * @return Collection $couriers
     */
    public function getCouriers() : Collection
    {
        return $this->model->courier()->get();
    }
}
