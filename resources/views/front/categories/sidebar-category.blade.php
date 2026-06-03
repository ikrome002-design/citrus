<ul class="nav sidebar-menu">
    @foreach($categories as $category)
        @if($category->children()->count() > 0)
            <li>@include('layouts.front.category-sidebar-sub', ['subs' => $category->children])</li>
        @else
            <li @if(request()->segment(2) == $category->slug) class="active" @endif><a href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a></li>
        @endif
    @endforeach
</ul>
@section('js')
<script type="text/javascript">
    function commonFilter(){
        var product_from    = $('#product-pagination li.active').attr("page-no");
        var sort            = $('#product-sort-form-field').val();
        var url             = '{{ route("front.category.filter",  $category->slug) }}';
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
