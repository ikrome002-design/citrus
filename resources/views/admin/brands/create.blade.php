@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('admin.brands.store') }}" method="post" class="form" enctype="multipart/form-data">
                  <input type="hidden" name="slug" value="sfd">
                <div class="box-body">
                    {{ csrf_field() }}
                   
                    <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="100" width="100">
                                <p class="m-2">Upload Brand Image<span class="text-danger">*</span></p>
                            <input type="file" id="fileUpload" name="image" class="d-none" />
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-danger vendor-product-bt">Back</a>
                        <button type="submit" class="btn btn-primary vendor-product-bt">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
