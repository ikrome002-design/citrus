@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
<!-- home banner -->
@if($banner_contents)
<section class="home-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8 col-12 mb-5">
                @if($banner_contents)
                <div id="carouselBannerProductControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @php $i=0; @endphp
                    @foreach($banner_contents as $banner)
                        @if($banner->option == 1)
                            <div class="carousel-item {{ $i==0 ?'active':'' }}">
                                <div class="sale-product-box" @if(isset($banner->banner_image)) style="background: url('{{  asset('storage/'.$banner->banner_image) }}') no-repeat center; background-size: cover;" @endif>
                                    <div class="sale-product-inner rounded-10">
                                        <h5 class="text-white font-normal font-30">{{ $banner->subtitle }}</h5>
                                        <h3 class="heading-primary font-bold font-50">{{ $banner->title }}</h3>
                                        <p class="card-text text-white mb-4">{{ $banner->description }}</p>
                                        <a class="sale-bt bg-primary text-green text-uppercase" href="{{ $banner->button_link }}"><i class="fa fa-arrow-circle-right mr-2"></i> {{ $banner->button_text }}</a>

                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endif
                    @endforeach
                    </div>
                    @if($i > 1)
                        <a class="carousel-control-prev" href="#carouselBannerProductControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                         </a>
                        <a class="carousel-control-next" href="#carouselBannerProductControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
                @endif
                @if($i == 0)
                    <div class="sale-product-box">
                        <div class="sale-product-inner rounded-10">
                            <h5 class="text-white font-normal font-30">Get up to 60% off</h5>
                            <h3 class="text-success font-bold font-50">Summer Sale</h3>
                            <p class="card-text text-white mb-4">Limited items available at this price</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 col-12 mb-5">
                @if($banner_contents)
                <div id="carouselFeatureProductControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @php $i=0; @endphp
                    @foreach($banner_contents as $banner)
                        @if($banner->option == 2)
                            <div class="carousel-item {{ $i==0 ?'active':'' }}">

                                <div class="coupan-product-box" @if(isset($banner->banner_image)) style="background: url('{{  asset('storage/'.$banner->banner_image) }}') no-repeat center; background-size: cover;" @endif>
                                    <div class="card-body">
                                        <h6 class="font-24 font-normal text-white">{{ $banner->subtitle }}</h6>
                                        <h5 class="text-white font-30 mb-2">{{ $banner->title }}</h5>
                                        <a class="sale-bt bg-primary text-green text-uppercase font-500 font-18" href="{{ $banner->button_link }}"><i class="fa fa-arrow-circle-right mr-1"></i> {{ $banner->button_text }}</a>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endif
                    @endforeach
                    </div>
                    @if($i>1)
                        <a class="carousel-control-prev" href="#carouselFeatureProductControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                         </a>
                        <a class="carousel-control-next" href="#carouselFeatureProductControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
                @endif
                @if($i == 0)
                    <div class="coupan-product-box">
                        <div class="card-body">
                            <h6 class="font-24 font-normal text-white">SHOP LOCAL </h6>
                            <h5 class="text-white font-30 mb-2">SERVICES</h5>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
<!-- home featured products -->

