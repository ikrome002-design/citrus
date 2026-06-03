@extends('layouts.front.app')
@section('content')
  <div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">Checkout </h2>
  </div>
</div>
<div class="container">

   <div class="row">
  
      <div class="col-md-7 checkout-form">
         <div class="card shadow-sm rounded-0">
            <div class="card-body">
               <h3 class="heading-primary mb-3 text-uppercase">Shipping details</h3>
               <form class="form-horizontal" role="form" method="POST" id="billingAddress">
                <input type="hidden" name="billing_address_id" value="{{auth()->user()->id}}">
             
                  <div class="billing_show_form">
                     <div class="form-row">
                        <div class="col-md-6 form-group">
                           <label for="billing_first_name">First name <span class="text-danger">*</span></label>
                           <input id="billing_first_name" type="text" class="form-control border-mute rounded-0 bg-light text-left first_name" name="billing_first_name" value="{{ auth()->user()->first_name}}" autofocus>
                        </div>
                        <div class="col-md-6 form-group">
                           <label for="billing_last_name">Last name <span class="text-danger">*</span></label>
                           <input id="billing_last_name" type="text" class="form-control border-mute rounded-0 bg-light text-left last_name" name="billing_last_name" value="{{ auth()->user()->last_name}}">
                        </div>
                     </div>
                     <div class="form-row">
                         <div class="col-md-6 form-group">
                           <label for="billing_email">Email address <span class="text-danger">*</span></label>
                           <input id="billing_email" type="email" class="form-control border-mute rounded-0 bg-light text-left email" name="billing_email" value="{{ auth()->user()->email}}">
                        </div>
                        <div class="col-md-6 form-group">
                           <label for="billing_phone">Phone <span class="text-danger">*</span></label>
                           <input id="billing_phone" type="tel" class="form-control border-mute rounded-0 bg-light text-left phone" name="billing_phone" value="{{ auth()->user()->phone_number}}">
                        </div>
                     </div>
                    <div class="form-row">
                     <div class="col-md-6 form-group">
                        <label for="billing_country">Country <span class="text-danger">*</span></label>
                        <select class="form-control bg-light border-mute rounded-0" id="billing_country" name="billing_country">
                           <option value="{{ auth()->user()->country}}">India</option>
                          @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>


                          @endforeach
                        </select>
                     </div>
                     <div class="col-md-6 form-group">
                           <label for="billing_postcode">Postal code <span class="text-danger">*</span></label>
                           <input id="billing_postcode" type="text" class="form-control border-mute rounded-0 bg-light text-left postcode" name="billing_postcode">
                      </div>
                    </div>
                     <div class="form-group">
                        <label for="billing_address_1">Street address <span class="text-danger">*</span></label>
                        <input id="billing_address_1" type="text" class="form-control border-mute rounded-0 bg-light text-left" name="billing_address_1" placeholder="House number and street name">
                        <input id="billing_address_2" type="text" class="form-control border-mute rounded-0 bg-light text-left mt-3" name="billing_address_2" placeholder="Apartment, suite, unite etc. (optional)">
                     </div>
                     
                    
                  </div>
               </form>
               <input type="hidden" name="delivery_address" value="1">
            
               
            </div>
         </div>
         <div class="card shadow-sm rounded-0 mt-4 additional-info mb-4">
            <div class="card-body">
               <h3 class="heading-primary text-uppercase">Additional information</h3>
               <div class="form-group">
                  
                  <textarea class="form-control border-mute rounded-0 bg-light " id="exampleFormControlTextarea1" rows="5" placeholder=""></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-5 your-order mb-5">
         @include('front.products.product-list-table', compact('products'))
         <div class="choose-payment mt-4 pt-1">
            <h3 class="font-weight-bold heading-primary text-uppercase">Choose your payment option</h3>
          <form action="{{ route('cash-transfer.index') }}" id="cash-on-del-method">

           
            <div class="input-group-text choose-payment-radio rounded-0 border-0 align-items-start">
              {{--  <input type="radio"  id="payment-cod" name="payment" aria-label="Radio button for following text input" value="cash">&nbsp;&nbsp;<label for="payment-cod" class="heading-primary font-weight-bold heading-primary font-weight-bold mr-auto"> Cash on delivery</label> --}}
            </div>
            

            <div class="input-group-text choose-payment-radio rounded-0 border-0 align-items-start mb-2">
               <input type="radio" id="payment-stripe" name="payment" aria-label="Radio button for following text input" value="stripe" checked="checked">&nbsp;&nbsp;<label for="payment-stripe" class="heading-primary font-weight-bold heading-primary font-weight-bold mr-auto"> Cash On Delivery</label>
            </div>
            <div class="choose-payment-details" style="display: none;">
           
               <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="">privacy policy</a> .</p>
            </div>
            <div class="proceed-to-checkout mt-4">
              
                  <input type="hidden" id="place-order-billing-address" class="address_id place-order-billing-address" name="billing_address">
                  <input type="hidden" id="place-order-shipping-address" class="delivery_address_id place-order-shipping-address" name="delivery_address">
                  <input type="hidden" class="rate" name="rate" >
                  <input type="hidden" class="payment" id="payId" name="payment" value="cash">
                  <input type="hidden" name="shipment_obj_id" >
                  <input type="hidden" id="eco_tax" name="taxx" >
                  <input type="hidden" id="newSub" name="newSub" >

                  <button type="button" class="br-50 btn checkout-button text-white w-100 mb-4 rounded-0 font-weight-bold pt-3 pb-3 btn-primary" onclick="submit_address();" id="cash">PLACE ORDER</button>
              
 
            </div>
             </form>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')
