@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
         <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('admin.business_type.store') }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
              
           
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Business Type</label>
                        <input type="text" name="title" id="title" placeholder="Business type" class="form-control" value="{{ old('title') }}" required="">
                    </div>
                </div><br>

             
                <button type="submit" class="btn btn-success mt-4">ADD </button>

            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
