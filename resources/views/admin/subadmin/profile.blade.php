
@extends('layouts.admin.app')

@section('content')

@if($employee->type==1 || $employee->type==2)

<!-- Main content -->
    <section class="content">
        <h2 class="top-heading mb-4">@if($employee->type==1) Staff Profile @else  Subadmin Profile @endif</h2>
        @include('layouts.errors-and-messages')
        <div class="user-profile-box">
           @if($employee->type==1)
           <form action="{{ route('admin.staffs.profile.staff_update') }}" method="post" class="form" enctype="multipart/form-data">
           @else
           <form action="{{ route('admin.subadmin.profile.subadmin_update') }}" method="post" class="form" enctype="multipart/form-data">
           @endif
            <div class="row">
                <div class="col-md-12 col-lg-3 col-12">
                    <div class="form-group text-center">
                        <div id="userActions" class="roundewd-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                @if($employee->avatar !='')         
                                    <img id="imgPrime" class="w-100" style="" src="{{ asset( 'storage/profile/users/'.$employee->avatar.'' ) }}" alt="{!! $employee->name ?: old('name')  !!}" > 
                                @else
                                    <img id="imgPrime" class="w-100" style="" src="{{ asset('images/dummy-user.png')}}" alt="{!! $employee->name ?: old('name')  !!}" height="100" width="100">
                                @endif
                                <p class="m-2">Change profile photo</p>
                            <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-12">
                   <div class="profile-info">
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="avatar_old" value="{!! $employee->avatar ?: old('avatar')  !!}">
                        {{ csrf_field() }}
                            <table class="table">
                              <tbody>
                                <tr>                              
                                  <td>Name</td>
                                  <td> <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $employee->name ?: old('name')  !!}"></td>
                                </tr>
                                <tr>                              
                                  <td>Email</td>
                                  <td><input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{!! $employee->email ?: old('email')  !!}"></td>
                                </tr>
                                 <tr>                              
                                  <td>Phone Number</td>
                                  <td><input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control" value="{!! $employee->phone ?: old('phone')  !!}"></td>                          
                                </tr>
                                <tr>
                                    <td colspan="2" align="content">
                                        <div class="form-group">
                                            <h4>Change password</h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Your Password</td>
                                    <td><input type="password" name="old-password" id="old-password" placeholder="xxxxx" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>New Password</td>
                                    <td><input type="password" name="password" id="password" placeholder="xxxxx" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Confirm Password</td>
                                    <td><input type="password" name="confirm-password" id="confirm-password" placeholder="xxxxx" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right" ><button class="btn btn-success btn-sm" type="submit"> <i class="fa fa-save"></i> Update</button></td>
                                </tr>
                              </tbody>
                            </table>
                        <!-- </form> -->
                   </div>
                </div>
                </form>
            </div>
        </div>
    </section>
@else
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">

            <form action="{{ route('admin.staffs.profile.update') }}" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="avatar_old" value="{!! $employee->avatar ?: old('avatar')  !!}">
                {{ csrf_field() }}

                <div class="form-group text-center">
                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                            @if($employee->avatar !='')         
                                <img id="imgPrime" src="{{ asset( 'storage/profile/users/'.$employee->avatar.'' ) }}" alt="{!! $employee->name ?: old('name')  !!}" height="100" width="100"> 
                            @else
                                <img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="{!! $employee->name ?: old('name')  !!}" height="100" width="100">
                            @endif
                            <p class="m-2">Change profile photo</p>
                        <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $employee->name ?: old('name')  !!}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{!! $employee->email ?: old('email')  !!}" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="Contact Number" class="form-control" value="{!! $employee->phone ?: old('phone')  !!}">
                </div>
                <hr/>
                <div class="form-group">
                    <h4>Change password</h4>
                </div>
                <div class="form-group">
                    <label for="old-password">Your Password</label>
                    <input type="password" name="old-password" id="old-password" placeholder="xxxxx" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" placeholder="xxxxx" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="xxxxx" class="form-control">
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <button class="btn btn-success btn-sm" type="submit"> <i class="fa fa-save"></i> Update</button>
                    </div>
                </div>
                <!-- /.box -->
            </form>
        </div>

    </section>
    <!-- /.content -->
@endif
@endsection