<script type="text/javascript">

$(document).ready(function() {

var radioValue = $("input[name='payment']:checked").val();
console.log('radioValue',radioValue);
if (radioValue == 'stripe') {
        $('.choose-payment-details').show();
        //$('#cash').hide();
        $('#payId').val(radioValue);
        $('#paywithstripe').show();
    } else {
        $('.choose-payment-details').hide();
        $('#cash').show();
        $('#payId').val(radioValue);
        // $('#paywithstripe').hide();
    }
  localStorage.removeItem("__bCart");
    let courierRadioBtn = $('input[name="rate"]');
    courierRadioBtn.click(function() {
        $('#shippingFee').text($(this).data('fee'));
        let totalElement = $('span#grandTotal');
        let shippingFee = $(this).data('fee');
        let total = totalElement.data('total');
        let grandTotal = parseFloat(shippingFee) + parseFloat(total);
        totalElement.html(grandTotal.toFixed(2));
    });
});

$(document).ready(function(){
  var a = $('input[name="eco_tax"]').val();
  $('#eco_tax').attr('value',a);
})

$(document).ready(function(){
  var a = $('input[name="newSub"]').val();
  $('#newSub').attr('value',a);
})


/*====== Select payment method start================*/
$("input[type='radio']").click(function() {
    var radioValue = $("input[name='payment']:checked").val();
    console.log('radioValue', radioValue);
    if (radioValue == 'stripe') {
        $('.choose-payment-details').show();
        //$('#cash').hide();
        $('#payId').val(radioValue);
        $('#paywithstripe').show();
    } else {
        $('.choose-payment-details').hide();
        $('#cash').show();
        $('#payId').val(radioValue);
        // $('#paywithstripe').hide();
    }

});
/*====== Select payment method end================*/


