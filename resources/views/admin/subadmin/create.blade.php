
@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    <section class="container-fluid px-0">
        <h3>Create new Subadmin</h3>
       
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('subadmin.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="card-body">
                    {{ csrf_field() }}
                   
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="role" value="2">
                    
                   
                      
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter subadmin name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="email" id="email" placeholder="Enter subadmin email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Enter subadmin phone number" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" placeholder="xxxxx" class="form-control">
                    </div>
                  
                     <div class="form-group">
                        <label for="password">About </label>
                        <textarea name="bio" id="bio" rows="6" class="form-control" required="">{{ old('bio') }}</textarea> 
                    </div>
                    <div class="form-group">
                        <label for="name">Upload Image<span class="text-danger">*</span></label>
                        <input type="file" name="avatar" class="form-control" value="" required="">
                    </div>
                     <!-- <input type="hidden" name="role" value="staff"> -->
                    @include('admin.shared.status-select', ['status' => 0])
                    <div class="box-footer mt-3">
                        <button type="submit" class="btn btn-success">Add Subadmin</button>
                    </div>
                </div>
                <!-- /.box-body -->
                
            </form>
        </div>
        <!-- /.box -->
        </section>
    </section>
    <!-- /.content -->
@endsection


