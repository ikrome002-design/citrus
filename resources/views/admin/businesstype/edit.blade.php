@extends('layouts.admin.app')

@section('content')
 <!-- Main content -->
    <section class="content">
        <h2>Edit Business Type</h2>
        
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <form action="{{ route('admin.business_type.update', $business_type->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <input type="hidden" name="_method" value="put">
               
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Business Type</label>
                        <input type="text" name="title" id="title" placeholder="Business type" class="form-control" value="{{ $business_type->title }}" required="">
                    </div>
                   
                </div>


                <br/>
                
                <button type="submit" class="btn btn-success mt-4">Save</button>

            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
