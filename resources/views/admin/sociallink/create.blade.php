@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
         <h2>Create Social link</h2>
        @include('layouts.errors-and-messages')
         <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('sociallink.store') }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
              
             <input type="hidden" name="merchant_id" value="{{ auth('vendor')->user()->id }}">
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Title</label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{ old('title') }}" required="">
                    </div>
                </div><br>

                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Link</label>
                        <textarea type="text" name="link" id="location" placeholder="link" class="form-control" required=""></textarea>
                    </div>
                </div><br>

             
                <button type="submit" class="btn btn-success mt-4">ADD </button>

            </form>
        </div>
        <!-- /.box -->

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