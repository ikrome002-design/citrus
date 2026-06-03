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
    $('.table').DataTable({
        'info' : false,
        'paging' : false,
        'searching' : false,
        'columnDefs' : [
            {
                'orderable': false, 'targets' : -1
            }
        ],
        'sorting' : []
    });
});

$(document).ready(function() {
    table = $('#table-pagination-search').dataTable( {
        paging: true,
        "bDestroy": true
    } );
} );

$(document).ready( function () {
    $('#myTable').DataTable();
} );

// Staff edit js
function staffData(staff){
    console.log(staff);
    var html, staff_image, staff_name, staff_email, staff_phone, staff_status, staff_bio, staff_edit, staff_delete;
    if(staff.avatar !=null){         
        staff_image = '<img class="rounded float-left img-fluid" src="/storage/profile/users/'+staff.id+'/'+staff.avatar+'" alt="'+staff.name+'">'; 
    }else{
      staff_image = '<img class="rounded float-left img-fluid" src="/images/dummy-user.png" alt="'+staff.name+'">';
    }
    staff_name = '<h4 class="text-primary">'+staff.name+'</h4>';
    
    if(staff.status == 1){
       staff_status = '<p>Status: <button href="" class="btn btn-outline-success btn-sm rounded-pill"> Active</button></p>';
    }else{
       staff_status = '<p>Status: <button href="" class="btn btn-outline-danger btn-sm rounded-pill"> Inactive</button>';
    }

    staff_bio = '<p>'+staff.bio+'</p>';

    staff_email = '<p class="mb-1"><i class="fa fa-envelope text-success mr-3"></i> '+staff.email+'</p>';

    staff_phone = '<p><i class="fa fa-phone text-success mr-3"></i> '+staff.phone+'</p>';

    staff_edit = '<a class="btn btn-success " href="/admin/staffs/'+staff.id+'/edit"><i class="fa fa-edit"></i> Edit</a>';

    staff_delete = '<a class="btn vendor-product-bt btn-danger staff-delete " staff-delete-id="'+staff.id+'" href="javascript:void(0)" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-edit"></i> Delete</a>';

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
if (ctx_bar_1) {
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
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Monthly Sale",
          data: [10, 75, 81, 100, 55, 40, 50, 75, 81, 100, 50, 80],
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
var CategorySale = new Chart(ctx_pie_1, {
  type: 'doughnut',
  data: {
    labels: ["Cloths", "Natural", "Fashion"],
    datasets: [{
      data: [14, 20, 49],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
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
  }else{
    $('#product-wlwh').fadeIn();
  }
});
$(document).ready(function(){
  if ($('#FlatRate').is(':checked')) {
    $('#product-wlwh').fadeOut();
  }else{
    $('#product-wlwh').fadeIn();
  }
});

// $(document).on('click', '#freeShippng', function(){
$("#freeShippng").click(function()
{
  $("#FlatRate").prop('checked',false);
  $(this).prop('checked',true);
});