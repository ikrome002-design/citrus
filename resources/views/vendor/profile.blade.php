@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
<style type="text/css">
    .mr-2{
    margin-right: .5rem!important;
    padding: 11px 35px !important;
    background: #206080;
    color:#fff;
}

.mr-2:hover {color:#fff;}
</style>
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card vendor-profile shadow-sm p-4 rounded-lg" style="max-width:650px;">
            <form action="{{ route('vendor.profile.update') }}" method="post" class="form" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="avatar_old" value="{!! $vendor->avatar ?: old('avatar')  !!}">
                {{ csrf_field() }}
                <!-- Default box -->
               <div class="form-group text-center">
                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center d-inline-block p-4">   <label for="fileUpload">
                            @if($vendor->avatar !='')         
                                <img id="imgPrime" src="{{ asset( 'storage/profile/vendors/'.$vendor->avatar.'' ) }}" alt="{!! $vendor->name ?: old('name')  !!}" height="100" width="100"> 
                            @else
                                <img id="imgPrime" src="{{ asset('images/dummy-user.png')}}" alt="{!! $vendor->name ?: old('name')  !!}" height="100" width="100">
                            @endif
                            <p class="m-2">Change profile photo</p>
                        <input type="file" id="fileUpload" name="avatar" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
                         <span style="color:red;">* Image format - JPG/PNG</span>
                        </label>
                    </div>
                </div> 
               
          
                        <h2>Profile Details</h2>
                        <p class="text-muted">Detail</p>
                    
                      <div class="form-group">
                        <label for="inputAddress">Business Name</label>
                        <input type="text" class="form-control" name="business_name" value="{{ auth('vendor')->user()->business_name }}" required="">
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">First Name</label>
                        <input type="text" name="first_name" class="form-control" required="" value="{{ auth('vendor')->user()->first_name }}" >
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Last Name</label>
                        <input type="text" class="form-control" required="" name="last_name" value="{{ auth('vendor')->user()->last_name }}" >
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">Type of business</label>
                         <select id="inputState" class="form-control" name="business_type" readonly>
                          <option value="{{$vendor->bid}}" >{{$vendor->title}}</option>
                      
                          </select>
                        
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Email</label>
                        <input type="text" class="form-control" readonly="" value="{{ auth('vendor')->user()->email }}" >
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">Location of business</label>
                        <input type="text" class="form-control" required="" name="business_location" value="{{ auth('vendor')->user()->business_location }}" >
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">Phone number</label>
                        <input type="text" class="form-control" readonly="" value="{{ auth('vendor')->user()->phone_number }}" >
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Country</label>
                        <select id="inputState" class="form-control" name="country" >
                          <option value="{{$vendor->cid}}" >{{$vendor->cname}}</option>
                             @foreach($countries as $country)
                            <option value="{{$country->id}}" >{{$country->name}}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">Business about</label>
                        <input type="text" class="form-control" required="" name="business_about" value="{{ auth('vendor')->user()->business_about }}" >
                      </div>
                       <div class="form-group">
                        <label for="inputAddress">Citrus Merchant ID</label>
                        <input type="text" class="form-control" readonly="" value="{{ auth('vendor')->user()->citrus_merchant_id }}" >
                      </div>

                       <div class="form-group">
                        <label for="inputAddress">Role in company</label>
                    <?php if(auth('vendor')->user()->role==0){?>
                        <input type="text" class="form-control" readonly="" value="company administrator" >
                    <?php } if(auth('vendor')->user()->role==1){?>
                        <input type="text" class="form-control" readonly="" value="Employee" >
                    <?php } if(auth('vendor')->user()->role==2){?>
                          <input type="text" class="form-control" readonly="" value="Director/Owner" >
                    <?php }?>
                      </div>
                      
                   
                 
                <hr/>
                <div class="form-group">
                    <h4 class="card-sub-heading">Change password</h4>
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

                        <?php if(Request::segment(2)=='shops'){?>
  
                        <?php }else{?>
                        <a href="{{ route('vendor.dashboard') }}" class="btn mr-2"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp;Back</a>
                        <?php }?>
                        <button class="btn btn-success " type="submit"> <i class="fa fa-save"></i> Update</button>

                      

                    </div>
                </div>
                <!-- /.box -->
            </form>
        </div>

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