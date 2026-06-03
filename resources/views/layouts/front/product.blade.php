
 @include('layouts.errors-and-messages')
 <style type="text/css"> .products-details .rating .fa-star{color:grey !important; }
.products-details .rating .text-golden{color:#DF9500 !important; }</style>
<div class="projects_detial_main">
    <div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">Product Details </h2>
  </div>
</div>
    <div class="container">
        <div class="row product-detail-wrapper">
            <div class="col-md-12 col-lg-8 col-xl-8 col-12">
                <div class="buyvi-product-slide">
                    <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                        <li class="product-image" data-thumb="{{ asset("storage/$product->cover") }}">
                            @if(isset($product->cover))
                            <img class="img-responsive"
                                 src="{{ asset("storage/$product->cover") }}"
                                 alt="{{ $product->name }}" />
                            @else
                            <img class="img-responsive"
                                 src="{{ asset("images/placeholder-square.png") }}"
                                 alt="{{ $product->name }}" />
                            @endif
                        </li>
                         @if(isset($images) && !$images->isEmpty())
                            @foreach($images as $image)
                            <li class="product-image" data-thumb="{{ asset("storage/$image->src") }}">
                                <img class="img-responsive" src="{{ asset("storage/$image->src") }}" alt="{{ $product->name }}" />
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
              </div>

            <!-- -----------------buyvi-product-slide-------------------- -->

            <div class="col-md-12 col-lg-4 col-xl-4 col-12">
                <div class="products-details">
                    <a style="text-decoration: none;" class="Vendor-name text-blue font-bold" href="{{ route('merchant.view', $product->vendor_id) }}">{{$vendor->first_name }} {{$vendor->last_name }}</a>
                    <!-- <div class="rating w-100 d-flex align-items-center">
                        @if(isset($ratingAvg))
                            @if($ratingAvg >= 1 && $ratingAvg < 2)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 2 && $ratingAvg < 3)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 3 && $ratingAvg < 4)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 4 && $ratingAvg < 5)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 5)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            @endif
                        @else
                      
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                        @endif
                        <p class="review_count"> {{ isset($ratecount) ? $ratecount : '' }} ratings</p>
                    </div> -->
                    <h2 class="product_name  ">{{ strtoupper($product->name) }}</h2>
                    <div class="product-detail-price ">
                        <div class="productprice">
                            <div class="d-flex">

                                <h4 class="product-details-price">{{ config('cart.currency_symbol') }}{{ isset($product->sale_price) ? $product->sale_price : $product->price}}
                                @if(isset($product->sale_price))
                                    <del>{{ config('cart.currency_symbol') }} {{ $product->price }}</del> 
                                @endif
                                </h4>
                            </div>
                            @if(isset($product->sale_price))
                            <div class="saveprice-instock">
                                <h6 class="you-save-price ">You save {{ config('cart.currency_symbol') }} {{ $discount = $product->price-$product->sale_price }}({{ round($discount*100/$product->price) }}%)</h6>
                            </div>
                            @endif
                        </div>
                        <div class="product-stock">
                            @if($product->quantity > 0)
                                <p class="in_stock"><img src="{{ asset('images/right_check_icon.svg')}}" /> In stock</p>
                                <p class="heading-primary stock-text">Stock Available: <span class="text-success">{{$product->quantity}}</span></p>
                            @else
                                <p class="text-danger stock-text">Out of stock</p>
                            @endif
                        </div>
                    </div>
                    <div class="product-description ">
                       {!! $product->short_description !!}
                    </div>
                    <div class="price_cart_btn_box">
                        @if($product->quantity > 0)
                            <form action="{{ route('cart.store') }}" method="post">
                                <input type="hidden" name="product" value="{{ $product->id }}" />
                                {{ csrf_field() }}
                              
                                
                                <div class="form-group qty_box">
                                    <label class="text-blue font-bold">QTY:</label>
                                    <input type="number" class="form-control" min="1" name="quantity" id="quantity" placeholder="Quantity" value="{{ null !== old('quantity') ?old('quantity'):1 }}" max="{{$product->quantity}}">
                                </div>
                                 
                                <button type="submit" class="addtocart-bt text-white font-bold text-uppercase bg-blue" href="javascript:void(0)">Add To Cart</button>
                               
                            </form>
                            @else
                             <button class="addtocart-bt text-white font-bold text-uppercase bg-blue" href="javascript:void(0)" style="background-color: grey;">Out Of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
        </div> 
        <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-12 col-12"> 
            <div class="product-discription-tabs">
                <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">PRODUCT DESCRIPTION</a>
                    </li>
                  <!--   @if(isset($company_detail))
                    <li class="nav-item">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">COMPANY INFORMATION</a>
                    </li>
                    @endif -->
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                      <h2 class="text-black font-24">Product Description:</h2>
                      <p>{!! $product->description !!}</p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                       <h2 class="text-black font-24">Company information:</h2>
                        @if(isset($vendor))
                        <p>{{ $vendor->business_name }} {{ $vendor->business_year}} {{ $company_detail->business_location }} {{ $company_detail->business_about }} {{ $company_detail->phone_number }} {{ $company_detail->created_at }}</p>
                      @endif
                    </div>                            
                  </div>
            </div>
          </div>
         </div> 
        <!--   <div class="row detail-review-box mr-0 ml-0">
            <div class="col-md-6 col-lg-6 col-xl-6 col-6 pl-0 pr-0">                        
                <h2 class="text-black font-24 mb-2">REVIEWS</h2>
                    <div class="d-flex align-items-center vendor-total-review">
                       <p class="font-18 mr-md-3">{{ isset($ratecount) ? $ratecount : '' }} reviews</p>
                        @if(isset($ratingAvg))
                            @if($ratingAvg <= 0)
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 1 && $ratingAvg < 2)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 2 && $ratingAvg < 3)

                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                           @if($ratingAvg >= 3 && $ratingAvg < 4)
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            <i class="fa fa-star font-18"></i>
                             @endif

                            @if($ratingAvg >= 4 && $ratingAvg < 5)

                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star font-18"></i>
                            @endif

                            @if($ratingAvg >= 5)

                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            <i class="fa fa-star text-golden font-18"></i>
                            @endif
 
                        @endif                  
                   </div>                          
              </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-6 text-right pl-0 pr-0">
                @if(isset(auth()->user()->id))
                <input type="hidden" name="uId" id="uId" value="{{ auth()->user()->id }}">
                @else
                <input type="hidden" name="uId" id="uId" value="">
                @endif
                <a href="#review1" class="write-review-bt text-blue review_click" id="review_click">Write a review</a>
            </div>
          </div>                  
          <div class="row detail-review-profile ">
            <div class="col-md-12 col-lg-12 col-xl-12 col-12">
              <ul class="list-unstyled">
                @if(isset($rate))
                <?php //echo "<pre>";print_r($rate);die;?>
                    @foreach($rate as $rating1)
                        <li class="media mb-5">
                            @if($rating1->avatar)
                                <img class="mr-3" src="{{ asset( 'storage/profile/customer/'.$rating1->user_id.'/'.$rating1->avatar.'' ) }}" alt="{{ isset($rating1->name) ? $rating1->name : '' }}">
                            @else
                                <img class="mr-3" src="{{ asset("images/user_image.png") }}" alt="{{ isset($rating1->name) ? $rating1->name : '' }}">
                            @endif
                            <div class="media-body">
                              <h3 class=""><u>{{ isset($rating1->name) ? $rating1->name : '' }}</u> {{ date("F j, Y", strtotime('-8 hours', strtotime($rating1->created_at) )) }}</h3>
                              @if(isset($ratingAvg))

                                @if($rating1->rating ==0)
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                @endif

                                @if($rating1->rating ==1)
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                @endif

                                @if($rating1->rating ==2)

                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                @endif

                                @if($rating1->rating ==3)
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star "></i>
                                <i class="fa fa-star "></i>
                                 @endif

                                @if($rating1->rating ==4) 
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star "></i>
                                @endif

                                @if($rating1->rating ==5)
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                <i class="fa fa-star text-golden"></i>
                                @endif

                                <div class="profile-mini-box">
                                    <p class="review_count product-discription pl-0">{{ $rating1->review }}</p>
                                </div>
                                @endif
                              </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>





        </div>
