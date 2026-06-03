@extends('layouts.front.app')

@section('content')
<style type="text/css">
  html body .contshopping-button,
  html body .checkout-button{
    background-color: #FF7331 !important; color: #fff !important;
    border-radius: 50px !important;
  }
  .checkout-button:hover {
    background-color: #000 !important;
  }
</style>
<div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">Shopping Cart </h2>
  </div>
</div>
    @include('layouts.errors-and-messages')
<section class="container content">

   @if(!$cartItems->isEmpty())
  <div class="row shopping_cart">
  
    <div class="col-md-12">
          <div class="report-body mb-2">
              <div class="table-responsive">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Product</th>
                     <!--  <th scope="col">Vendor Company</th> -->
                      <th scope="col">Vendor Id</th>
                      <th scope="col">Unit Price</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">Total Amount</th>
                      <th scope="col">Remove</th>

                    </tr>
                  </thead>
                  <tbody>
               <?php $newSub = 0; ?>
                    @foreach($cartItems as $cartItem)
                    
                    <tr class="product-deatils">
                      <td>
                        <a href="{{ route('product.detail', [$cartItem->product->shop_id, $cartItem->product->id]) }}" class="text-success">
                            @if(isset($cartItem->cover) &&  asset("$cartItem->cover") !=  asset("storage") )
                                <img src="{{ ("$cartItem->cover") }}" alt="{{ $cartItem->name }}" class="product-img img-fluid p-0">
                            @else
                                <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $cartItem->name }}" class="product-img p-0 img-fluid p-0" />
                            @endif

                        </a>

                        </td>
                      <td>
                        <div class="product-content">
                           <a href="{{ route('product.detail', [$cartItem->product->shop_id, $cartItem->product->id]) }}" style="color:black;"><h6 class="font-weight-normal">{{ $cartItem->name }}</h6></a>
                          <p> {!!  str_limit($cartItem->product->description, 100, ' ...') !!}</p>
                        </div>
                      </td>
                      <!-- <td><a href="{{ route('shop.vendor-details', $cartItem->product->vendor_id) }}" style="color:black;">{{ $cartItem->product->vendor_company }}</a></td> -->
                      
                      <td> <a href="{{ route('merchant.view', $cartItem->product->vendor_id) }}" style="color:black;">#{!! $cartItem->product->vendor_id !!}</a></td>
                      <td>{{config('cart.currency_symbol')}} {{ number_format(isset($cartItem->sale_price) ? $cartItem->sale_price : $cartItem->price, 2) }}</td>
                      <td>
                        <div class="input-group quantity-form cart-qunty-box">
                            <span id="minus-qty" card-id="{{$cartItem->rowId }}">-</span> 
                            <input type="number" name="quantity" value="{{ $cartItem->qty }}" class="form-control input-sm quantity font-weight-bold"  max="{{ $cartItem->product->quantity }}" />
                            <span id="add-qty" class="main_{{ $cartItem->product->quantity }}" card-id="{{$cartItem->rowId}}">+</span>
                        </div>
                          <input type="hidden" name="maxVal" id="maxVal_{{ $cartItem->product->quantity }}" class="maxVal" value="{{ $cartItem->product->quantity }}">

                      </td>
                      <td class="total_amount">{{config('cart.currency_symbol')}} {{ number_format(isset($cartItem->sale_price) ? $cartItem->qty*$cartItem->sale_price : $cartItem->qty*$cartItem->price, 2) }}</td>
                      <td><button class="btn shop-btn" card-id="{{$cartItem->rowId }}" id="RemoveCart"><i class="fa fa-trash"></i></button></td>
                      <?php 
                      if(isset($cartItem->sale_price)){
                        $newSale = $cartItem->sale_price * $cartItem->qty;
                      }else{
                        $newSale = $cartItem->price * $cartItem->qty ;
                      }
                      $newSub =  $newSale + $newSub; 
                      ?>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
    </div>
  </div>


  <div class="row mt-5 mb-5">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <h2 class="mb-4 font-weight-bold">Cart total</h2>

      <div class="cart-totals border table-responsive">
        <table class="table mb-0">
          <tbody>
            
            <tr class="cart-total border-top ">
              <th>Sub-Total</th>
              <td class="font-weight-bold"><span><span>{{config('cart.currency_symbol')}}</span> {{ number_format($newSub, 2, '.', ',') }}</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="proceed-to-checkout mt-4">
        <div class="row">
          <div class="col-md-6 col-12 col-sm-12">
            <a href="{{ route('shop.listing') }}" class="btn contshopping-button bg-transparent text-dark w-100 rounded-0 font-weight-bold">CONTINUE SHOPPING</a>
          </div>
          <div class="col-md-6 col-12 col-sm-12 mt-md-3 mt-lg-0">
            <a  href="{{ route('checkout.index') }}"class="btn checkout-button text-white  w-100 mb-4 rounded-0 font-weight-bold">PROCEED TO CHECKOUT</a>
          </div>
       </div>   
        
      </div>
    </div>
  </div>
  @else
      <div class="row">
          <div class="col-md-12">
              <p class="alert alert-warning">No products in cart yet. <a href="{{ route('shop.listing') }}">Shop now!</a></p>
          </div>
      </div>
  @endif
</section>
@endsection
@section('js')
<script>
    
  $(document).on('click', '#add-qty', function(){
    var card_id=$(this).attr('card-id');
    var quantity_value=Number(jQuery(this).prev('input').val()); 
    var maxVal = $(this).attr('class');
    var newValueIs=maxVal.split("_");
    if(newValueIs[1]!=''){
      var newMax = $("#maxVal_"+newValueIs[1]).val();
      var quantity=quantity_value+1;
      if(quantity > newMax){
        quantity=quantity_value;
        alert('Stock limit reached');
      }
      console.log('quantity===>',maxVal);
      var url = '{{ route("cart.update", ":id") }}';
      url = url.replace(':id', card_id);
      $.ajax({
          url: url,
          type: "POST",
          data: {
              _token: '{{ csrf_token() }}',
              _method: 'put',
              quantity: quantity
          },
          success: function(data) {
              $('section.container.content').html(data);
          }
      });
    }else{
      alert('Error!');
    }

   

  });
  $(document).on('click', '#minus-qty', function(){
    var card_id=$(this).attr('card-id');
    var val = Number(jQuery(this).next('input').val());
    if( val > 0 ){
      var quantity=val-1;
      var url = '{{ route("cart.update", ":id") }}';
      url = url.replace(':id', card_id);
      var html = "";
      $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'put',
            quantity: quantity
        },
        success: function(data) {
            $('section.container.content').html(data);
        }
      });
    }
  });

  $(document).on('click', '#RemoveCart', function(){
    var card_id=$(this).attr('card-id');
    var url = '{{ route("cart.destroy", ":id") }}';
    url = url.replace(':id', card_id);
    // alert(url);
    $.ajax({
      url: url,
      type: "POST",
      data: {
          _token: '{{ csrf_token() }}',
          _method: 'delete'
      },
      success: function(data) {
        location.reload();
      }
    });
  });



</script>
@endsection
