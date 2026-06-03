<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice</title>
    <link href="{{ asset('css/invoice.css') }}" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">-->
    <style type="text/css">
        table { border-collapse: collapse;}
    </style>
    <style type="text/css">
    .zui-table {
        border: solid 1px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }
    .zui-table thead th {
        background-color: #f57332;
        border: solid 1px #fff;
        color: #fff;
        padding: 10px;
        text-align: left;
        font-size: 18px;
        font-weight: 600;
    }
    .zui-table tbody td {
        border: solid 1px #DDEEEE;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
    .Top-heading{
        font-size: 32px;
        text-transform: uppercase;
        background: #f57332;        
        padding: 5px 20px;
        border-radius: 7px;
        color: #fff; 
        font: normal Arial, sans-serif;
        text-align: center;    
    }
    .bottom-left,
    .Top-Left{
        float: left;
    }
    .bottom-right,
    .Top-Right{
        float: right;
    }
    .bottom-right td{
        padding: 2 30px;

    }
</style>
</head>
<body> 
    <section class="row">
        <center style="text-align: center; "><h2 class="Top-heading">Citrus Order Invoice</h2></center>
        <div class="row">
            <div class="form_description Top-Left">
                <!-- <img src="{{ public_path('logo.png') }}" alt="Citrus" width="150px;">  <br /> -->
                <strong>OrderID: </strong> #{{$order->token}} <br />
                <strong>Order Placed: </strong><?php echo date('M d, Y', strtotime($order->created_at)) ?>, <br />
                <strong>Invoice To: </strong>{{$customer->first_name}} {{$customer->last_name}}, <br />
            </div>
            <div class="Top-Right">
                <strong>Shipping Address:</strong><br />
                <strong>Email:</strong> {{ $address->email }} <br />
                <strong>Phone:</strong> {{ $address->phone }} <br />
                <div style="max-width: 200px;">
                    <strong>Address:</strong> {{ $address->address_1 }}    
                </div>
                <strong>Country:</strong> {{ $country }} <br />
                <strong>Postal Code:</strong> {{ $address->zip }}
            </div>
        </div>            
    </section>
    <section style="display: block;width: 100%; clear: both;" class="row">
        <div class="form_type">
            <strong>From: {{config('app.name')}}</strong>
        </div>
        <div class="col-md-12">
            <h2>Order Details</h2>
            <table class="table table-striped zui-table" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    
                @foreach($products as $product)
                  
                 <?php $description= strip_tags($product->description);?>
                    <tr>
                        <td>{{$product->sku}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{ substr($description, 0,  100) }}</td>
                        <td>{{$product->pivot->quantity}}</td>
                       
                        <td>{{ config('cart.currency_symbol') }} {{ isset($product->sale_price) ? $product->sale_price : $product->price}}</td>
                    </tr>
                @endforeach
         </tbody>
         <?php $subtotal=$order->total - $order->total_shipping;
            $shipping=$order->total - $subtotal; ?>
                <!-- <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Subtotal:</strong></td>
                        <td>{{$subtotal }}</td>
                    </tr>
                  
                    <tr>
                       
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Shipping:</strong></td>
                        <td>{{$shipping }}</td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total:</strong></td>
                        <td><strong>{{ $order->total }}</strong></td>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </section>
  
    <h2>Sold By :</h2>
    @foreach($vendors as $vendorss)
    <div class="bottom-row" style="margin-top: 20px;">
        <div class="form_description bottom-left">
             <?php 
             $vendor = DB::table('vendors')->where('id', $vendorss->vendor_id)->first();?>
            <strong>Seller Name: </strong>{{$vendor->first_name}} {{$vendor->last_name}}<br />
            <strong>Email: </strong>{{ $vendor->email }} <br />
            <strong>Phone: </strong>{{ $vendor->phone_number }} <br />
        </div>
        <div class="bottom-right">
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td>{{$subtotal }}</td>
                </tr>
                <tr>
                    <td><strong>Shipping:</strong></td>
                    <td>{{$shipping }}</td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><strong>{{ $order->total }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

    @endforeach
</body>
</html>