<div id="review1" class="review_login">
    <div class="row">
        <div class="col-12"> 
     @if(auth()->check())
        <form action="{{ route('product.add.review') }}" method="post" >
            {{ csrf_field() }}

            <input type="hidden" name="product_id" id="product_id" placeholder="Name" class="form-control" value="{{$product->id}}">
            <input type="hidden" name="vendor_id" value="{{ $product->vendor_id}}">

           
            <div class="star-rating text-center">
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
       
       
            <div class="form-group">

            <label for="">Review</label>
            <textarea class="form-control" name="review" placeholder="Enter review"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form> 
        @else
         <form action="{{ route('product.add.review') }}" method="post" >
            {{ csrf_field() }}

        <input type="hidden" name="product_id" id="product_id" placeholder="Name" class="form-control" value="{{$product->id}}">
            <input type="hidden" name="vendor_id" value="{{ $product->vendor_id}}">
       {{--<button class="Vendor-name text-success" type="submit" style="border-style: none; background-color:#fff; "><u> Please login first for giving your reviews.</u></button>--}}
         <button class="Vendor-name text-success" type="submit" style="border-style: none; background-color:#fff; "></button>
   </form>
      @endif 

    </div>
</div>
</div> -->


      
</div>   
</div>
@section('js')

    <script type="text/javascript">
        $(document).ready(function () {
            var productPane = document.querySelector('.product-cover');
            var paneContainer = document.querySelector('.product-cover-wrap');
            if (paneContainer) {
                new Drift(productPane, {
                    paneContainer: paneContainer,
                    inlinePane: false
                });
            }
        });
        /*$(".review_click").click(function() {
            $('#rating_containt').css('display','block');
            $('html,body').animate({
                scrollTop: $(".second").offset().top},
                'slow');
        });*/
        function addRating(obj,id) {
            console.log("id",id);
            $("#rating").val(id);
            $(".give_rating li img").each(function(){
                var event_value = $(this).attr('data-value');
                if(event_value<=id){
                    $(this).attr('src','images/rating.png');
                }else{
                    $(this).attr('src','images/unfiledstar.png');
                }
            });
        }

        $(document).on('click', '#review_click', function(){
           
            var uId = $("#uId").val();
            console.log('uId',uId);
            if(uId==='' || uId === null){
                console.log('i am here');
                $("#notMsg").text('Please login first !  ');
            }else{
                console.log('Please login first1');
                $('#rating_containt').css('display','block');
                 $('#notification-bar').css('display','none');
               // $('html,body').animate({scrollTop: $(".second").offset().top},'slow');
            }
             
        });

    </script>

@endsection
