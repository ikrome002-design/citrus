$(document).ready(function () {
    $('#is_free').on('change', function () {
        console.log($(this).val());
        if ($(this).val() == 0) {
            $('#delivery_cost').fadeIn();
        } else {
            $('#delivery_cost').fadeOut();
        }
    });
    $('.select2').select2({
        placeholder: 'Select'
    });
});
//datatable
$(document).ready(function() {
  $('#dataTable').DataTable({
    paging: true,
  });
});
$(document).ready(function() {
  $('.dataTable').DataTable({
    paging: true,
  });
});

// Staff edit js
function staffData(staff){
    console.log(staff);
    var html, staff_image, staff_name, staff_email, staff_phone, staff_status, staff_bio, staff_edit, staff_delete;
    if(staff.avatar !=null){         
        staff_image = '<img class="rounded float-left img-fluid" src="/storage/profile/users/'+staff.id+'/'+staff.avatar+'" alt="'+staff.name+'">'; 
    }else{
        staff_image = '<img class="rounded float-left img-fluid" src="/images/dummy-user.png" alt="'+staff.name+'">';
    }
    staff_name = '<h4 class="card-title">'+staff.name+'</h4>';
    
    if(staff.status == 1){
       staff_status = '<p>Status: <button href="" class="btn btn-outline-success btn-sm rounded-pill"> Active</button></p>';
    }else{
       staff_status = '<p>Status: <button href="" class="btn btn-outline-danger btn-sm rounded-pill"> Inactive</button>';
    }

    staff_bio = '<p>'+staff.bio+'</p>';

    staff_email = '<p class="mb-1"><i class="fa fa-envelope text-success mr-3"></i> '+staff.email+'</p>';

    staff_phone = '<p><i class="fa fa-phone text-success mr-3"></i> '+staff.phone+'</p>';

    staff_edit = '<a class="btn btn-success mr-2" href="/admin/staffs/'+staff.id+'/edit">Edit</a>';

    staff_delete = '<a class="btn btn-danger staff-delete" staff-delete-id="'+staff.id+'" href="javascript:void(0)" onclick="return confirm(\'Are you sure?\')">Delete</a>';

    html = '<div class="col-md-3">'+staff_image+'</div><div class="col-md-9">'+staff_name+staff_status+staff_bio+'<h6>Contact Info:</h6>'+staff_email+staff_phone+'<p>'+staff_edit+staff_delete+'</p></div>';
    $('#staff-view-details').html(html);
    $('#ViewStaff').modal('show');
}

$(document).on('click', '.staff-delete', function(){
    var form_id = 'delete-staff-'+$(this).attr('staff-delete-id');
    $('form#'+form_id).submit();
});

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


$(document).ready(function(){
   
    $("select.search_rating").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        console.log('selectedCountry',selectedCountry);
        if(selectedCountry!= ''){
            $.ajax({
                type: "get",
                url: "/vendor/searchratings",
                data : { status : selectedCountry}
            }).done(function(response) {
                console.log('response',response);
                $('#myTable').html('');
                $('#myTable').html(response);
            });
        }else{
            alert('Please select type');
        }
        
       
    });
});
// product gallery
$(document).on('change', '.product-gallery-image input[type="file"]', function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();
        reader.onload = function (e) {
            if($(input).prev('img').length){
                $(input).prev('img').attr('src', e.target.result);
            }else{
                $(input).before('<img src="'+e.target.result+'" class="image-upload">')
                $(input).next('.add-image').remove(); 
                $(input).parent().parent().before('<span class="text-danger cursor-pointer" id="remove-image-gal"><i class="fa fa-times fa-2x"></i></span>');
                var count = Number($('.product-gallery-image > div:last').attr('image-field'))+1;
                var filed = '<div class="gallery-image-'+count+' text-center col-auto" image-field="'+count+'"><label for="product-gallery-'+count+'"><div class="border p-4 cursor-pointer"><input type="file" id="product-gallery-'+count+'" name="image[]" class="d-none" accept="image/x-png,image/gif,image/jpeg"><div class="add-image"><i class="fa fa-plus fa-2x"></i><p class="m-2">Add image</p></div></div></label></div>';
                $('.product-gallery-image > div:last').after(filed);
            }
        }
       reader.readAsDataURL(input.files[0]);
    }
});
$(document).on('click', '#remove-image-gal', function(){
    $(this).parent().remove();
});

$(document).on('change', '.product-gallery-image input[type="file"]', function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();
        reader.onload = function (e) {
            if($(input).prev('img').length){
                $(input).prev('img').attr('src', e.target.result);
            }else{
                $(input).before('<img src="'+e.target.result+'" class="image-upload">')
                $(input).next('.add-image').remove(); 
                $(input).parent().parent().before('<span class="text-danger cursor-pointer" id="remove-image-gal"><i class="fa fa-times fa-2x"></i></span>');
               var count = Number($('.product-gallery-image > div:last').attr('image-field'))+1;
                var filed = '<div class="gallery-image-'+count+' text-center col-auto"><label for="product-gallery-'+count+'"><div class="border p-4 cursor-pointer"><input type="file" id="product-gallery-'+count+'" name="image[]" class="d-none" accept="image/x-png,image/gif,image/jpeg"><div class="add-image"><i class="fa fa-plus fa-2x"></i><p class="m-2">Add image</p></div></div></label></div>';
                $('.product-gallery-image > div:last').after(filed);
            }
        }
       reader.readAsDataURL(input.files[0]);
    }
});
$(document).on('click', '#remove-image-gal', function(){
    $(this).parent().remove();
});



