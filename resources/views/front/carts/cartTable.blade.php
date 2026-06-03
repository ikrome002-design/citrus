@if(!$cartItems->isEmpty())
<div class="row shopping_cart">
  <!-- <h2 class="pt-5 pb-5 font-bold">Shopping cart</h2> -->
  <div class="col-md-12">
        <div class="report-body mb-2">
            <div class="table-responsive">
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Product</th>
                    <!-- <th scope="col">Vendor Company</th> -->
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
                        <p>{!!  str_limit($cartItem->product->description, 100, ' ...') !!}</p>
                      </div>
                    </td>
                    <!-- <td><a href="{{ route('shop.vendor-details', $cartItem->product->vendor_id) }}" style="color:black;">{{ $cartItem->product->vendor_company }}</a></td> -->
                      <td> <a href="{{ route('merchant.view', $cartItem->product->vendor_id) }}" style="color:black;">#{!! $cartItem->product->vendor_id !!}</a></td>
                    <td>{{config('cart.currency_symbol')}} {{ number_format(isset($cartItem->sale_price) ? $cartItem->sale_price : $cartItem->price, 2) }}</td>
                    <td>
                      <div class="input-group quantity-form cart-qunty-box">
                         <span id="minus-qty" card-id="{{$cartItem->rowId }}">-</span>  
                         <input type="number" name="quantity" value="{{ $cartItem->qty }}" class="form-control input-sm quantity font-weight-bold" max="{{ $cartItem->product->quantity }}"/>
                        <span id="add-qty" class="main_{{ $cartItem->product->quantity }}" card-id="{{$cartItem->rowId}}">+</span>
                      </div>
                      <input type="hidden" name="maxVal" class="maxVal" id="maxVal_{{ $cartItem->product->quantity }}" value="{{ $cartItem->product->quantity }}">
                    
                    </td>
                    <td class="total_amount">{{config('cart.currency_symbol')}} {{ number_format(isset($cartItem->sale_price) ? $cartItem->qty*$cartItem->sale_price : $cartItem->qty*$cartItem->price, 2) }}</td>
                    <td><button class="btn shop-btn" card-id="{{$cartItem->rowId }}" id="RemoveCart"><i class="fa fa-trash"></i></button></td>
                    <?php 
                      if(isset($cartItem->sale_price)){
                        $newSale = $cartItem->sale_price * $cartItem->qty;
                      }else{
                        $newSale = $cartItem->price * $cartItem->qty;
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
            <a href="{{ route('shop.listing') }}" class="btn contshopping-button border bg-transparent text-dark w-100 rounded-0 font-weight-bold">CONTINUE SHOPPING</a>
          </div>
          <div class="col-md-6 col-12 col-sm-12 mt-md-3 mt-lg-0">
            <a  href="{{ route('checkout.index') }}"class="btn checkout-button bg-success text-white  w-100 mb-4 rounded-0 font-weight-bold">PROCEED TO CHECKOUT</a>
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

