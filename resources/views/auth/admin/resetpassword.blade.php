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
        <div class=" row text-black ">
            <div class="card col-xl-4 col-lg-6 col-md-8 col-sm-10 mx-auto form p-4 mt-5 rounded-0">
                 
                <div class="px-2">
                   <img src="{{ url('images/round-logo.svg') }}" alt="Italian Trulli" class="admin_login center mb-4">
                    <form action="{{ route('admin.resetpassword') }}" method="post" class="justify-content-center">
                        @include('layouts.errors-and-messages')
                         {{ csrf_field() }}
                        <h2 class="font-600 text-primary-color">Reset your password</h2>
                        <div class="form-group has-feedback">
                            <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group has-feedback mb-3 text-center">
                            <div class="col-xs-12">
                              <button type="submit" class="btn btn-primary btn-block btn-flat">Get New Password</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <a class="" href="{{ route('admin.login') }}" class="text-center"><i class="fa fa-arrow-left" aria-hidden="true"></i> Login here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <!-- /.login-box -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
</body>
</html>