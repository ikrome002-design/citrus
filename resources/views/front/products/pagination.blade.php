<nav aria-label="navigation" class="vendor-review-wrapper ">
    <ul class="pagination" id="product-pagination">
    	
      @if($pages > 1)
        @for($i=0;$i < $pages; $i++ )
          <li class="page-item {{ $paged == $i+1 ? 'active': ''}}" page-no="{{$i+1}}"><a href="#" class="page-link border-0" >{{$i+1}}</a></li>
        @endfor
      @endif
    </ul>
</nav>