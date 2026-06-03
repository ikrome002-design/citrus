@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <h2 class="top-heading mb-4">Edit Vendor</h2>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm edit-vendor-body p-5 br-10" style="max-width:650px;">
            <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body edit-vendor-body">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="avatar_old" value="{!! $vendor->avatar ?: old('avatar')  !!}">
                    <input type="hidden" name="vendor_id" value="{!! $vendor->id ?: old('id')  !!}">
                    <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                @if($vendor->avatar !='')         
                                    <img id="imgPrime" src="{{ asset( 'storage/profile/vendors/'.$vendor->id.'/'.$vendor->avatar.'' ) }}" alt="{!! $vendor->name ?: old('name')  !!}" height="100" width="100"> 
                                @else
                                    <img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="{!! $vendor->name ?: old('name')  !!}" height="100" width="100">
                                @endif
                                <p class="m-2">Change profile photo</p>
                            <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group edit-vendor-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $vendor->name ?: old('name')  !!}">
                    </div>
                    <div class="form-group edit-vendor-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="{!! $vendor->email ?: old('email')  !!}">
                        </div>
                    </div>
                    <div class="form-group edit-vendor-group">
                        <label for="Number">Phone Number</label>
                        <input type="text" name="phone" id="Number" placeholder="Phone Number" class="form-control" value="{!! $vendor->phone ?: old('phone')  !!}">
                    </div>
                    <div class="form-group edit-vendor-group">
                        <label for="password">Change Password</label>
                        <input type="password" name="password" id="password" placeholder="xxxxx" class="form-control">
                    </div>
                    <div class="form-group edit-vendor-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="xxxxx" class="form-control">
                    </div>
                    <div class="form-group edit-vendor-group">
                        <input type="hidden" name="" ="role" id="role" value="3">
                    </div> 
                    @include('admin.shared.status-select', ['status' => $vendor->status])
                </div>

                <!-- /.card-body -->
                <div class="mt-5">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">Update Vendor</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.crad -->

    </section>
    <!-- /.content -->
@endsection
