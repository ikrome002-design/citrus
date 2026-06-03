@if(isset($product_from))
<div class="row">
    <div class="col-sm-6">
        Showing <span id="product-from-val">{{$product_from+1}}</span> - <span id="product-to-val">{{$product_to}}</span> item(s) of {{count($all_products)}} item(s)
    </div>
    <div class="col-sm-6 text-left text-sm-right">
        <form method="get" action="" id="product-sort-form">
            Sort by: 
            <select class="custom-select sort-by-product" name="sort" id="product-sort-form-field">
              <option value="">Default</option>
              <option value="price_asc" {{ isset($_GET['sort']) && $_GET['sort'] != '' && $_GET['sort'] == 'price_asc' ? 'selected' : '' }}>Price Low to High</option>
              <option value="price_desc" {{ isset($_GET['sort']) && $_GET['sort'] != '' && $_GET['sort'] == 'price_desc' ? 'selected' : '' }}>Price High to Low</option>
              <option value="recency_desc" {{ isset($_GET['sort']) && $_GET['sort'] != '' && $_GET['sort'] == 'recency_desc' ? 'selected' : '' }}>Newest</option>
              <option value="most_popular" {{ isset($_GET['sort']) && $_GET['sort'] != '' && $_GET['sort'] == 'most_popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
        </form>
    </div>
</div>
<hr/>
@endif
@if(!empty($products) && !collect($products)->isEmpty())

    <ul class="row list-unstyled">
        @foreach($products as $product)
            <li class="col-lg-20 col-md-4 col-sm-6 col-xs-12 product-list p-1">
                <div class="single-product">
                    <div class="product-wrap p-0 border-1 pb-3">
                        <figure><a href="{{ route('front.get.product', str_slug($product->slug)) }}">
                            @if(isset($product->cover) &&  asset("$product->cover") !=  asset("storage") )
                                <img src="{{ asset("storage/$product->cover") }}" alt="{{ $product->name }}" class="product-img img-fluid p-0">

                            @else
                                <img src="{{ asset("images/placeholder-square.png") }}" alt="{{ $product->name }}" class="product-img p-0 img-fluid p-0" />
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
                        <div class="px-3">
                            <a href="{{ route('front.get.product', str_slug($product->slug)) }}"><h2 class="product-tittle">{{ $product->productname }}</h2></a>
                            <p class="product-price">{{config('cart.currency_symbol')}} {{ number_format(isset($product->sale_price) ? $product->sale_price : $product->price, 2) }}  @if(isset($product->sale_price))<del style="color:black;">{{ config('cart.currency_symbol') }} {{ $product->price }}</del></p>@endif
                            </p>
                            <a class="btn btn-primary" href="{{ route('front.get.product', str_slug($product->slug)) }}">Shop Now</a>
                            <a class="Vendor-name text-black" href="{{ route('shop.vendor-details', $product->vendor_id) }}"><u>{{$product->vendorname}}</u></a>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="alert alert-warning">No products yet.</p>
@endif

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