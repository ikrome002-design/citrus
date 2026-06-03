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
  <div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">Shop Products </h2>
       <div class="row">
          <div class="col-md-4">
            </div>
             <div class="col-md-4" >
                 <input type="text" name="search" id="search" class="form-control" placeholder="Search Products" />
            </div>
            <div class="col-md-4">
            </div>
            </div><br>
    </div>
  </div>
  <div class="container">
    @include('layouts.errors-and-messages')

    <div class="row">
             <div class="col-md-4" >
            </div>

             <div class="col-md-6" >
            </div>
             <div class="col-md-2" id="ranges">
      
              <select class="form-control" name="range" id="range">
                   <option value="">Sort By: Price </option>
                   <option value="desc">High To Low</option>
                   <option value="asc">Low To High</option>
                  
              </select>

            </div>
            </div><br>
       
         <div class="row" id="shop_data">

      @foreach($products as $product)
        <div class="col-md-3 col-sm-6">
            <div class="product-grid">
                <div class="product-image">
                    <a href="#">
                        
                        <img class="pic-1" src="@if(!empty($product->cover)){{ asset('storage/'.$product->cover) }}@else{{ asset('images/placeholder-square.png') }}@endif" style="height:200px;">
                        <img class="pic-2" src="@if(!empty($product->cover)){{ asset('storage/'.$product->cover) }}@else{{ asset('images/placeholder-square.png') }}@endif" >
                    </a>
                    <ul class="social">
                        <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                        <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                        <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                   <!--  <span class="product-new-label">Sale</span>
                    <span class="product-discount-label">20%</span> -->
                </div>
                <ul class="rating">
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star disable"></li>
                </ul>
                <div class="product-content">
                    <h3 class="title"><a href="#">{{$product->name}}</a></h3>
                    <div class="price">${{$product->sale_price}}
                        <span>${{$product->price}}</span>
                    </div>
                    <a class="add-to-cart" href="">Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach
     
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
  var img_url=window.location.href.split('/')[2];
  var shop_id=window.location.href.split('/')[5];
  var id=window.location.href.split('/')[5];
  
  $.ajax({
   url:url+'/'+'search',
   method:'GET',
   data:{query:query,img_url:img_url,shop_id:shop_id,type:type},
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
  
  $("#ranges").find("select").prop("selectedIndex",0);
  fetch_shop_data(query,type);
 });


$(document).on('click', '#range', function(){
  var query =$(this).val();
  var type = 'range';
  $('input[name=search').val('');
  
  fetch_shop_data(query,type);
 });



});
</script>
@endsection