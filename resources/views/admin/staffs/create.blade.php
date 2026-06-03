@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    <section class="container-fluid px-0">
        <h3>Create new Staff</h3>
       
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('staffs.store') }}" method="post" class="form" enctype="multipart/form-data">
                <div class="card-body">
                    {{ csrf_field() }}
                    <?php if(Request::segment(2)=='shops'){?>
                    <input type="hidden" name="shop_id" value="{{Request::segment(3)}}">
                    <?php }?>
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="citrus_merchant_id" value="{{auth('vendor')->user()->citrus_merchant_id}}">
                    <input type="hidden" name="merchant_id" value="{{auth('vendor')->user()->id}}">
                    <!-- <div class="form-group text-center">
                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="100" width="100">
                                <p class="m-2">Add profile photo</p>
                            <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                            </label>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter staff name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="email" id="email" placeholder="Enter staff email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Enter staff phone number" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" placeholder="xxxxx" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="role">Role<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control" name="role">
                                <option value="0">Product</option>
                                 <option value="1">Take away</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="password">About </label>
                        <textarea name="bio" id="bio" rows="6" class="form-control">{{ old('bio') }}</textarea> 
                    </div> -->
                     <!-- <input type="hidden" name="role" value="staff"> -->
                    @include('admin.shared.status-select', ['status' => 0])
                    <div class="box-footer mt-3">
                        <button type="submit" class="btn btn-success">Add Staff</button>
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
@else
@section('js')
<script type="text/javascript">
  
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif