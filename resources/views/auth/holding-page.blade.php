@extends('layouts.front.app')
@section('content')
<div class="contact_page_section_main">

 <div class="row">
   <div class="container">
   	</div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    // Redirect the user to where they want to go after 3 seconds.
    setTimeout(function() {
        window.location.replace("{{ route('verify-email') }}");
    }, 3000);
</script>
@endsection
