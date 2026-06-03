@extends('layouts.front.app')
@section('content') 
    <!-- Main content -->
<section class="content ">
  <div class="row mb-5 my-account-banner"> 
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white font-normal">Track My Order</h2>
    </div>
  </div>
  <div class="container">
      <div class="row  " >
          <div class="col-md-12">
            <div class="shopList_filter">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Go Live
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          
                          <a class="dropdown-item" href="{{ route('shop.listing') }}">Shop</a>
                          
                        </div>
                      </div>
                  </div>
                </div>
                    <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Dashboard
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-account-details']) }}">Account Details</a>
                          <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                      </div>
                  </div>
                </div>
                    <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Order
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-my-order']) }}">My Orders</a>
                          <a class="dropdown-item" href="{{ route('wishlist_detail') }}">Wishlist</a>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        
    </div><br>
  <div class="row my-account-body">
    <div class="col-xl-3 col-lg-3 col-md-4 mb-5" id="div_id_name" style="display:none;">
      <div class="card">
        <div class="list-group">
          <a href="{{ route('accounts', ['tab' =>'v-pills-dashboard']) }}" class="list-group-item list-group-item-action">
            <i class="fa fa-tachometer mr-3" aria-hidden="true"></i>Dashboard</a>
          <a href="{{ route('accounts', ['tab' =>'v-pills-account-details']) }}" class="list-group-item list-group-item-action"><i class="fa fa-user mr-3"></i>Account Details</a>
          <a class="list-group-item list-group-item-action" href="{{ route('shop.listing') }}" ><i class="fa fa-shopping-bag mr-3" aria-hidden="true"></i>Shop</a>
          <a href="{{ route('accounts', ['tab' =>'v-pills-my-order']) }}" class="list-group-item list-group-item-action active"><i class="fa fa-dollar mr-3" aria-hidden="true"></i>My orders</a>
          
          <a href="{{ route('wishlist_detail') }}" class="list-group-item list-group-item-action"><i class="fa fa-heart mr-3" aria-hidden="true"></i>Wishlist</a>
         
          <a class="nav-link " href="{{ route('logout') }}" ><i class="fa fa-sign-out mr-3"></i>Logout</a>
        </div>
        </div>
      </div>

    <div class="col-xl-12 col-lg-12 col-md-12 mb-5"> 
      <div class="row">
      <div class="col-md-12">
      <a href="{{route('customer.invoice.generate',$order->id)}}" class="btn btn-primary" target="_blank">Download Invoice</a>
      </div>  
       </div> <br>          
      <div class="card track-order">
        <div class="row track-head ml-0 mr-0 pt-3 pb-3">
          <div class="col-lg-4 col-md-6 col-12 my-order-product-img"> 
             @if(!empty($order_product))

              @foreach ($order_product as $order_product_item)
            <div class="media  mb-3">
                <img class="img-fluid img-thumbnail rounded mr-3" src="{{ asset("storage/$order_product_item->cover") }}" alt="product-img">

                <div class="media-body">
                  
                      <h5 class="product-heading mb-2">{{$order_product_item->product_name}}</h5>
                      <h6 class="my-order-product-price font-normal">{{ config('cart.currency_symbol') }}{!! $order_product_item->sale_price  ? : $order_product_item->price !!}X{{$order_product_item->quantity}}</h6>                  
               
                </div>
              </div>
              @endforeach
            @endif
            </div>
            
            <?php $sum = $order->total;

             ?>
            <div class="col-lg-3 col-12 align-items-center text-center">
                <h5 class="font-20 mb-2">Order placed</h5>
                <h6 class="font-18 font-500">{{date('d-M-Y', strtotime($order->created_at)) }}</h6>
            </div>
            <div class="col-lg-2 col-12 align-items-center text-center">
                <h5 class="font-20 mb-2">Total</h5>
                <h6 class="font-18 font-500">${{$sum}}</h6>
            </div>
            <div class="col-lg-3 col-12 align-items-center text-center">
                <h5 class="font-20 mb-2">Order Number</h5>
                <h6 class="font-18 font-500">#{{$order->reference}}</h6>
            </div>
        </div>
     
      <div class="row ml-0 mr-0 track-body  card-body">
        <div class="col-md-12">
          <h3 class="mb-4 font-35 font-normal order-heading">Order Details</h3>
        </div>
        <div class="col-lg-4 col-md-4 col-12 mb-4">
          <div class="card h-100">
            <div class="card-body">
                <h6 class="heading-primary font-18 font-normal">Shipping Address</h6>
                <hr class="bg-success w-20">
                <p><b>Name :</b>&nbsp;&nbsp; {{$address->first_name}} {{$address->last_name}}</p>
                <p><b>Email :</b>&nbsp;&nbsp; {{$address->email}}</p>
                <p><b>Phone :</b> &nbsp;&nbsp;{{$address->phone}}</p>
                <p><b>Address :</b>&nbsp;&nbsp; {{$address->address_1}}</p>
                <p><b>Postal Code :</b>&nbsp;&nbsp;{{$address->zip}}</p>
                
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="">
                <h6 class="font-18 font-normal"> Payment Method</h6>
                <hr class="bg-success w-20">
                @if($order->payment=='cash')
                <p> COD Payment </p>
                @else
                <p> Cash On Delivery </p>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-12 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="">
                <h6 class="font-18 font-normal">Order Summary</h6>
                <hr class="bg-success w-20">
                <p>Item(s) Subtotal: ${{($order->total)-($order->total_shipping)}}</p>
                <p>Shipping: ${{$order->total_shipping}}</p>
                <p>Grand Total: ${{$order->total}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
 </div> 
</section>
<!-- /.content -->
@endsection