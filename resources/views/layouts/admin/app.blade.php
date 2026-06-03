<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=500, initial-scale=1">    

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">

    @yield('css')
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/muteweb_fav_icon.png')}}">
    <link rel="manifest" href="{{ asset('favicons/manifest.json')}}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
     #map {
  height: 400px;
  /* The height is 400 pixels */
  width: 100%;
  /* The width is the width of the web page */
}
#floating-panel {
  position: absolute;
  top: 10px;
  left: 25%;
  z-index: 5;
  background-color: #fff;
  padding: 5px;
  border: 1px solid #999;
  text-align: center;
  font-family: "Roboto", "sans-serif";
  line-height: 30px;
  padding-left: 10px;
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

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

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
    @include('layouts.admin.header', ['user' => $admin])
    @include('layouts.admin.sidebar', ['user' => $admin])
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include("layouts.admin.breadcumb")
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.admin.footer')
    @include('layouts.admin.control-sidebar')
</div>
<!-- <script>
      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 8,
          center: { lat: -34.397, lng: 150.644 },
        });
        const geocoder = new google.maps.Geocoder();
        document.getElementById("submit").addEventListener("click", () => {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        const address = document.getElementById("address").value;
        geocoder.geocode({ address: address }, (results, status) => {
          if (status === "OK") {
            
            resultsMap.setCenter(results[0].geometry.location);
            new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location,
            });
          } else {
            alert(
              "Geocode was not successful for the following reason: " + status
            );
          }
        });
      }
    </script>
    
     <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZLCR1GwLM-2tHesCyfX2IOYULNyVKAi0&callback=initMap&libraries=&v=weekly"
      async
    ></script> -->
   
<script src="{{ asset('js/vendor.min.js') }}"></script>
<script src="{{ asset('js/admin-scripts.js?v=0.2') }}"></script>
@yield('js')
</body>
</html>
