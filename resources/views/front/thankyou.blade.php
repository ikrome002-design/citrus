@extends('layouts.front.app')
@section('content')
<section class="container content">
  <div class="row mb-5 my-account-banner" style="border-radius: 15px;">
    <div  class="col-12">
      <h2 style="border-radius: 20px" class="text-center pt-5 pb-5 text-white font-normal">Thank you for supporting local businesses! Your order has been confirmed.</h2>
    </div>
  </div>
  <div class="order-received">
      <div class="card mb-5">
      <div class="card-body shadow-sm rounded-0 looooda">
      <div class="row">
        <div class="col-md-6 col-lg-3 col-12  order-received-box">
          <h6 class="font-weight-normal">Order number</h6>
          <h4 class="font-weight-bold font-20">#{{$order->reference}}</h4>
        </div>
        <div class="col-md-6 col-lg-3 col-12  order-received-box">
          <h6 class="font-weight-normal">Date :</h6>
          <h4 class="font-weight-bold font-20">
            
            {{date('d F Y', strtotime('-8 hours', strtotime($order->created_at)))}}
          </h4>
        </div>
        <div class="col-md-6 col-lg-3 col-12 order-received-box">
          <h6 class="font-weight-normal">Email:</h6>
          <h4 class="font-weight-bold font-20">{!! $customer->email ?: old('email')  !!}</h4>
        </div>
        <div class="col-md-6 col-lg-3 col-12 order-received-box">
          <h6 class="font-weight-normal">Total</h6>
          <h4 class="font-weight-bold font-20">${{$amount}}</h4>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="card order-details">
    <div class="card-body shadow-sm rounded-0">
      <h3 class="heading-primary mb-4">Delivery Address</h3>
      <div class="row">
      <div class="col-md-2">
          <p><b>Name :  </b></p>
          <p><b>Email : </b></p>
          <p><b>Address :</b></p>
          <p><b>Country :</b></p>
          <p><b>Postal Code :</b></p>
        </div>
        <div class="col-md-10">
          <p>{{ $address->first_name }} {{ $address->last_name }}</p>
          <p>{{ $address->email }} </p>
          <p>{{$address->address_1}}</p>
          <p>{{$country->name}}</p>
          <p>{{$address->zip}}</p>
        </div>
          </div>
          <div class="border-dashed mt-5 py-4" style="display: flex; align-items: center; flex-wrap: wrap;">
           <a class="heading-primary mr-4" href="tel:{{$address->phone}}"><i class="fa fa-phone mr-2 text-dark"></i>{{$address->phone}}</a>
            <a class="heading-primary" href="mailto:{{$address->email}}"><i class="fa fa-envelope mr-2 text-dark"></i>{!! $address->email ?: old('email')  !!}</a>
          </div>
        </div>
  </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
     localStorage.removeItem("__bCart");
});

</script>

@endsection