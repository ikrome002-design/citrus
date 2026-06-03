@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
        <h2>Categories</h2>
         @include('layouts.errors-and-messages')
       {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt varius diam, nec varius quam gravida et.</p>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="status" value="1">
                @if(isset(auth('employee')->user()->id))
                    <input type="hidden" name="created_by" value="{{auth('employee')->user()->id}}">
                    <input type="hidden" name="updated_by" value="{{auth('employee')->user()->id}}">
                @endif
                <div class="form-row">
                    <div class="col-sm-6">
                        <label for="parent">Parent Category</label>
                        <select name="parent" id="parent" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Category Name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group text-center mt-4">
                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">   <label for="fileUpload">
                            <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                            <p class="m-2">Add Category feature image</p>
                        <input type="file" id="fileUpload" name="cover" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Category Description </label>
                    <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-success mt-4">Add Category</button>

            </form>
        </div>--}}
        
        <div class="card shadow-sm p-4 rounded-lg mt-4">
        <!-- Default box -->
        @if($categories)
           <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>Category Name</td>
                            <td>Business Type</td>
                            <td>Created Date</td>
                           <!--  <td>Created By</td> -->

                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                <?php 
                                $parent_category=DB::table('business_type')->where('id', $category->parent_id)->first();?>
                              {{$parent_category->title}}
                            </td>
                            <td>
                               <?php echo date('d F Y', strtotime('-8 hours', strtotime($category->created_at))); ?>
                            </td>
                            <!-- <td>
                                @php $i=0;  @endphp
                                @foreach ($employees as $employee)
                                    @if($employee->id == $category->created_by)
                                        {{ $employee->id }}
                                        @php $i=1;  @endphp
                                    @endif
                                @endforeach
                                @if($i == 0)
                                    Super admin
                                @endif
                            </td> -->
                            <td>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        </div>
 
    </section>
    <!-- /.content -->
@endsection
