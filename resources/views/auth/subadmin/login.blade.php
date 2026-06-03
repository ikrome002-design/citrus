<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
</head>
<body class="hold-transition skin-purple login-page">
    <div class="container mt-5">
        <div class=" row text-black adminLogin-box">
            <div class="card col-xl-4 col-lg-6 col-md-8 col-sm-10 mx-auto form p-4 mt-5 rounded-0">
                <div class="px-2">
                   <!-- <img src="{{ url('images/round-logo.svg') }}" alt="Italian Trulli" class="admin_login center mb-4"> -->
                    
                    <form action="{{ route('admin.subadmin_login') }}" method="post" class="justify-content-center">
                      
                         {{ csrf_field() }}
                        <h2 class="card-heading mb-3 text-center text-primary" style="font-size:36px;font-weight: 500px;">Sub-Admin Login </h2>
                      @include('layouts.errors-and-messages')
                        <div class="form-group">
                            <label class="sr-only">Email address</label>
                            <span class="mb-2 ml-2">Email address</span>
                            <input name="email" type="email" id="email" class="form-control br-50 bg-light" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <span class="font-normal mb-2 ml-2">Password</span>
                            <input name="password" type="password" id="password" class="form-control br-50 bg-light">
                        </div>
                         <!-- <div class="row mb-3 ml-1">
                            <div class="col-xs-12 text-center">
                             <a class="float-right text-primary-color" href="">Forgot your password</a><br>
                            </div>
                        </div> -->
                        <div class="row pb-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block br-50 btn-flat">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
</body>
</html>