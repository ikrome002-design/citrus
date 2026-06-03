@extends('layouts.front.app')
@section('content')
    <hr>
   <div class="container mt-5">
        <div class="row marchent-loginBox">
            <div class="card  col-xl-4 col-lg-6 col-md-8 col-sm-10 mx-auto form p-5 mt-5 rounded-0">
                 @if (session('success'))
                      <div class="alert alert-success alert-dismissable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h4><i class="icon fa fa-check fa-fw" aria-hidden="true"></i> Success</h4>
                        {{ session('success') }}
                      </div>
                      @endif 
                <div class="px-2">
                   <!-- <img src="{{ url('images/round-logo.svg') }}" alt="Italian Trulli" class="admin_login center mb-4"> -->
                   
                    <form action="{{ route('vendor.login') }}" method="post" class="justify-content-center">
                         {{ csrf_field() }}
                        <h2 class="card-heading  heading-primary" style="color:#206080; font-size:36px;font-weight: 500px;">Merchant Login</h2>
                        <p class="font-18 font-light mb-4 mt-2">Get access to your orders, manage your merchant profile, products and services.</p>
                         @include('layouts.errors-and-messages')
                        <div class="form-group">
                            <label class="sr-only">Email address</label>
                            <span>Email address</span>
                            <input name="email" type="email" id="email" class="form-control br-50 bg-light" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <span class="font-normal">Password</span>
                           <input name="password" type="password" id="password" class="form-control br-50 bg-light">
                           
                        </div>
                         <div class="form-group">
                            <div class="col-xs-12 vendor-login-box">
                                <!-- <a class="float-left text-primary-color" href="{{ route('vendor.resetpassword') }}"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Forgot your password</a><br> -->
                                <a href="{{route('register')}}" class="text-primary">No account? Register here.</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            </div>
                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection