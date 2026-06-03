@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('admin.testimonial.store') }}" method="post" class="form" enctype="multipart/form-data">
                
                <div class="box-body">
                    {{ csrf_field() }}
                   
                    <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="100" width="100">
                                <p class="m-2">Upload Testimonial Image<span class="text-danger">*</span></p>
                            <input type="file" id="fileUpload" name="image" class="d-none" required="" />
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{ old('title') }}" required="">
                    </div>
                     <div class="form-group">
                        <label for="name">Description <span class="text-danger">*</span></label>
                        <textarea type="text" name="description" id="description" placeholder="Description" class="form-control" required=""></textarea>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.testimonial.index') }}" class="btn btn-danger vendor-product-bt">Back</a>
                        <button type="submit" class="btn btn-primary vendor-product-bt">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
