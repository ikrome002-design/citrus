@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="shop"/>
    <meta property="og:title" content="shop"/>
    <meta property="og:description" content="All Products"/>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <div class="breadcrumb">
    <div class="container">
        <ol class=" breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">  Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop</li>
        </ol>

    </div>
     </div>
</nav>
  <div class="product_list_main">
<div class="container ">
    <div class="row">
        <div class="col-xl-3 col-lg-3 left_list_box">
            @include('front.categories.sidebar-filter')
         </div>
        <div class="col-xl-9 col-lg-9 right_list_box">
            <div id="products-list">
                @include('front.products.product-list', ['products' => $products])
            </div>
        </div>
    </div>
</div>
</div>
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
                    $("#notMsg").text('Product added in wishlist ');
                }else if(data==2){
                   $("#notMsg").text('Product removed from wishlist ');
                }else if(data==0){
                    $("#notMsg").text('Please login first !  ');
                }
            }
        });        
    });
</script>
<script type="text/javascript">

    function commonFilter(){
        var product_from    = $('#product-pagination li.active').attr("page-no");
        var sort            = $('#product-sort-form-field').val();
        var url             = '{{ route("shop.filter") }}';
        var price_from      = $('input[name="price-filter"]:checked').val();
        var price_to        = $('input[name="price-filter"]:checked').attr("max-price");
        var values = [];
        $("input[name='vendors[]']:checked").each(function() {
            values.push($(this).val());
        });

        var vendors         = values;

        filterProduct(url, product_from, sort, price_from, price_to, vendors)
    }
</script>
@endsection