/*====== change billing address start================*/
$('#billing_address_id').change(function() {
    var address_Select = $('#billing_address_id').val();
    console.log('address_Select', address_Select);
    $('.error-form-validation ').remove();
    if (address_Select == '' || address_Select == null) {
        alert('Please select address');
        $('.billing_show_form').css('display', 'none');
    } else if (address_Select == '0') {
        $('.billing_show_form').css('display', 'block');
        document.getElementById('billingAddress').reset();
        $(this).val(0);
    } else {
        var text = $('option:selected', this).text(); //to get selected text
        var url = '{{ route("checkout.address", ":id") }}';
        url = url.replace(':id', $(this).val());
        console.log(url);
        var html = "";
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(data) {

                var id = data.data.id;
                var country_id = data.data.country_id;
                var address_1 = data.data.address_1;
                var address_2 = data.data.address_2;
                var first_name = data.data.first_name;
                var last_name = data.data.last_name;
                var company_name = data.data.company_name;
                var email = data.data.email;
                var phone = data.data.phone;
                var city = data.data.city;
                var postcode = data.data.zip;
                var shipping_price = data.data.shipping_price;
                // console.log('shipping_price',shipping_price);
                if(shipping_price!=undefined){
                  
                      var i;
                     
                       $.each(shipping_price, function( key, value ) {
                           var shipping_data=value.split(":");
                           // console.log('shipping_name',shipping_data[0]);
                            $('.shipping_details').append();
                            $('.shipping_details').append('<label> <input type="radio" id="shipping_radio" class="shipping_radio" name="shipping" value="'+shipping_data[1]+'"><span> '+shipping_data[0]+' Shipping Price : '+shipping_data[1]+' </span></label>');
                            $('.shipping_details_tr ').css('display','block');                            

                        });

                       var shipping = document.getElementsByName('shipping');
                       // console.log('shipping',shipping.length);
                       
                        $("input[type='radio']").click(function() {
                         var radioValue = $("input[name='shipping']:checked").val();
                         console.log('shippingValue', radioValue);
                         var price=radioValue.split(":");
                         console.log('ship price',price);
                         var shipping=$('.shipping_total').text();
                         console.log('shipping',shipping);
                         var total_ship=radioValue+shipping;
                         console.log('total_ship',total_ship);
                         var shipping_total_amount=$('#shipping_total_amount_actual').text();
                         console.log('shipping_total_amount',shipping_total_amount);

                         if(shipping_total_amount!=0){
                            console.log('1');
                            console.log('total_ship',total_ship);
                            console.log('shipping_total_amount',shipping_total_amount);
                            $("shipping_total_amount").text('');
                           var total_shipment=parseFloat(total_ship)+parseFloat(shipping_total_amount);
                            $('#shipping_total_amount').text(total_shipment.toFixed(2));
                         }else{
                            console.log('2');
                            $('#shipping_total_amount').text(parseFloat(total_ship.toFixed(2)));
                         
                         }
                        
                        var subtotal=$('#subtotal').text();
                         console.log('subtotal',subtotal);
                         var shipping_total_amount=$('#shipping_total_amount').text();
                         var eco_tax=$('.eco_tax').text();
                         var total_amount_get=parseFloat(subtotal) + parseFloat(shipping_total_amount) + parseFloat(eco_tax);
                        var total_amount=total_amount_get.toFixed(2);
                        console.log('total_amount',total_amount);
                         var obj = {
                           subtotal,
                           shipping_total_amount,
                           eco_tax,
                           total_amount
                         }
                         localStorage.setItem('__bCart', JSON.stringify(obj));
                          $('#total_amount').text('');
                         $('#total_amount').text(total_amount);
                     });
                   

                }else{
                    var subtotal=$('#subtotal').text();
                         console.log('subtotal',subtotal);
                         var shipping_total_amount=$('#shipping_total_amount').text();
                         var eco_tax=$('.eco_tax').text();
                         var total_amount_get=parseFloat(subtotal) + parseFloat(shipping_total_amount) + parseFloat(eco_tax);
                        var total_amount=total_amount_get.toFixed(2);
                        console.log('total_amount',total_amount);
                         var obj = {
                           subtotal,
                           shipping_total_amount,
                           eco_tax,
                           total_amount
                         }
                         localStorage.setItem('__bCart', JSON.stringify(obj));
                          $('#total_amount').text('');
                         $('#total_amount').text(total_amount);

                     $('.shipping_details').empty();
                     $('.shipping_details_tr').hide();
                }
                
                $('.shipping_price').text(shipping_price);
                
                $('.billing_show_form').css('display', 'block');
                $('.place-order-billing-address').val(id);
                if($('#sameDeliveryAddress').is(':checked')){
                  $('.place-order-shipping-address').val(id);
                }
                $('#billing_first_name').val(first_name);
                $('#billing_last_name').val(last_name);
                $('#billing_company_name').val(company_name);
                $('#billing_address_1').val(address_1);
                $('#billing_address_2').val(address_2);
                $('#billing_country').val(country_id);;
                $('#billing_city').val(city);
                $('#billing_email').val(email);
                $('#billing_phone').val(phone);
                $('#billing_postcode').val(postcode);
            }
        });
    }
});
/*====== change billing address end================*/

/*====== change shipping address start================*/
$(document).on('click', '#sameDeliveryAddress', function(){
  $('.error-form-validation ').remove();
  if($(this).is(':checked')){
    $('#shippingDeliveryAddressRow').fadeOut();
  }else{
    $('#shippingDeliveryAddressRow').fadeIn();
  }

});

