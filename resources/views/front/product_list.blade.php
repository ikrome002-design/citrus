	@extends('layouts.front.app')
@section('content')
    <!-- Main content -->
   <style type="text/css">
     .product-grid .social li button{
    color: #fff;
    background-color: #333;
    border-color: #333;
  }

    .product-grid .social li button:hover{
    color: #fff;
    background-color: #ef5777;
    border-color: #ef5777;
  }
   </style>

<section class="content">
  <div class="row my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center mb-3 text-white">Shop Products </h2>
       <div class="row">
          <div class="col-md-4">
            </div>
             <div class="col-md-4" >
                 <input type="text" name="search" id="search" class="form-control" placeholder="Search Products" />
            </div>
            <div class="col-md-4">
            </div>
            </div>
        </div>
      </div>
</section>
<section class="pt-5">
<div class="container">
    @include('layouts.errors-and-messages')
<div class="shopList_filter">
    <div class="row">
         <div class="col-md-4">
                  <div class="citrus-AccountBox">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Go Live
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-dashboard']) }}">Dashboard</a>
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-account-details']) }}">Account Details</a>
                          <a class="dropdown-item" href="{{ route('shop.listing') }}">Shop</a>
                          <a class="dropdown-item" href="{{ route('accounts', ['tab' =>'v-pills-my-order']) }}">My Orders</a>
                          <a class="dropdown-item" href="{{ route('wishlist_detail') }}">Wishlist</a>
                          <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                      </div>
                  </div>
                </div>
         <div class="col-md-4" id="merchant">
           <select class="form-control" name="merchant_search" id="merchant_search">
               <option value="">Sort By: recommended</option>
               <option value="asc">A To Z</option>
               <option value="desc">Z To A</option>
          </select>
        </div>
         <div class="col-md-4" id="ranges">
          <select class="form-control" name="range" id="range">
               <option value="">Sort By: Price </option>
               <option value="desc">High To Low</option>
               <option value="asc">Low To High</option>
          </select>
        </div>
    </div>
</div>
    
     <p id="myElem" class="alert alert-success alert-dismissible" style="display:none"></p>
     <p id="myElem1" class="alert alert-danger alert-dismissible" style="display:none"></p>
         <div class="row" id="shop_data">
        </div>	
</div>
</section>
    <!-- /.content -->
@endsection
@section('js')

<script> 
    
    $(document).on('click', '.product-wishlist-btn', function(){
        var prod_id = $(this).attr('product-id');
        var uId = $("#uId").val();
        var url = '{{ route("wishlist.save") }}';
        $.ajax({
            url: url,
            type: "POST",
            data: {
              _token: '{{ csrf_token() }}',
              uId:uId,
              prod_id:prod_id 
            },
            success: function(data) {
              
               if(data==1){
                $("#myElem1").hide();
                $("#myElem").show();
               setTimeout(function() { $("#myElem").hide(); }, 3000);
                    $("#myElem").text('Product added in wishlist ');

              
                }else if(data==2){
                  $("#myElem").hide();
                  $("#myElem1").show();
               setTimeout(function() { $("#myElem1").hide(); }, 3000);
                    $("#myElem1").text('Product already added in wishlist ');
                  
                   
                }else if(data==0){
                    $("#notMsg").text('Please login first !  ');
                }
            }
        });        
    });
</script>
 <script type="text/javascript">
$(document).ready(function(){

 fetch_shop_data();

 function fetch_shop_data(query = '',type = '')
 {
  var url = window.location;
  var shop_id=window.location.href.split('/')[5];
  //alert(shop_id);
  
  
  $.ajax({
   url:url+'/'+'search',
   method:'GET',
   data:{query:query,shop_id:shop_id,type:type},
   dataType:'json',
   success:function(data)
   { 

    $('#shop_data').empty();
    $('#shop_data').html(data.table_data);
    $('#total_records').text(data.total_data);
                  
    
   },error: function(data){
        console.log(data);
    }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  var type = 'search';
  $("#merchant").find("select").prop("selectedIndex",0);
  $("#ranges").find("select").prop("selectedIndex",0);
  fetch_shop_data(query,type);
 });

$(document).on('click', '#merchant_search', function(){
  var query =$(this).val();
  var type = 'merchant';
  $('input[name=search').val('');
  $("#ranges").find("select").prop("selectedIndex",0);
  fetch_shop_data(query,type);
 });

$(document).on('click', '#range', function(){
  var query =$(this).val();
  var type = 'range';
  $("#merchant").find("select").prop("selectedIndex",0);
  $('input[name=search').val('');
  
  fetch_shop_data(query,type);
 });



});
</script>

@endsection