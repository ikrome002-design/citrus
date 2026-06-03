@php($title = 'Login')
@extends('layouts.merchant.auth')
@section('content')
    <div class="container">
        <div class="row marchent-loginBox">
            <div class="row marchent-loginBox">
                <div class="card  col-xl-4 col-lg-6 col-md-8  mx-auto form py-5 mt-5 rounded-0">

                    <div class="row">
                        <div class="col-md-9 mx-auto">

                            <form action="{{ route('merchant.login.post') }}" method="post" class="justify-content-center">
                                @csrf
                                <h1 class="h2 card-heading  heading-primary text-secondary">
                                    Merchant Login</h2>
                                    <p class="font-18 font-light mb-4 mt-2">Get access to your orders, manage your merchant
                                        profile,
                                        products and services.</p>
                                    @include('layouts.errors-and-messages')
                                    <div class="form-group">
                                        <label class="sr-only">Email address</label>
                                        <span>Email address</span>
                                        <input name="email" type="email" id="email"
                                            class="form-control br-50 bg-light" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <span class="font-normal">Password</span>
                                        <input name="password" type="password" id="password"
                                            class="form-control br-50 bg-light">

                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 vendor-login-box">
                                            <a class="float-left text-primary-color"
                                                href="{{ route('password.request') }}"><i class="fa fa-unlock-alt"
                                                    aria-hidden="true"></i> Forgot your
                                                password</a><br>
                                            <a href="{{ route('merchant.register.get') }}" class="text-primary">No account?
                                                Register
                                                here.</a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign
                                                In</button>
                                        </div>

                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