$('#shipping_address_id').on('change', function() {
    var address_Select = $('#shipping_address_id').val();
    console.log('Shipping address select', address_Select);
    $('.error-form-validation ').remove();
    if (address_Select == '' || address_Select == null) {
        alert('Please select address');
        $('.shipping_show_form').css('display', 'none');
    } else if (address_Select == '0') {
        $('.shipping_show_form').css('display', 'block');
        document.getElementById('shippingDeliveryAddressRow').reset();
        $(this).val(0);
    } else {
        var text = $('option:selected', this).text(); //to get selected text
        var url = '{{ route("checkout.address", ":id") }}';
        url = url.replace(':id', $(this).val());
        console.log(url);
        var html = "";
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data);
                var id = data.data.id;
                var country_id = data.data.country_id;
                var address_1 = data.data.address_1;
                var address_2 = data.data.address_2;
                var first_name = data.data.first_name;
                var last_name = data.data.last_name;
                var company_name = data.data.company_name;
                var email = data.data.email;
                var phone = data.data.phone;
                var city = data.data.city;
                var postcode = data.data.zip;
                $('.shipping_show_form').css('display', 'block');
                $('.place-order-shipping-address').val(id);
                $('#shipping_first_name').val(first_name);
                $('#shipping_last_name').val(last_name);
                $('#shipping_company_name').val(company_name);
                $('#shipping_address_1').val(address_1);
                $('#shipping_address_2').val(address_2);
                $('#shipping_country').val(country_id);;
                $('#shipping_city').val(city);
                $('#shipping_email').val(email);
                $('#shipping_phone').val(phone);
                $('#shipping_postcode').val(postcode);
            }
        });
    }
});
/*====== change shipping address end================*/

/*====== shipping and billing address form validation start================*/
function submit_address() {

 
 console.log('fsf',$('.shipping_radio').length);
 if($('.shipping_radio').length!=0){
   if ($(".shipping_radio").is(':checked')) {
    var billing_request  = $('form#billingAddress').serialize();
    
    var shipping_request = $('form#shippingDeliveryAddressRow').serialize();
    var sameAddree = $('#sameDeliveryAddress').is(':checked') ? $('#sameDeliveryAddress').val() : 0;
    console.log('billing_request', billing_request);
    console.log('shipping_request', shipping_request);
    console.log('sameAddree', sameAddree);
    var error = 0;
    $('.error-form-validation ').remove();

    if($('#billing_address_id').val() != ''){
      $('#billingAddress input').each(function() {
        if($(this).attr("id") !== 'billing_company_name' &&  $(this).attr("id") !== 'billing_address_2'){
          if($(this).val() == ''){
            $(this).after('<small class="error-form-validation form-text text-danger">This field is required</small>')
            error++;
          }else{
            if($(this).attr("id") == 'billing_email'){
              if( !validateEmail( $(this).val() ) ){
                $(this).after('<small class="error-form-validation form-text text-danger">Invalid email address</small>')
                error++;
              }
            }
            if($(this).attr("id") == 'billing_phone'){
              if( !validateNumber( $(this).val() ) ){
                $(this).after('<small class="error-form-validation form-text text-danger">Invalid phone number</small>')
                error++;
              }
            }
          }
        }
      });
    }

    if(!$('#sameDeliveryAddress').is(':checked')){
      $('#shippingDeliveryAddressRow input').each(function() {
        if($(this).attr("id") !== 'shipping_company_name' &&  $(this).attr("id") !== 'shipping_address_2'){
          if($(this).val() == ''){
            $(this).after('<span class="error-form-validation text-danger">This field is required</span>')
            error++;
          }
        }else{
          if($(this).attr("id") == 'shipping_email'){
            if( !validateEmail( $(this).val() ) ){
              $(this).after('<span class="error-form-validation text-danger">Invalid email address</span>')
              error++;
            }
          }
          if($(this).attr("id") == 'shipping_phone'){
            if( !validateNumber( $(this).val() ) ){
              $(this).after('<span class="error-form-validation text-danger">Invalid phone number</span>')
              error++;
            }
          }
        }
      });
    }
    if(error != 0){
      return false;
    }
    var url = '{{ route("checkout.add_address") }}';
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'put',
            billing_request: billing_request,
            shipping_request: shipping_request,
            sameAddree: sameAddree,

        },
        success: function(data) {
            console.log(data);
            console.log(data.billing_id);
            console.log(data.shipping_id);
            var shipping_id = data.shipping_id > 0? data.shipping_id :data.billing_id;
            $('.place-order-billing-address').val(data.billing_id);
            $('.place-order-shipping-address').val(shipping_id);
            $('#cash-on-del-method').submit();
        }
    });
  }else{
    console.log('shipping2');

     alert('Please select shipping values');
         return false;
  }
}else{
  var billing_request  = $('form#billingAddress').serialize();
    var shipping_request = $('form#shippingDeliveryAddressRow').serialize();
    var sameAddree = $('#sameDeliveryAddress').is(':checked') ? $('#sameDeliveryAddress').val() : 0;
    console.log('billing_request', billing_request);
    console.log('shipping_request', shipping_request);
    console.log('sameAddree', sameAddree);
    var error = 0;
    $('.error-form-validation ').remove();

    if($('#billing_address_id').val() != ''){
      $('#billingAddress input').each(function() {
        if($(this).attr("id") !== 'billing_company_name' &&  $(this).attr("id") !== 'billing_address_2'){
          if($(this).val() == ''){
            $(this).after('<small class="error-form-validation form-text text-danger">This field is required</small>')
            error++;
          }else{
            if($(this).attr("id") == 'billing_email'){
              if( !validateEmail( $(this).val() ) ){
                $(this).after('<small class="error-form-validation form-text text-danger">Invalid email address</small>')
                error++;
              }
            }
            if($(this).attr("id") == 'billing_phone'){
              if( !validateNumber( $(this).val() ) ){
                $(this).after('<small class="error-form-validation form-text text-danger">Invalid phone number</small>')
                error++;
              }
            }
          }
        }
      });
    }

    if(!$('#sameDeliveryAddress').is(':checked')){
      $('#shippingDeliveryAddressRow input').each(function() {
        if($(this).attr("id") !== 'shipping_company_name' &&  $(this).attr("id") !== 'shipping_address_2'){
          if($(this).val() == ''){
            $(this).after('<span class="error-form-validation text-danger">This field is required</span>')
            error++;
          }
        }else{
          if($(this).attr("id") == 'shipping_email'){
            if( !validateEmail( $(this).val() ) ){
              $(this).after('<span class="error-form-validation text-danger">Invalid email address</span>')
              error++;
            }
          }
          if($(this).attr("id") == 'shipping_phone'){
            if( !validateNumber( $(this).val() ) ){
              $(this).after('<span class="error-form-validation text-danger">Invalid phone number</span>')
              error++;
            }
          }
        }
      });
    }
    if(error != 0){
      return false;
    }
    var url = '{{ route("checkout.add_address") }}';
    console.log(url);
    $.ajax({
        url: url,
        type: "GET",
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'put',
            billing_request: billing_request,
            shipping_request: shipping_request,
            sameAddree: sameAddree,

        },
        success: function(data) {
            console.log(data);
            console.log(data.billing_id);
            console.log(data.shipping_id);
            var shipping_id = data.shipping_id > 0? data.shipping_id :data.billing_id;
            $('.place-order-billing-address').val(data.billing_id);
            $('.place-order-shipping-address').val(shipping_id);
            $('#cash-on-del-method').submit();
        }
    });
}


   
}


