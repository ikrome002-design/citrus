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

                    <form method="POST" action="{{ route('vendor.create-account') }}">
                        {{ csrf_field() }}
                        <h3 class=""><b>Create Merchant Account</b></h3><br>
                        <?php if($_SESSION['user_type']!=''){?>
                         <input type="hidden" name="user_type" value="{{ $_SESSION['user_type'] }}">
                         <?php }else{?>
                          <input type="hidden" name="user_type" value="{{ old('user_type') }}">
                         <?php }?>
                          <?php if($_SESSION['account_type']!=''){?>
                          <input type="hidden" name="account_type" value="{{ $_SESSION['account_type'] }}">
                          <?php }else{?>
                          <input type="hidden" name="account_type" value="{{ old('account_type') }}">
                          <?php }?>
                      <div class="form-group @error('business_name') is-invalid @enderror">
                        <label for="inputAddress">Business Name</label>
                        <input type="text" class="form-control " id="inputAddressfg" placeholder="" name="business_name" value="{{ old('business_name') }}" required="">
                        @if($errors->has('business_name'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('business_name') }}
                                </div>
                            @endif
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6 @error('first_name') is-invalid @enderror">
                          <label for="inputEmail4">Enter Your First Name</label>
                          <input type="text" class="form-control " id="first_name" placeholder="" name="first_name" required="" value="{{ old('first_name') }}">
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

                       <div class="form-group @error('business_type') is-invalid @enderror">
                        
                          <label for="inputEmail4">Type Of Business</label>
                          <select id="inputState" class="form-control" name="business_type" required="">
                             @foreach($business_types as $business_type)
                            <option value="{{$business_type->id}}" >{{$business_type->title}}</option>
                            @endforeach
                          </select>
                          @if($errors->has('business_type'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('business_type') }}
                                </div>
                            @endif
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
                        <div class="form-group col-md-6 @error('password') is-invalid @enderror">
                          <label for="inputEmail4">Password</label>
                          <input type="password" class="form-control " id="password" placeholder="" name="password" required="" value="{{ old('password') }}">
                          @if($errors->has('password'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                          
                      </div>
                      
                      <div class="form-group @error('business_location') is-invalid @enderror">
                        <label for="inputAddress2">Location Of Business<span style="color:red"> *(Full address required )</span></label>
                        <input type="text" class="form-control " id="inputAddress2" placeholder="" name="business_location" required="" value="{{ old('business_location') }}">
                        @if($errors->has('business_location'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('business_location') }}
                                </div>
                            @endif
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
                        <div class="form-group @error('business_about') is-invalid @enderror">
                          <label for="inputZip">What is your business about?</label>
                          <textarea type="text" class="form-control " id="inputZip" name="business_about" >{{ old('business_about') }}</textarea>
                          @if($errors->has('business_about'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('business_about') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                         <label for="inputZip">What's your role at this company?</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="gridCheck1" name="role" value="0" checked="">
                          <label class="form-check-label" for="gridCheck">
                            Company administrator
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="gridCheck2" name="role" value="1">
                          <label class="form-check-label" for="gridCheck">
                            Employee
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="gridCheck3" name="role" value="2">
                          <label class="form-check-label" for="gridCheck">
                            Director/Owner
                          </label>
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