<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcumbs as $breadcumb)
            @if($loop->last)
                <li class="breadcrumb-item active">@if(isset($breadcumb["icon"]))@endif 
                	<?php 
                	 if($breadcumb["name"]=='Staffs'){
                	 	
                	 	 $breadcumb["name"]='staff';
                	 }
               		?>

                {{$breadcumb["name"]}}

            </li>
            @else

                <li class="breadcrumb-item"><a href="{{ $breadcumb["url"] }}">@if(isset($breadcumb["icon"]))  @endif {{$breadcumb["name"]}}</a></li> <li class="mx-2"><i class="fa fa-angle-right"></i></li>
            @endif
        @endforeach
    </ol>
</nav>
