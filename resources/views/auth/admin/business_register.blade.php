<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.min.css') }}">
</head>
<body class="hold-transition skin-purple login-page">
    <div class="login-box">
        <div class="login-logo">
        </div>
        <!-- /.login-logo -->
        @include('layouts.errors-and-messages')
        <div class="login-box-body">
             <img src="{{ url('images/muteweb_logo.svg') }}" alt="Italian Trulli" class="admin_login">
            <h3 class="font-weight-bold">Create your Seller Account</h3>
            <div class="box">
                 <h1>Business Details</h1>
            <form action="{{ route('admin.business.register') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Business Name <span class="text-danger">*</span></label>
                        <input type="text" name="business[business_name]" id="business_name" placeholder="Business Name" class="form-control" value="{{ old('business_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="office_address">Office Address <span class="text-danger">*</span></label>
                         <input type="text" name="office_address" id="office_address" placeholder="Office Address" class="form-control" value="{{ old('office_address') }}">
                                           </div>
                    <div class="form-group">
                        <label for="logo">Business Logo <span class="text-danger">*</span></label>
                        <input type="file" name="business_logo" id="business_logo" placeholder="Logo" class="form-control">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.login') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('js/admin.min.js') }}"></script>
</body>
</html>