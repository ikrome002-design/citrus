  
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">     
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
  
    @yield('css')
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('favicons/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <style type="text/css">
    
    #datepicker > span:hover{
    cursor: pointer;
    }
    </style>
    <style>  
.btnn {  
  color: white;  
  text-decoration: none;   
  position: relative;  
  display: inline-block;  
  border-radius: 2px;  
}  
.btnn:hover {  
   background: red;  
}    
.btnn .badge {  
   position: absolute;  
  top: -10px;  
  right: -10px;   
  border-radius: 50%;  
  background-color: red;  
  color: white;  
}  
.navbar-nav > .user-menu .user-image1 {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: -2px;
}
</style>
<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js">
      </script>
      <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart']});     
      </script>
</head>
<body class="hold-transition skin-purple sidebar-mini">
<noscript>
    <p class="alert alert-danger">
        You need to turn on your javascript. Some functionality will not work if this is disabled.
        <a href="https://www.enable-javascript.com/" target="_blank">Read more</a>
    </p>
</noscript>
<!-- Site wrapper -->
 
<div class="wrapper">
 
  @if(Session::get('plans_in')!=0)
   @include('layouts.vendor.header', ['user' => $vendor])
    @include('layouts.vendor.sidebar', ['user' => $vendor])
  @endif
 
    <!-- Content Wrapper. Contains page content -->

 @if(Session::get('plans_in')!=0)
    <div class="content-wrapper">
 
        @include("layouts.vendor.breadcumb")

        @yield('content')
    </div>
     @include('layouts.vendor.footer')
 @else
  @yield('content')
 
  @endif
 
    <!-- /.content-wrapper -->
   
</div>

<!-- ./wrapper -->
<script src="{{ asset('js/vendor.min.js') }}"></script>

@yield('js')
<script src="{{ asset('js/admin-scripts.js') }}"></script>
</body>
</html>
