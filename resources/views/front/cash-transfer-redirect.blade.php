@extends('layouts.front.app')

@section('content')
<style type="text/css">
    a.btn.back-bt,
    button.btn.conform-bt {
        background: #f57332;
        color: #fff;
        padding: 10px 24px !important;
        font-size: 16px;
    }
    button.btn.conform-bt:hover,
    a.btn.back-bt{
        background: #000;
    }
    a.btn.back-bt:hover {
        background: #f57332;
    }
</style>
<nav aria-label="breadcrumb">
    <div class="breadcrumb pl-5">
      <ol class="container breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i class="fa fa-home"></i> Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
      </ol>
    </div>
</nav>

    <div class="container product-in-cart-list">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-0 order-conform-box">
                <div class="card-body align-middle">
                <form action="{{ route('cash-transfer.store') }}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-12 text-center">
                       <ul class="list-unstyled">
                            <li><span class="font-weight-bold">Subtotal: </span>{{ config('cart.currency_symbol') }} 
                                <span id="subtotal">{{ $subtotal }}</span>
                            </li>
                            
                            <li><span class="font-weight-bold">Shipping Fee: </span>{{ config('cart.currency_symbol') }} <span id="shipping_fees">{{ number_format((($total)- $subtotal), 2, '.', ',') }}</span></li>
                            <li><span class="font-weight-bold">Total : </span>{{ config('cart.currency_symbol') }} <span id="total">{{ $total }}</span></li>
                        </ul>
                    </div>
                    <?php 
                    $totAmt = $total - $subtotal; 
                    $pay=$_GET['payment'];
                    ?>
                    <div class="col-md-12 text-center">
                        <div class="box-body">
                            @if($pay=='cash')
                            <h3>Cash on delivery selected</h3>
                            @else
                             <h3>Cash on delivery selected</h3>
                            @endif
                            <div class="btn-group">
                                <a href="{{ route('checkout.index') }}" class="btn back-bt mr-3">Back</a>
                                <button class="btn conform-bt">Confirm your order</button>
                                <input type="hidden" id="billing_address" name="billing_address" value="{{ $billingAddress }}">
                                <input type="hidden" id="delivery_address" name="delivery_address" value="{{ $_GET['delivery_address'] }}">
                                
                                <input type="hidden" name="shipment_obj_id" value="{{ $shipmentObjId }}">
                                <input type="hidden" name="rate" value="{{ $rateObjectId }}">
                                <input type="hidden" name="shippingAmt" id="shippingAmt" value="{{ $totAmt }}">
                                <input type="hidden" name="payment" value="{{ $pay }}">
                                <input type="hidden" name="NewamountSum" id="NewamountSum" value="{{ $total}}">
                                
                                @if(request()->has('courier'))
                                    <input type="hidden" name="courier" value="{{ request()->input('courier') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                  </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
     var obj = JSON.parse(localStorage.getItem("__bCart"));
    console.log(obj);
    console.log(obj.subtotal);
    console.log(obj.shipping_total_amount);
    console.log(obj.subtotal);
    console.log(obj.total_amount);
    $('#subtotal').text(obj.subtotal);
    $('#shipping_fees').text(obj.shipping_total_amount);
    $('#shippingAmt').val(obj.shipping_total_amount);
    $('#total').text(obj.total_amount);
    $('#NewamountSum').val(obj.total_amount);
});

</script>

@endsection
