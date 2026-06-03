$(document).ready(function () {
    $("#brand-logo").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        items: 6,
        itemsDesktop: [1199, 6],
        itemsDesktopSmall: [979, 6]
    });

    $('.select2').select2();

    if ($('#thumbnails li img').length > 0) {
        $('#thumbnails li img').on('click', function () {
            $('#main-image')
                .attr('src', $(this).attr('src') +'?w=400')
                .attr('data-zoom', $(this).attr('src') +'?w=1200');
        });
    }

    $(".img-orderDetail").mouseover(function() {
      $(this).css({ width: '150px', height: '150px' });
    }).mouseout(function() {
      $(".img-orderDetail").css({ width: '50px', height: '50px'});
    });

     //add to wishlist
    $( ".product-wishlist-btn" ).each(function() {
    $(this).attr('product-id');
      var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
      var uId = $("#uId").val();
      if(uId==true){
          if(wishlist_product){
              var index = wishlist_product.indexOf($(this).attr('product-id'));
              if(index >= 0){
                  $(this).removeClass('add-to-wishlist-btn');
                  $(this).addClass('remove-to-wishlist-btn');
                  $(this).html('<i class="fa fa-heart">');
              }
          }
        }
      });

    $(document).on('click', '.product-wishlist-btn', function(){
        var uId = $("#uId").val();
        if(uId==true){
            if($(this).hasClass( 'add-to-wishlist-btn' )){

                var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
                var wishlist_productLenght;
                var wishlist_product_id;
                if (wishlist_product) {
                    wishlist_product_id = wishlist_product;
                    wishlist_productLenght = wishlist_product.length;
                }else{
                    wishlist_product_id = [];
                    wishlist_productLenght = 0;
                }
                wishlist_product_id[wishlist_productLenght] = $(this).attr('product-id');
                localStorage.setItem("wishlist_product_id", JSON.stringify(wishlist_product_id));
                $(this).removeClass('add-to-wishlist-btn');
                $(this).addClass('remove-to-wishlist-btn');
                $(this).html('<i class="fa fa-heart">');

            }else if($(this).hasClass( 'remove-to-wishlist-btn' )){

                var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
                var deleteIndex = wishlist_product.indexOf($(this).attr('product-id'));
                if(deleteIndex){
                    wishlist_product.splice(deleteIndex, 1);
                }
                localStorage.setItem("wishlist_product_id", JSON.stringify(wishlist_product));
                $(this).addClass('add-to-wishlist-btn');
                $(this).removeClass('remove-to-wishlist-btn');
                $(this).html('<i class="fa fa-heart-o">');

            }
        }
    }); 

});
function myFunction(x) {
  x.classList.toggle("change");
}
$('#newproduct_and_services, .recent-products .owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        700:{
            items:2
        },
        768:{
            items:3
        },
        992:{
            items:4
        },
        1024:{
            items:4
        },
        1200:{
            items:5
        },
        1366:{
            nav:true,
            items:5
        },
        1800:{
            items:6
        }
    }
})

  $(document).ready(function () {
    jQuery("#content-slider").lightSlider({
        loop: true,
        keyPress: true,
    });
    jQuery("#image-gallery").lightSlider({
        gallery: true,
        item: 1,
        thumbItem: 9,
        slideMargin: 0,
        speed: 800,
        auto: false,
        loop: true,
        onSliderLoad: function () {
            jQuery("#image-gallery").removeClass("cS-hidden");
        },
    });
});



$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
  
});


$(document).ready(function(){
   
    $("select.front_search_rating").change(function(){

        var vendor_id=$(this).attr('vendor-id');
        console.log('vendor_id',vendor_id);
        var selectedCountry = $(this).children("option:selected").val();
        console.log('selectedCountry',selectedCountry);
        if(selectedCountry!= ''){
            $.ajax({
                type: "get",
                url: "/searchratings",
                data : { vendor_id:vendor_id,status : selectedCountry}
            }).done(function(response) {
                console.log('response',response);
                $('#vendor-reviews-list').html(response);
            });
        }else{
            alert('Please select type');
        }
        
       
    });

    $('.pagination li a').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(data) {
                $('#result').html(data);
            }
        });
    });


});
// function addRating(obj,id) {
//     console.log("id",id);
//     $("#rating").val(id);
// }

