@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="shop"/>
    <meta property="og:title" content="shop"/>
    <meta property="og:description" content="All Vendors"/>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <div class="breadcrumb">
        <div class="container">
        <ol class="container breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vendors</li>
        </ol>
    </div>
    </div>
</nav>
<div class="product_list_main">
<div class="container ">
     <h2>All Vendors</h2>
    <div class="row">
       
        <div class="col-xl-12 col-lg-12 right_list_box">
            <div id="products-list" class="all-vendor-box">
<?php //echo "<pre>"; print_r($vendors);die(); ?>
@if(!empty($vendors) )
    <ul class="d-flex list-unstyled flex-wrap">
        @foreach($vendors as $value)
            <li class="col-lg-20 col-md-4 col-sm-6 col-xs-12 product-list p-1">
                <div class="single-product">
                    <div class="product-wrap p-0 border-1 pb-3">
                        <figure>
                            @if(isset($value->avatar) &&  asset("$value->avatar") !=  asset("storage") )
                                <img src="{{ asset("storage/profile/vendors/$value->id/$value->avatar") }}" alt="{{ $value->name }}" class="product-img img-fluid p-0">

                            @else
                                <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $value->name }}" class="product-img p-0 img-fluid p-0" />
                            @endif
                        </figure>
                        <div class="px-3">
                            <h2 class="product-tittle" data-placement="bottom" data-toggle="tooltip" title="{{ $value->name }}"> <a class="Vendor-name text-center text-uppercase text-black" href="{{ route('shop.vendor-details', $value-> id) }}">{{ $value->name }}</h2></a>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    
@endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')

@endsection
