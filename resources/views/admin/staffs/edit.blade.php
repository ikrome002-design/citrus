@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    <section class="container-fluid">
        <h3 class="mb-3">Edit Staff</h3>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('staffs.update', $employee->id) }}" method="post" class="form" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="avatar_old" value="{!! $employee->avatar ?: old('avatar')  !!}">
                    <input type="hidden" name="staff_id" value="{!! $employee->id ?: old('id')  !!}">
                <!--     <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                @if($employee->avatar !='')         
                                    <img id="imgPrime" src="{{ asset( 'storage/profile/users/'.$employee->id.'/'.$employee->avatar.'' ) }}" alt="{!! $employee->name ?: old('name')  !!}" height="100" width="100"> 
                                @else
                                    <img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="{!! $employee->name ?: old('name')  !!}" height="100" width="100">
                                @endif
                                <p class="m-2">Change profile photo</p>
                            <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                            </label>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $employee->name ?: old('name')  !!}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{!! $employee->email ?: old('email')  !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Number">Phone Number</label>
                        <input type="text" name="phone" id="Number" placeholder="Phone Number" class="form-control" value="{!! $employee->phone ?: old('phone')  !!}">
                    </div>
                    <!-- <div class="form-group">
                        <label for="password">Change Password</label>
                        <input type="password" name="password" id="password" placeholder="xxxxx" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="xxxxx" class="form-control">
                    </div> -->
                   <!--  <div class="form-group">
                        <label for="password">About </label>
                        <textarea name="bio" id="bio" rows="6" class="form-control">{!! $employee->bio ?: old('bio')  !!}</textarea> 
                    </div> -->
                    <div class="form-group ">
                        <label for="role">Role </label>
                         <select name="role" id="role" class="form-control " >
                            @if($employee->role == 0 )
                              
                                    <option value="{{ $employee->role }}">Product</option>
                                     <option value="1">Take away</option>
                                @else
                                <option value="{{ $employee->role }}">Take away</option>
                                     <option value="0">Product</option>

                                 
                            @endif 
                           
                        </select>
                    </div> 
                   <p>Status <span class="text-danger">*</span></p>
                   @if($employee->status == 1 )
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Active" value="1" checked>
                        <label class="form-check-label" for="Active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Inactive" value="0">
                        <label class="form-check-label" for="Inactive">Inactive</label>
                    </div>
                    @else
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Active" value="1" >
                        <label class="form-check-label" for="Active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="Inactive" value="0" checked>
                        <label class="form-check-label" for="Inactive">Inactive</label>
                    </div>
                    @endif
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Update Staff</button>
                    </div>
                </div>

                <!-- /.card-body -->
                
                {{ csrf_field() }}
            </form>
        </div>
        <!-- /.card -->

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