@if($comboProductServ)
<section class="feature-product overflow-hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
                <h2 class="text-center custom-heading heading-primary text-uppercase">New Products and Services</h2>
                <div class="owl-carousel owl-theme mt-4 rounded-10" id="newproduct_and_services">
                @php $i = 0; @endphp
                @foreach($comboProductServ as $product)
                    @if($product->product_type != 'services')
                        <div class="item">
                            <div class="product-wrap border-1">
                                <figure>
                                     <a href="{{ route('front.get.product', str_slug($product->slug)) }}">
                                     @if(isset($product->cover) &&  asset("$product->cover") !=  asset("storage") )
                                        <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}" class="product-img img-fluid p-0">
                                    @else
                                        <img src="{{ asset('images/placeholder-square.png') }}" alt="{{ $product->name }}" class="product-img p-0 img-fluid p-0" />
                                    @endif
                                </a>
                                    <div class="d-flex quick-links" role="group">
                                        <form action="{{ route('cart.store') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="product" value="{{ $product->product_id }}">
                                            <button type="submit" class="mr-2 btn btn-info"><i class="fa fa-cart-plus"></i>  </button>
                                        </form>
                                        <button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn myBtnCls" product-id="{{ $product->product_id }}"><i class="fa fa-heart-o whishstate"></i></button>                                        
                                        @if(isset(auth()->user()->id))
                                        <input type="hidden" name="uId" id="uId" value="{{ auth()->user()->id }}">
                                        @else
                                        <input type="hidden" name="uId" id="uId" value="">
                                        @endif
                                    </div>
                                </figure>
                                <a href="{{ route('front.get.product', str_slug($product->slug)) }}"><h2 class="product-tittle" data-toggle="tooltip" title="{{ $product->name }}">{{ $product->name }}</h2></a>
                                <p class="product-price">{{config('cart.currency_symbol')}}{{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price))<del style="color:black;">{{ config('cart.currency_symbol') }}{{ $product->price }}</del>@endif</p>
                                
                                <a class="btn shop-btn" href="{{ route('front.get.product', str_slug($product->slug)) }}">Shop Now</a>
                              
                                <a class="Vendor-name text-black" href="{{ route('shop.vendor-details', $product->vendor_id) }}">{{$product->vendorname}}</a>

                            </div>
                        </div>
                    @else   
                        <div class="item">
                            <div class="product-wrap border-1">
                                 <figure>
                                <a href="{{ route('front.get.product', str_slug($product->slug)) }}">
                                @if(isset($product->cover) &&  asset("$product->cover") !=  asset("storage") )
                                    <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}" class="product-img img-fluid p-0">
                                @else
                                    <img src="{{ asset('images/placeholder-square.png') }}" alt="{{ $product->name }}" class="product-img p-0 img-fluid p-0" />
                                @endif
                            </a>
                                <div class="d-flex quick-links" role="group">
                                    <form action="{{ route('cart.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="product" value="{{ $product->product_id }}">
                                        <button type="submit" class="mr-2 btn btn-info"><i class="fa fa-cart-plus"></i>  </button>
                                    </form>
                                    <button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn " product-id="{{ $product->product_id }}"><i class="fa fa-heart-o"></i></button>
                                </div>
                                 </figure>
                               <a href="{{ route('front.get.product', str_slug($product->slug)) }}"> <h2 class="product-tittle" data-toggle="tooltip" title="{{ $product->name }}">{{ $product->name }}</h2></a>
                                <p class="product-price">{{config('cart.currency_symbol')}}{{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price)) <del style="color:black;">{{ config('cart.currency_symbol') }}{{ $product->price }}</del>@endif</p>
                                <a class="btn shop-btn" href="{{ route('front.get.product', str_slug($product->slug)) }}">More Info</a>
                                <a class="Vendor-name text-black" href="{{ route('shop.vendor-details', $product->vendor_id) }}">{{$product->vendorname}}</a>
                                @if(isset(auth()->user()->id))
                                <input type="hidden" name="uId" id="uId" value="{{ auth()->user()->id }}">
                                @else
                                <input type="hidden" name="uId" id="uId" value="">
                                @endif
                            </div>
                        </div>
                @endif
                @php $i++; @endphp
                @endforeach   
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- home feature category -->
@if($feature_contents)
<section class="home-feature-category mt-4">
    <div class="container">
        <div class="row">
            @php $i =1; @endphp
            @foreach($feature_contents as $feature)
            <div class="col-md-4 col-lg-4 col-xl-4 col-12 mb-3">
                <div class="feature-category category-{{$i}} feature-left" @if(isset($feature->banner_image)) style="background: url('{{  asset('storage/'.$feature->banner_image) }}') no-repeat center; background-size: cover;" @endif>
                    <div class="card-body">
                        <h3 class="font-28 text-white font-light">{{ $feature->title }}</h3>
                        <p class="font-24 font-500 text-white mb-3">{{ $feature->subtitle }}</p>
                        <a class="btn btn-primary font-bold" href="{{ $feature->button_link }}">{{ $feature->button_text }}</a>
                    </div>
                </div>
            </div>
            @php $i++ @endphp
           @endforeach
        </div>
    </div>
</section>
@endif
@if($products)
<section class="recent-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                <h2 class="custom-heading mb-2 text-uppercase text-blue">Recently Added Items</h2>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                <div class="owl-carousel owl-theme mt-4 rounded-10">
                    @foreach($products as $product)
                    <div class="item">
                        <div class="product-wrap border-1">
                            <figure><a href="{{ route('front.get.product', str_slug($product->slug)) }}">
                                 @if(isset($product->cover) &&  asset("$product->cover") !=  asset("storage") )
                                    <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}" class="product-img img-fluid p-0">
                                @else
                                    <img src="{{ asset('images/placeholder-square.png') }}" alt="{{ $product->name }}" class="product-img p-0 img-fluid p-0" />
                                @endif
                            </a>
                                <div class="d-flex quick-links" role="group">
                                    <form action="{{ route('cart.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="product" value="{{ $product->product_id }}">
                                        <button type="submit" class="mr-2 btn btn-info"><i class="fa fa-cart-plus"></i>  </button>
                                    </form>
                                    <button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn" product-id="{{ $product->product_id }}"><i class="fa fa-heart-o"></i></button>
                                </div>
                            </figure>
                            <a href="{{ route('front.get.product', str_slug($product->slug)) }}"><h2 class="product-tittle" data-toggle="tooltip" title="{{ $product->name }}">{{ $product->name }}</h2></a>
                            <p class="product-price heading-primary">{{config('cart.currency_symbol')}}{{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price))<del style="color:black;">{{ config('cart.currency_symbol') }}{{ $product->price }}</del>@endif</p>
                            <a class="btn btn-primary" href="{{ route('front.get.product', str_slug($product->slug)) }}">Shop Now</a>
                            
                            <a class="Vendor-name text-black" href="{{ route('shop.vendor-details', $product->vendor_id) }}">{{$product->vendorname}}</a>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- home search bar -->
<div class="search-products bg-primary">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                <h3 class="font-36 text-uppercase font-weight-bold">FIND PRODUCTS AND SERVICES LOCAL TO YOU</h3>
                <p class="text-white font-normal"></p>
                <div class="form-group">
                    <form class="form-inline mt-3" action="{{route('search.product')}}" method="get">
                        <input type="hidden" name="categories" value="">
                        <input class="form-control" type="search" placeholder="Search a Product, Service or City" aria-label="Search" name="q"/>
                        <button class="btn search-bt" type="submit"><i class="fa fa-search"></i></button>
                    </form>
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
@endsection