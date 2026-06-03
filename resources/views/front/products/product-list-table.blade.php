@if(!$products->isEmpty())
 <div class="card shadow-sm rounded-0">
   <div class="card-body">
    <h3 class="heading-primary text-uppercase">Your order</h3>
    <div class="table-responsive">
      <table class="table" id="checkout_table">
        <hr>
        <thead>
          <tr>
            <th scope="col" class="border-0" style="">Product</th>
            <th scope="col" class="border-0" style=""></th>
            <th scope="col" class="border-0 text-right" style="margin-left: auto; padding-right: 35px;">Shipping</th>
            <th scope="col" class="border-0 text-right" style="">Total</th>
          </tr>

        </thead>
        
        <tbody>
           <?php $newSub = 0; 
             $taxx = 0;
           ?>
            @foreach($cartItems as $cartItem)
            <?php
              $taxx =  $cartItem->tax + $taxx ;
            ?>
           <tr class="product-deatils" >
            <td >
                <a class="text-success" href="{{ route('product.detail', [$cartItem->product->shop_id, $cartItem->product->id]) }}">
                  @if(isset($cartItem->cover) &&  asset("$cartItem->cover") !=  asset("storage") )
                      <img src="{{ asset("$cartItem->cover") }}" alt="{{ $cartItem->name }}" class="product-img img-fluid p-0">
                  @else
                      <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $cartItem->name }}" class="product-img p-0 img-fluid p-0" />
                  @endif
                </a>
            </td>
            <?php 
            if(!empty($cartItem->product->flat_amount)){
              $flat_amount=$cartItem->product->flat_amount;
            }else{
              $flat_amount=0;
            }
            ?>
            <td style="width: 35%;">
             <div class="product-content">
               <a href="{{ route('product.detail', [$cartItem->product->shop_id, $cartItem->product->id]) }}" style="color:black;">
                <h6 style="font-size: 14px; font-weight: 500;">{{ $cartItem->name }}</h6></a>
              <p> {{config('cart.currency_symbol')}} {{ number_format(isset($cartItem->sale_price) ? $cartItem->qty*$cartItem->sale_price : $cartItem->qty*$cartItem->price, 2) }}</p>
            </div>
            </td>
            <td class="text-right" style="width: 20%;">
              <span><span>{{config('cart.currency_symbol')}}</span>{{  number_format($flat_amount)  }}</span>
            </td>
            <td class="text-right" style="width: 20%;">
              <span><span>{{config('cart.currency_symbol')}}</span>{{ number_format(isset($cartItem->sale_price) ? $cartItem->qty*$cartItem->sale_price : $cartItem->qty*$cartItem->price, 2) }}</span>
            </td>
          </tr>
           <?php 
            if(isset($cartItem->sale_price)){
              $newSale = $cartItem->sale_price * $cartItem->qty;
            }else{
              $newSale = $cartItem->price * $cartItem->qty ;
            }
            $newSub =  $newSale + $newSub; 
            ?>
          <?php
          $shipTot = 0;
        
          foreach ($products as $key ) {
              $shipTot =  $key->product->flat_amount + $shipTot ;
              
          }
          ?>
          @endforeach
          <tr class="shipping_details_tr" id="bottom-tr" style="display: none;">
            <td class="shipping_details" colspan="4">
            </td>
          </tr>         
          <tr class="checkout-subtotal">
            <th class="font-weight-normal" colspan="3">Subtotal</th>

            <td class="text-right font-weight-bold"><span>{{config('cart.currency_symbol')}}<span class="subtotal" id="subtotal">{{ $newSub }}</span></span></td>
          </tr>
          <tr class="checkout-shipping">
            <th class="font-weight-normal border-top-0" colspan="3">Total Shipping</th>
            <td class="text-right font-weight-bold border-top-0"><span>{{config('cart.currency_symbol')}}<span id="shipping_total_amount">{{ $shipTot }}</span><span id="shipping_total_amount_actual" style="display: none">{{ $shipTot }}</span></span></td>
          </tr>
         <!--  <tr class="checkout-subtotal">
            <th class="font-weight-normal border-top-0" colspan="3">Tax </th>
            <td class="text-right font-weight-bold border-top-0"><span>{{config('cart.currency_symbol')}} <span class="eco_tax">{{ number_format(($taxx ), 2) }}</span></span></td>
          </tr> -->
          <tr class="checkout-total">
            <th colspan="3" class="font-weight-normal">Order Total </th>
            <td class="text-right font-weight-bold"><span class="font-weight-normal font-16"> </span><span class="font-20 total_amount" id="total_amount">{{config('cart.currency_symbol')}} {{ number_format(($total + $taxx), 2, '.', ',') }}</span></td>
            <input type="hidden" name="eco_tax" class="eco_tax" value="{{$taxx}}">
             <input type="hidden" name="newSub" class="newSub" value="{{$newSub}}">
          </tr>
        </tbody>
      </table>
    </div>
   </div>
</div>

@endif 
