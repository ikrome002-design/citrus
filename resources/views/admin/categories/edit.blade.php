@extends('layouts.admin.app')

@section('content')
 <!-- Main content -->
    <section class="content">
        <h2>Edit Category</h2>
        
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="status" value="1">
                <input type="hidden" name="_method" value="put">
                @if(isset(auth('employee')->user()->id))
                    <input type="hidden" name="updated_by" value="{{auth('employee')->user()->id}}">
                @endif
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Business Type</label>
                        <select name="parent_id" id="parent" class="form-control" required="">
                            <option value="{{$parent_category->id}}">{{$parent_category->title}}</option>
                            @foreach($parent_categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Category Name" class="form-control" value="{!! $category->name ?: old('name')  !!}">
                    </div>
                </div><br>


                <br/>
                <!-- <div class="form-group text-center mt-4">
                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">   <label for="fileUpload">
                        @if(isset($category->cover))
                            <img id="imgPrime" src="{{ asset("storage/$category->cover") }}" height="150" width="150">
                        @else
                            <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                        @endif
                            <p class="m-2">Change Category feature image</p>
                        <input type="file" id="fileUpload" name="cover" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                        </label>
                        @if(isset($category->cover))
                        <a onclick="return confirm('Are you sure?')" href="{{ route('admin.category.remove.image', ['category' => $category->id]) }}" class="btn btn-danger">Remove image?</a>
                        @endif
                    </div>
                </div> -->
              
                <button type="submit" class="btn btn-success mt-4">Save</button>

            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
