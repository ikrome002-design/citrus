@extends('layouts.front.app')
@section('content')

    <!-- home banner -->
    <section class="vendor-banner" style="@if(isset($vendor->cover_image))background: url('{{ asset("storage/$vendor->cover_image") }}') no-repeat;@else background: url('{{ asset("images/no-banner.jpg") }}') no-repeat center; background-size: cover;@endif">
      
    </section>
    <section class="vendor-info-box">
         @if(!empty($vendor))
        <div class="container">
            <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8 col-12">
                <div class="media vendor-sales-box">
                  
                  <figure>
                    @if(isset($vendor->avatar))
                        <img class="mr-5" src="{{ asset("storage/profile/vendors/$vendor->id/$vendor->avatar") }}">
                    @else
                        <img class="mr-5" src="{{ asset("images/vendor_image.jpg") }}" width="200" height="200">
                    @endif
                   
                </figure>
                  <div class="media-body">
                    <h3>{{$vendor->name}}</h3>
                    <p>{{ $vendor->short_description}}</p>
                    <div class="vendor-sale">
                        <span class="green-bt" href="javasript:void(0)">On {{ $vendor->business_name}} since {{ $vendor->business_year}}</span >
                        <div class="sales-rating">
                        <p>{{$vendor_sales->sales}} Sales</p>
                        @if(!empty($user_details))
                        @for ($i = 1; $i <= $avg_rating->ratings_average; $i++)
                             <i class="fa fa-star text-golden font-18"></i>
                        @endfor
                         @for ($i = 1; $i <=5-$avg_rating->ratings_average; $i++)
                             <i class="fa fa-star font-18"></i>
                        @endfor
                         @endif
                        </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4 col-xl-4 col-12">
                <div class="vendor-detail">
                    <h3>Contact info:</h3>
                    <ul>
                      <li> <a href="tel:65-62625311"><i class="fa fa-phone"></i> {{ $vendor->phone}}</a></li>
                      <li><a href="mailto:fisherprice@gmail.com"><i class="fa fa-envelope"></i> {{ $vendor->email}}</a></li>
                      @if(isset($vendor->address))
                      <li><i class="fa fa-map-marker"></i> {{ $vendor->address}}</li>
                      @endif
                    </ul>
                   
                    
                   
                </div>
            </div>
            </div>
        </div>
         @endif

    </section>
    <section class="vendor-story-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                    <h2 class="font-24 mb-3">Our Story</h2>
                    <p>{{ $vendor->story}}</p>
                    
                </div>
                 <div class="col-md-12 col-lg-12 col-xl-12 col-12 mt-5">
                    <h2 class="font-24 mb-3">Vision and Mission</h2>
                    <p>{{ $vendor->mission_description}}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="vendor-items-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-2 col-xl-2 col-12 text-md-center">
                    <h2 class="text-blue custom-heading font-24 text-uppercase mb-2 feature-heading">All Items</h2>
                </div>
                 <div class="col-md-12 col-lg-10 col-xl-10 col-12">
                    <div class="item-product">
                        @if(!empty($vendor_product))
                        @foreach($vendor_product as $product)
                         @if($product->product_type != 'services')
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
                                        <input type="hidden" name="product" value="{{ $product->id }}">
                                        <button type="submit" class="mr-2 btn btn-info"><i class="fa fa-cart-plus"></i>  </button>
                                    </form>
                                    <button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn myBtnCls" product-id="{{ $product->id }}"><i class="fa fa-heart-o"></i></button>
                                    @if(isset(auth()->user()->id))
                                    <input type="hidden" name="uId" id="uId" value="{{ auth()->user()->id }}">
                                    @else
                                    <input type="hidden" name="uId" id="uId" value="">
                                    @endif
                                </div>
                            </figure>
                            <a href="{{ route('front.get.product', str_slug($product->slug)) }}"><h2 class="product-tittle">{{ $product->name }}</h2></a>
                            <p class="product-price">{{config('cart.currency_symbol')}} {{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price))<del style="color:black;">{{ config('cart.currency_symbol') }} {{ $product->price }}</del>@endif</p>
                            <a class="shop-btn" href="{{ route('front.get.product', str_slug($product->slug)) }}">Shop Now</a>
                        </div>
                        @else
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
                                        <input type="hidden" name="product" value="{{ $product->id }}">
                                        <button type="submit" class="mr-2 btn btn-info"><i class="fa fa-cart-plus"></i>  </button>
                                    </form>
                                    <button type="button" class="btn btn-warning add-to-wishlist-btn product-wishlist-btn" product-id="{{ $product->id }}"><i class="fa fa-heart-o"></i></button>
                                </div>
                            </figure>
                            <a href="{{ route('front.get.product', str_slug($product->slug)) }}"><h2 class="product-tittle">{{ $product->name }}</h2></a>
                            <p class="product-price">{{config('cart.currency_symbol')}} {{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price))<del style="color:black;">{{ config('cart.currency_symbol') }} {{ $product->price }}</del>@endif</p>
                            <a class="shop-btn" href="{{ route('front.get.product', str_slug($product->slug)) }}">more info</a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                      
                    </div> 
                  
                </div>
            </div>
        </div>
    </section>

    <section class="vendor-give-review">
        <div class="container">
            <div class="row">
             
              <div class="col-md-12 col-lg-12 col-xl-12 col-12 text-center">
  @if(auth()->check())
                  <form action="{{ route('vendor.add.review') }}" method="post">

                  {{ csrf_field() }}
                  <input type="hidden" name="vendor_id" value="{{ $vendor->id}}">
                  <h2 class="font-30 font-normal mb-3">GIVE THIS VENDOR A RATING</h2>
                  @include('layouts.errors-and-messages')
                  <div class="star-rating">
                      <div class="star-rating">
                        <input id="star-5" type="radio" name="rating" value="5" />
                        <label for="star-5" title="5 stars">
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-4" type="radio" name="rating" value="4" />
                        <label for="star-4" title="4 stars">
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-3" type="radio" name="rating" value="3" />
                        <label for="star-3" title="3 stars">
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-2" type="radio" name="rating" value="2" />
                        <label for="star-2" title="2 stars">
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-1" type="radio" name="rating" value="1" />
                        <label for="star-1" title="1 star">
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </label>
                      </div>
                  </div>
                  <div class="rating-comment">
                      <div class="form-group">
                          <input type="text" name="review" >
                          <button type="submit" class="btn-primary">Submit</button>
                      </div>
                  </div>
                  </form>
                  @else
                   <form action="{{ route('vendor.add.review') }}" method="post">

                  {{ csrf_field() }}
                  <input type="hidden" name="vendor_id" value="{{ $vendor->id}}">
                  <button class="Vendor-name text-blue" type="submitt" style="border-style: none; background-color:#f6f6f6; "><u> Please login first for giving your reviews.</u></button>
                </form>
                  @endif
              </div>

            </div>
        </div>
    </section>
    <section class="vendor-review-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-2 col-xl-2 col-12 text-md-center">
                    <h2 class="text-blue custom-heading font-24 text-uppercase mb-2 feature-heading">REVIEWS</h2>
                </div>

                @if(empty($user_details))
                <h4>No rating available</h4>
                @else
                <div class="col-md-12 col-lg-10 col-xl-10 col-12">
                   <div class="row vendor-sort-box">
                       <div class="col-md-6 col-lg-6 col-12">
                           <div class="d-flex align-items-center vendor-total-review">
                               <p class="font-18 mr-md-3">{{count($user_details)}} reviews</p>