function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}

$(document).ready(function () {
    size_li = $("#vendor-reviews-list li").length;
    x=10;
    $('#vendor-reviews-list li').hide();
    $('#vendor-reviews-list li:lt('+x+')').show();
    $('#vendor-review-pagination li').click(function () {
        $("#vendor-review-pagination li").removeClass("active");
        $(this).addClass("active");
        var cout = Number($(this).attr("page-no"));
        $('#vendor-reviews-list li').hide();
        var y = $(this).attr("page-no")*x
        $('#vendor-reviews-list li').slice( y-x, y ).show();
    });
})

//upload avatar
$(document).on('change', '#fileUpload', function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
           $('#imgPrime').attr('src', e.target.result);
        }
       reader.readAsDataURL(input.files[0]);
    }
});

/* form validation start*/
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

function validateNumber($number) {
  var numberReg = /^([\d-]{7,16})?$/;
  return numberReg.test( $number );
}
/* form validation end */

/*|>>========== Product list filter =============<<|*/
function filterProduct(url, product_from, sort, price_from, price_to, vendors, categories, q){
    $.ajax({
        url: url,
        type: "GET",
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'put',
            product_from: product_from,
            sort: sort,
            price_from: price_from,
            price_to: price_to,
            vendors: vendors,
            categories: categories,
            q: q,
        },
        success: function(data) {

           $('#products-list').html(data);
        }
    });
}

function updatecustomPriceMin(val){
    console.log('updatecustomPriceMin',val);
    $('#customPriceMin').val(val);
    $('#customPriceMin').attr('min-price', val);
}
function updatecustomPriceMax(val){
     console.log('updatecustomPriceMax',val);
     $('#customPriceMax').val(val);
    $('#customPriceMax').attr('max-price', val);
}

// sidebar
$(document).on('click', '#jquery-accordion-menu span.submenu-indicator', function(e){
    e.preventDefault();
    e.stopPropagation();
});

$(document).on('change', '#product-sort-form-field, input[name="price-filter"]', function(){
    commonFilter();
});

$(document).on('click', '.filter-by-vendors input', function(){
    commonFilter();
});

$(document).on('click', '#product-pagination li', function(){
    $('#product-pagination li').removeClass('active');
    $(this).addClass('active');
    commonFilter();
});



/*|>>========== Vendor Registration form start =============<<|*/
$(document).on('change', '#selectPlanVariant', function(){
    if($(this).val()==1){
        $('#planVariantYearly').addClass('d-none');
        $('#planVariantMonthly').removeClass('d-none');
    }else{
        $('#planVariantMonthly').addClass('d-none');
        $('#planVariantYearly').removeClass('d-none');
    }
});

$(document).on('click', '#GoToStep1', function(){
    $('.register-form-step#step-2').removeClass('active');
    $('.register-form-step#step-1').addClass('active');
});

$(document).on('click', '#GoToStep2', function(){

    var error = 0;
    $('input, select, textarea').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.register-form-step#step-1 input, .register-form-step#step-1 textarea').each(function(){
        if($(this).val() == '' && !$(this).hasClass('terms_conditions')){
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">This field is required</div>');

            error++;
        }
    });

    if($('.is-invalid').length){
        $('html, body').animate({
            scrollTop: ($('.is-invalid').first().offset().top-30)
        },500);
    }


       var terms_conditions= $('input[name="terms_conditions"]').is(":checked");
       console.log('terms_conditions',terms_conditions);
       if(terms_conditions==null || terms_conditions==''){
            $('input[name="terms_conditions"]').val('0');
            $('.term_error').text('This field is required');
            return false;
       }else{
         $('.term_error').text('');
         $('input[name="terms_conditions"]').val('1');
         
       }
    
    if(error != 0){
        return false;
    }else{
        $('.register-form-step#step-1').removeClass('active');
        $('.register-form-step#step-2').addClass('active');
    }

});

