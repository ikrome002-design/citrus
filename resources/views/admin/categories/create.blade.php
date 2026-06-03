@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
         <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="status" value="1">
                @if(isset(auth('employee')->user()->id))
                    <input type="hidden" name="created_by" value="{{auth('employee')->user()->id}}">
                    <input type="hidden" name="updated_by" value="{{auth('employee')->user()->id}}">
                @endif
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Business Type</label>
                        <select name="parent_id" class="form-control" required="">
                            <option value="">-- Select --</option>
                            @foreach($parent_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-12">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Category Name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div><br>

                <!-- <div class="form-row">
                    <div class="col-sm-12">
                        <label >Category Type <span class="text-danger">*</span></label>
                        <select name="is_visible_main" class="form-control" required="">
                            <option value="">-- Select Type --</option>
                           
                                <option value="1">Main</option>
                                  <option value="0">Other</option>
                          
                        </select>
                    </div>

                   
                </div> -->
                <!-- <div class="form-group text-center mt-4 create-caregories-img-upload">
                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">   <label for="fileUpload">
                            <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                            <p class="m-2">Add Category feature image</p>
                        <input type="file" id="fileUpload" name="cover" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                        </label>
                    </div>
                </div> 
                <div class="form-group mt-5">
                    <label for="description">Category Description </label>
                    <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                </div>-->
                <button type="submit" class="btn btn-success mt-4">Add Category</button>

            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
