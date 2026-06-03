  <!DOCTYPE html>
  <html lang="{{ app()->getLocale() }}">

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ config('app.name') }}</title>

      @yield('css')
      <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
      <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
      <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
      <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
      <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
      <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
      <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
      <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
      <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png') }}">
      <meta name="theme-color" content="#ffffff">
      <link rel="stylesheet" href="/assets/css/vendor.min.css">
      <link rel="stylesheet" href="/assets/vendor/DataTables/datatables.min.css">
      <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
      <link rel="stylesheet" href="/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
      <link rel="stylesheet" href="/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css">
      <link rel="stylesheet" href="/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.css">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/owl.carousel.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/responsive.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/fontawesome/all.min.css') }}">
      <style type="text/css">
          #datepicker>span:hover {
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

          .navbar-nav>.user-menu .user-image1 {
              width: 25px;
              height: 25px;
              border-radius: 50%;
              margin-right: 10px;
              margin-top: -2px;
          }
      </style>
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


          @include('layouts.merchant.header')
          @include('layouts.merchant.sidebar')

          <!-- Content Wrapper. Contains page content -->

          <div class="content-wrapper">

              @include('layouts.merchant.breadcumb')

              @yield('content')
          </div>
          @include('layouts.merchant.footer')


          <!-- /.content-wrapper -->

      </div>

      <script src="/assets/js/vendor.min.js"></script>
      <script src="/assets/vendor/DataTables/datatables.min.js"></script>
      <script src="/assets/vendor/DataTables/Buttons-2.4.1/js/buttons.bootstrap5.min.js"></script>
      <script src="/assets/vendor/DataTables/buttons.server-side.min.js"></script>
      <script src="/assets/js/custom-vendor.min.js"></script>

      @yield('js')

  </body>

  </html>
