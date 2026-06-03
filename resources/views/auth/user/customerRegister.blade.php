@extends('layouts.front.app')
@section('content')
<div class="contact_page_section_main">

 <div class="row">
   <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif

                    <form method="POST" action="{{ route('customer-account') }}">
                        {{ csrf_field() }}
                        <h3 class=""><b>Create Customer Account</b></h3><br>
                        <?php if($_SESSION['user_type']!=''){?>
                         <input type="hidden" name="user_type" value="{{ $_SESSION['user_type'] }}">
                         <?php }else{?>
                          <input type="hidden" name="user_type" value="{{ old('user_type') }}">
                         <?php }?>
                         
                      <input type="hidden" name="type" value="customer">
                      <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                          <label for="inputEmail4">Enter Your First Name</label>
                          <input type="text" class="form-control " id="first_name" placeholder="" name="first_name" value="{{ old('first_name') }}" required="">
                          @if($errors->has('first_name'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('first_name') }}
                                </div>
                                
                            @endif
                        </div>
                        <div class="form-group col-md-6 @error('last_name') is-invalid @enderror">
                          <label for="inputPassword4">Enter Your Last Name</label>
                          <input type="text" class="form-control " id="inputnew" placeholder="" name="last_name" value="{{ old('last_name') }}" required="">
                          @if($errors->has('last_name'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @endif
                        </div>
                      </div>

                        <div class="form-row">
                        <div class="form-group col-md-6 @error('email') is-invalid @enderror">
                         <label for="inputPassword4">Enter Your Email Address</label>
                          <input type="email" class="form-control " id="inputEmail4" placeholder="" name="email" required="" value="{{ old('email') }}">
                          @if($errors->has('email'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-6 @error('national_id') is-invalid @enderror">
                          <label for="inputEmail4">National ID</label>
                          <input type="text" class="form-control " id="national_id" placeholder="" name="national_id" required="" value="{{ old('national_id') }}">
                          @if($errors->has('national_id'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('national_id') }}
                                </div>
                            @endif
                        </div>
                          
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6 @error('phone_number') is-invalid @enderror">
                          <label for="inputCity">Enter Your Phone Number</label>
                          <input type="text" class="form-control " id="inputCity" name="phone_number" required="" value="{{ old('phone_number') }}">
                          @if($errors->has('phone_number'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputState">Country</label>
                          <select id="inputState" class="form-control" name="country" required="">
                            @foreach($countries as $country)
                            <option value="{{$country->id}}" >{{$country->name}}</option>
                            @endforeach
                          
                          </select>
                        </div>
                      </div>
                      
                      
                      <div class="form-row">
                        <div class="form-group col-md-6 @error('dob') is-invalid @enderror">
                          <label for="inputEmail4">Date Of Birth</label>
                          <input type="date" class="form-control " id="dob" placeholder="" name="dob" required="" value="{{ old('dob') }}">
                          @if($errors->has('dob'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('dob') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                         <label for="inputZip">Gender</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="gridCheck1" name="gender" value="0" checked="">
                          <label class="form-check-label" for="gridCheck">
                            Male
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="gridCheck2" name="gender" value="1">
                          <label class="form-check-label" for="gridCheck">
                            Female
                          </label>
                        </div>
                       </div> 
                      </div>
                      <div class="form-row">
                       
                        <div class="form-group col-md-6 @error('password') is-invalid @enderror">
                          <label for="inputEmail4">Password</label>
                          <input type="password" class="form-control " id="password" placeholder="" name="password" required="" value="{{ old('password') }}">
                          @if($errors->has('password'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group col-md-6 @error('password_confirmation') is-invalid @enderror">
                          <label for="inputEmail4">Confirm Password</label>
                          <input type="password" class="form-control" id="password_confirmation" placeholder="" name="password_confirmation" required="" value="{{ old('password_confirmation') }}">
                          @if($errors->has('password_confirmation'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>
                          
                      </div>
                     
                      <div class="form-group @error('agree') is-invalid @enderror">
                        <div class="form-check">
                          <input class="form-check-input " type="checkbox" id="gridCheck" name="agree" value="1" >
                          <label class="form-check-label" for="gridCheck">
                            Terms and conditions.
                          </label>
                          @if($errors->has('agree'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('agree') }}
                                </div>
                            @endif
                        </div>
                      </div>
                       <div class="row ">
                        <div class="col-12 text-center">
                          <button type="submit" name="submit" value="submit" class="btn btn-primary">Create Your Account</button>
                        </div>
                      </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
 $("input:checkbox").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
        
        $('#newsletter').val('0');
     
    }else{
        console.log($(this).val());
        $('#newsletter').val('1');
        
    }
}); 
</script>
@endsection