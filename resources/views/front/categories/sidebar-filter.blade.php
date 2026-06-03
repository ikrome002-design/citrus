<div class="product-filter-sidebar">
	<?php //echo "<pre>"; print_r($category); die;?>
	@if(isset($category))
	<div class="category-image">
	    @if(isset($category->cover))
	        <img class="img-fluid" src="{{ asset("storage/$category->cover") }}" alt="{{ $category->name }}" class="img-responsive" />
	    @endif
	</div>
	<h4 class="product_titel">{{ $category->name }}</h4>
	@else
	<h4 class="product_titel">All Products</h4>
	@endif
	<div class="category-list-filter jquery-accordion-menu" id="jquery-accordion-menu">
		<ul class="">
			
			@if(isset($category))
			<li><a href="{{ route('shop') }}"><span>&#x2190;</span> All Categories</a></li>
			@else
			<li><a href="{{ route('shop') }}"><span>&#x2190;</span>All Categories</a></li>
			@endif

			
			@for($i=0; $i< count($parent_child_cat); $i++)
				<li>
					<a href="{{ route("front.category.slug",  $parent_child_cat[$i]['slug']) }}">{{$parent_child_cat[$i]['name']}}</a>
					@if(isset($parent_child_cat[$i]['child']))
						<ul class="submenu">
							
						@for($j=0; $j< count($parent_child_cat[$i]['child']); $j++)
							
							<li class="">
								<a href="{{ route("front.category.slug",  $parent_child_cat[$i]['child'][$j]['slug']) }}">{{$parent_child_cat[$i]['child'][$j]['name']}}</a>
								
								
								 @foreach($sub_child_cat as $value)
									

									@if($value->parent_id==$parent_child_cat[$i]['child'][$j]['id'])
									<ul class="submenu">
											
											<li><a href="{{ route("front.category.slug", $value->slug) }}" style="    color: #588e43;">{{$value->name}}</a></li>
											
										
									</ul>
									@endif
								
								@endforeach
							</li>
						@endfor	
						</ul>

						<?php //print_r($sub_child_cat);?>
					@endif
				</li>
			@endfor
		</ul>
	</div>
	<div class="category-list-filter price_filter">
		<h4 class="product_subtitle">Price ({{config('cart.currency_symbol')}})</h2>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="allPrice" value="0" max-price="" checked>
		  <label class="form-check-label" for="allPrice">
		    Any price 
		  </label>
		</div>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="under25" value="0" max-price="25">
		  <label class="form-check-label" for="under25">
		    Under {{config('cart.currency_symbol')}} 25
		  </label>
		</div>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="25to50" value="25" max-price="50">
		  <label class="form-check-label" for="25to50">
		    {{config('cart.currency_symbol')}} 25 to {{config('cart.currency_symbol')}} 50
		  </label>
		</div>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="50to100" value="50" max-price="100">
		  <label class="form-check-label" for="50to100">
		    {{config('cart.currency_symbol')}} 50 to {{config('cart.currency_symbol')}} 100
		  </label>
		</div>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="over100" value="100" max-price="">
		  <label class="form-check-label" for="over100">
		    Over {{config('cart.currency_symbol')}} 100
		  </label>
		</div>
		<div class="form-check mb-2">
		  <input class="form-check-input" type="radio" name="price-filter" id="customPrice" value="0" max-price="">
		  <label class="form-check-label" for="customPrice">
		    Custom
		  </label>
		</div>
		<div class="row ml-0 mr-0" id="customPriceDiv">
			<div class="col  pl-0 pr-0">
		  		<input type="number" onchange="updatecustomPriceMin(this.value)"  name="price-filter" class="form-control" id="customPriceMin" placeholder="Min">
		  	</div>
		  	<div class="col  pl-2 pr-2">
		  		<input type="number" onchange="updatecustomPriceMax(this.value)" name="price-filter" class="form-control" id="customPriceMax" placeholder="Max">
		  	</div>
		  <button type="submit" class="btn btn-success ml-0" id="customPriceBtn">GO</button>
		</div>
	</div>
	<div class="category-list-filter ">
		<h4 class="product_subtitle">Sort by Vendors</h4>
		@foreach($all_vendors as $vendor)
			<div class="custom-control custom-checkbox filter-by-vendors">
			  <input type="checkbox" class="custom-control-input" name="vendors[]" id="vendor{{$vendor->id}}" value="{{$vendor->id}}" autocomplete="on">
			  <label class="custom-control-label" for="vendor{{$vendor->id}}">{{$vendor->name}}</label>
			</div>
		@endforeach
	</div>
	<div class="category-list-filter brand_filter">
		<h4 class="product_subtitle">Sort by Brands</h4>
		<ul class="list-group list-group-flush">
			@foreach($all_brands as $brand)
				<!-- <li class="list-group-item"><a href="{{ route('brand', $brand->slug) }}">{{$brand->name}}</a></li> -->
				
				<li class="list-group-item"><input type="radio" <?php if(isset($slug)){ if($slug == $brand->slug){?> checked="checked" <?php } } ?> name="brands"  onclick="javascript:window.location.href='{{ route('brand', $brand->slug) }}'; return false;" > {{$brand->name}}</li>
			@endforeach
		</ul>
	</div>
	
</div>
<?php
$slug='';
if(isset($category->slug)){
	$slug=$category->slug;
	$mainRoute='front.category.filter';
}
if(isset($brand->slug) && !isset($category->slug)){
	$slug=$brand->slug;
	$mainRoute='brand.filter';
}

if(!isset($category->slug) || !isset($brand->slug)){
	$slug='';
	$mainRoute='shop.filter';
}

if ( (request()->has('q') && request()->input('q') != '' ) || ( request()->has('categories') && request()->input('categories') != '' ) ) {
	$slug='';
	$mainRoute='search.filter';
}
// echo 'current_url'.url()->current();
// $current_url=url()->current();

?>
@section('js')
<script type="text/javascript">

    function commonFilter(){

    	

        var product_from    = $('#product-pagination li.active').attr("page-no");
        var sort            = $('#product-sort-form-field').val();
        var url             = '{{ route($mainRoute,  $slug) }}';
        var price_from      = $('input[name="price-filter"]:checked').val();
        var price_to        = $('input[name="price-filter"]:checked').attr("max-price");

        var values = [];
        $("input[name='vendors[]']:checked").each(function() {
            values.push($(this).val());
        });

        var vendors         = values;

        filterProduct(url, product_from, sort, price_from, price_to, vendors)
    }
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

/*|>>========== Product list filter End =============<<|*/

    $(document).on('click', '#customPriceBtn', function(){
	    $('.custome-price-error').remove();
	    if(Number($('#customPriceMin').val()) < Number($('#customPriceMax').val())){
	        console.log('iam here');
	            $('#customPriceMin').attr('min-price');
	            $('#customPriceMax').attr('max-price');
	            var product_from    = $('#product-pagination li.active').attr("page-no");
	            var sort            = $('#product-sort-form-field').val();
	            var url             = '{{ route("shop.filter") }}';
	            var price_from      = $('#customPriceMin').attr('min-price');
	            var price_to        = $('#customPriceMax').attr('max-price');
	            console.log(url);

	            var values = [];
	            $("input[name='vendors[]']:checked").each(function() {
	                values.push($(this).val());
	            });

	            var vendors         = values;

	            filterProduct(url, product_from, sort, price_from, price_to, vendors)
	        
	    }else{
	        $('#customPriceDiv').after('<small class="custome-price-error text-danger">Min & Max price is invalid</small>');
	    }
	});

</script>
@endsection
