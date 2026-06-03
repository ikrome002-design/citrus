@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                 <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                @if($brand->image !='')         
                                    <img id="imgPrime" src="{{ asset( 'storage/'.$brand->image.'' ) }}" alt="{!! $brand->name ?: old('name')  !!}" height="100" width="100"> 
                                @else

                                    <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" alt="{!! $brand->name ?: old('name')  !!}" height="100" width="100">

                                @endif
                                <p class="m-2">Change Brand Image</p>
                            <input type="file" id="fileUpload" name="image" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                            </label>
                        </div>
                    </div>
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ $brand->name }}">
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                     <div class="btn-group">
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-danger vendor-product-bt">Back</a>
                        <button type="submit" class="btn btn-primary vendor-product-bt">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