//chart
var ctx_bar_1 = document.getElementById("MonthReport");
   //alert(data); 
   //console.log(monthsArray);
   //console.log(res);

if (ctx_bar_1) {
   
  var monthdata = data.split(",");
  var res = monthsArray.split(",");
  var mq = window.matchMedia( "(max-width: 570px)" );
  if (mq.matches) {
    ctx_bar_1.height = 200;
  }
  else {
    ctx_bar_1.height = 130;
  }
  var MonthReport = new Chart(ctx_bar_1, {
    type: 'bar',
    data: {
      //labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      //labels: [monthsArray],
     labels: res,
      datasets: [
        {
          label: "Monthly Sale ",
          data: monthdata,
          //data: [10, 75, 81, 100, 55, 40, 50, 75, 81, 100, 50, 80],
          //data: [10.00,29.00],
          borderColor: "rgba(0, 123, 255, 0.9)",
          borderWidth: "0",
          backgroundColor: "rgba(0, 123, 255, 0.5)"
        }
      ]
    },
    options: {
      legend: {
        position: 'top',
        labels: {
          fontFamily: 'Nunito'
        }
      },
      scales: {
        xAxes: [{
          ticks: {
            fontFamily: "Nunito"
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            fontFamily: "Nunito"
          }
        }]
      }
    }
  });
}

//cateogy
var ctx_pie_1 = document.getElementById("CategorySale");
if (ctx_pie_1) {
var cat = categoryArray.split(",");
var sellprice = priceArray.split(",");
var CategorySale = new Chart(ctx_pie_1, {
  type: 'doughnut',
  data: {
    labels: cat,
    datasets: [{
      data: sellprice,
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#6610f2', '#e83e8c', '#fd7e14', '#ffc107', '#28a745', '#20c997', '#007bff', '#6c757d', '#ffc107', '#dc3545', '#007C07', '#00437c', '#74007c'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#6610f2', '#e83e8c', '#fd7e14', '#ffc107', '#28a745', '#20c997', '#007bff', '#6c757d', '#ffc107', '#dc3545', '#007C07', '#00437c', '#74007c'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true
    },
    cutoutPercentage: 80,
  },
});
}


//add product
$(document).on('click', '#FlatRate', function(){
  if ($(this).is(':checked')) {
    
    $('#product-wlwh').fadeOut();
    $('.flat_rate').fadeIn();
     
  }else{
      alert('here1');
    $('#product-wlwh').fadeIn();
    $('#Flatamount').fadeOut();
      
  }
});

$(document).on('click', '#freeShippng', function(){
  if ($(this).is(':checked')) {
   $('#product-wlwh').fadeOut();
     $('.flat_rate').hide();
     
  }else{
    $('#product-wlwh').fadeIn();
      
  }
});

$(document).on('click', '#dynamicShipping', function(){
  if ($(this).is(':checked')) {
   $('#product-wlwh').fadeIn();
    $('.flat_rate').hide();
    //window.location.href='https://sso-osu.canadapost-postescanada.ca/sso/pfe/ui/registration?stepupId=smb_mode1,commercial_link,smb_link&templateId=cpcapps&language=en&manifestId=bizSecurity&sourceUrl=https://www.canadapost.ca%2Fcpo%2Fmc%2Fbusiness%2Fproductsservices%2Fdevelopers%2Fservices%2Fgettingstarted.jsf&targetUrl=https://www.canadapost.ca%2Fcpotools%2Fapps%2Fdrc%2Fhome%3FforceVouchFor%3Dtrue#profile';
  }else{
    $('#product-wlwh').fadeIn();
      
  }
});

$(document).ready(function(){
  if($('#FlatRate').is(':checked')) {
    console.log('ki');
    $('#product-wlwh').fadeOut();
     $('.flat_rate').show();
    
  }


  if($('#freeShippng').is(':checked')) {
    console.log('i');
    $('#product-wlwh').fadeOut();
     $('.flat_rate').hide();
    
  }

  
});
$(document).on('click', 'input[name="product_type"]', function(){
  if($(this).val() == 'services'){
    $('#shipping-card').fadeOut();
  }else{
    $('#shipping-card').fadeIn();
  }
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
        if($(this).val() == '' && !$(this).hasClass('gstCls') && $(this).is(":visible")){
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">This field is required</div>');
            error++;
        }else{
            if($(this).hasClass('is-password') && $(this).val().length < 8 ){
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
    if( ($('.is-percentage').val() < 1 && $('.is-percentage').val() != '') || $('.is-percentage').val() > 100 || ( !$.isNumeric($('.is-percentage').val()) && $('.is-percentage').val() != '') ) {
        $('.is-percentage').addClass('is-invalid');
        $('.is-percentage').after('<div class="invalid-feedback">Invalid discount</div>');
        error++;
    }  
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
/* form validation start*/
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

function validateNumber($number) {
  var numberReg = /^([\d-]{7,16})?$/;
  return numberReg.test( $number );
}
/*|>>========== Vendor Registration form end =============<<|*/