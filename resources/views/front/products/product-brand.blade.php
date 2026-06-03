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
        <ol class="container breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
<script type="text/javascript">


    function commonFilter(){
        var product_from    = $('#product-pagination li.active').attr("page-no");
        var sort            = $('#product-sort-form-field').val();
        var url             = '{{ route("brand.filter", $slug) }}';
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
