@if(isset($status))
    @if($status == 1)
        <span style="display: none; visibility: hidden">1</span>
        <a href="" class="btn btn-success btn-sm" onclick="return confirmation();"> Approved</a>
      
        @else
        <span style="display: none; visibility: hidden">0</span>
        <a href="" class="btn btn-danger btn-sm" onclick="return confirmation();"> Unapproved</a>
    @endif
@endif