/*====== shipping and billing address form validation end================*/

function setTotal(total, shippingCost) {
    let computed = +shippingCost + parseFloat(total);
    $('#total').html(computed.toFixed(2));
}

function setShippingFee(cost) {
    el = '#shippingFee';
    $(el).html(cost);
    $('#shippingFeeC').val(cost);
}

function setCourierDetails(courierId) {
    $('.courier_id').val(courierId);
}

function setTotal(total, shippingCost) {
    let computed = +shippingCost + parseFloat(total);
    $('#total').html(computed.toFixed(2));
}

$(document).ready(function() {

  $('#paywithstripe').hide();
  let clicked = false;

  let billingAddress = 'input[name="billing_address"]';
  $(billingAddress).on('change', function() {
      let chosenAddressId = $(this).val();

      $('.address_id').val(chosenAddressId);
      $('.delivery_address_id').val(chosenAddressId);

  });

  let deliveryAddress = 'input[name="delivery_address"]';
  $(deliveryAddress).on('change', function() {
      let chosenDeliveryAddressId = $(this).val();
      $('.delivery_address_id').val(chosenDeliveryAddressId);
  });

  let courier = 'input[name="courier"]';
  $(courier).on('change', function() {
      let shippingCost = $(this).data('cost');
      let total = $('#total').data('total');
      setCourierDetails($(this).val());
      setShippingFee(shippingCost);
      setTotal(total, shippingCost);
  });

  if ($(courier).is(':checked')) {
      let shippingCost = $(courier + ':checked').data('cost');
      let courierId = $(courier + ':checked').val();
      let total = $('#total').data('total');

      setShippingFee(shippingCost);
      setCourierDetails(courierId);
      setTotal(total, shippingCost);
  }
});    
</script>
@endsection