@if(empty($user_details))
                               @for ($i = 1; $i <= $avg_rating->ratings_average; $i++)
                                     <i class="fa fa-star text-golden font-18"></i>
                                @endfor
                                 @for ($i = 1; $i <=5-$avg_rating->ratings_average; $i++)
                                     <i class="fa fa-star font-18"></i>
                                @endfor   
                                @endif                           
                           </div>
                       </div>
                   </div>
                   <div class="user-profile-box mt-4" id="myTable">
                       <ul class="list-unstyled" id="vendor-reviews-list">
                        @foreach($user_details as $row)
                          <li class="media mb-5">
                            @if(isset($row->avatar))
                                <img class="mr-3" width="100" height="100" src="{{ asset("images/dummy-user.png") }} ">
                            @else
                                 <img class="mr-3" src="{{ asset("images/dummy-user.png") }}" width="100" height="100">
                            @endif
                            <div class="media-body">
                              <h3 class=""><u>{{ $row->name}}</u> {{date('j M, Y', strtotime($row->created_at))}}</h3>
                                @for ($i = 1; $i <= $row->rating; $i++)
                                     <i class="fa fa-star text-golden font-18"></i>
                                @endfor
                                @for ($i = 1; $i <=5-$row->rating; $i++)
                                     <i class="fa fa-star font-18"></i>
                                @endfor   
                                <p class="product-discription">{{$row->review}}</p>    
                            </div>
                          </li>

                          @endforeach
                        </ul>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="vendor-review-pagination">
                              @if(count($user_details)/10 > 1)
                                @for($i=0;$i < count($user_details)/10; $i++ )
                                  <li class="page-item {{$i==0?'active':''}}" page-no="{{$i+1}}"><a href="#" class="page-link border-0 active" >{{$i+1}}</a></li>
                                @endfor
                              @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ------------------------ footer Start  Here -------------------------->
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