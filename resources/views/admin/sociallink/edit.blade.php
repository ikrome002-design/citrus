@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
 <!-- Main content -->
    <section class="content">
        <h2>Edit Social Link</h2>
        
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <form action="{{ route('sociallink.update', $sociallink->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <input type="hidden" name="_method" value="put">
               
                
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Title</label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{ $sociallink->title }}" required="">
                    </div>
                </div><br>

                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Link</label>
                        <textarea type="text" name="link" id="link" placeholder="link" class="form-control" required="">{{ $sociallink->link }}</textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success mt-4">Save</button>

            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
@else
@section('js')
<script type="text/javascript">
  
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif