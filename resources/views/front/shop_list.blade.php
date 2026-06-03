@extends('layouts.front.app')
@section('content')
    <!-- Main content -->
   <style type="text/css">
     section.ShopList_product_row {
        background: #f2f2f2;
      }
   </style>
<section class="content">
  <div class="row my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center mb-3 text-white">Merchant Shops </h2>
       <div class="row">
          <div class="col-md-4">
            </div>
             <div class="col-md-4" >
                 <input type="text" name="search" id="search" class="form-control" placeholder="Search Shop" />
            </div>
            <div class="col-md-4">
            </div>
            </div>
        </div>
      </div>
</section>
<section class="ShopList_product_row pt-5">      
  <div class="container">
    @include('layouts.errors-and-messages')
         <div class="row  ">
          <div class="col-md-12">
            <div class="shopList_filter">
              <div class="row align-items-center">
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
                          <option value="">Select Business Type</option>
                          @foreach($merchants as $merchant)
                          <option value="{{$merchant->id}}">{{$merchant->title}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-4" id="ranges">
                      <select class="form-control" name="range" id="range">
                          <option value="">Select Popularity</option>
                          <option value="desc">Latest</option>
                          <option value="asc">Oldest</option>
                      </select>
                  </div>
              </div>
            </div>
            <div class="staff-box-wrapper citrus-product-wrapper" id="shop_data">
            </div>
          </div>
        
    </div><br>
</div>
</section>
    <!-- /.content -->
@endsection
@section('js')
 <script type="text/javascript">
$(document).ready(function(){

 fetch_shop_data();

 function fetch_shop_data(query = '',type = '')
 {
  var url = window.location;
  var img_url=window.location.href.split('/')[1];
  $.ajax({
   url:"{{ route('shop.action') }}",
   method:'GET',
   data:{query:query,img_url:img_url,type:type},
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
  $('input[name=search').val('');
  $("#merchant").find("select").prop("selectedIndex",0);
  fetch_shop_data(query,type);
 });



});
</script>
@endsection