$(document).on('click', '#GoToStep3', function(){
    var error = 0;
    $('input, select, textarea').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.register-form-step#step-2 input, .register-form-step#step-2 textarea').each(function(){

        if($(this).val() == ''  && !$(this).hasClass('gstCls')  && $(this).is(":visible")){
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">This field is required</div>');
            error++;
        }else{
            if($(this).hasClass('is-password') && $(this).val().length < 6 ){
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">The password must be at least 8 characters.</div>');
                error++;
            }
            if($(this).hasClass('is-email') && !validateEmail( $(this).val() ) ){
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Invalid email address</div>');
                error++;
            }
            if($(this).hasClass('is-number') && !validateNumber( $(this).val() ) ){
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Invalid number</div>');
                error++;
            }
            if($(this).hasClass('is-year') && ( $(this).val().length != 4 || !$.isNumeric($(this).val()) ) ){
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Invalid year</div>');
                error++;
            }   
        }
    });
    if($('.is-invalid').length){
        $('html, body').animate({
            scrollTop: ($('.is-invalid').first().offset().top-30)
        },500);
    }


    if(error != 0){
        return false;
    }else{
        $('#VendorRegisterForm').submit();
    }

});

$(document).on('click', '#BillingAddressSame', function(){
    if($(this).is(':checked')){
        $('#vendor-billing-address').fadeOut();
    }else{
        $('#vendor-billing-address').fadeIn();
    }
});
/*|>>========== Vendor Registration form end =============<<|*/

$(document).ready(function(){
    $(".product-wishlist-btn").click(function(){
        $("#notification-bar").addClass("active");
        setTimeout(function () {
         $("#notification-bar").removeClass("active");
        }, 2500);
    })
    $(".close-btn").click(function(){
        $("#notification-bar").removeClass("active");
    })

    $("#review_click").click(function(){
        $("#notification-bar").addClass("active");
        setTimeout(function () {
         $("#notification-bar").removeClass("active");
        }, 2500);
    })
    $(".close-btn").click(function(){
        $("#notification-bar").removeClass("active");
    })
})

function foremail(event){
    var email= $(event).val();
       if(email.length>0){
           $("#error_message").hide();
       }
}
$(document).on('click', '#Subscribe', function(){
       console.log(url);
       var email=$('.newsletter-input').val(); 
       console.log(email.length);
       var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
       if(email.length==0){
            $('#error_message').text('Please enter email');
            $('#error_message').css('display','block');
            return false;
       }else if(!emailReg.test(email)){
            $('#error_message').text('Please enter valid email');
            $('#error_message').css('display','block');
             return false;
        }
        
        $.ajax({
            url: url+'/newsletter',
            type: "POST",
            data: {
              _token: $('#token').val(),
                email:$('.newsletter-input').val() 
            },
            success: function(data) {
                console.log('response',data);
                if(data.status==true){
                    
                   // $("#Subscribe").click(function(){

                        $("#notification-bar").addClass("active");
                         $("#notMsg").text('Subscription successful!');
                         setTimeout(function () {
                           $("#notification-bar").removeClass("active");
                         }, 2000);
                    // })
                }
               
            }
        }); 
    });
$(document).ready(function(){
  $('#GoToStep2').click(function(){
    var a = $("input[name='own_by_vancouver']:checked").val();
    var b = $("input[name='head_office_vancouver']:checked").val();
    var c = $("input[name='local_community']:checked").val();
    if(a == 0 || b==0 || c==0){
      $("#notMsg").text('DO NOT QUALIFY');
      $("#notification-bar").addClass("active");
         setTimeout(function () {
           $("#notification-bar").removeClass("active");
         }, 2500);
      return false;
    }
  });
 });
    

