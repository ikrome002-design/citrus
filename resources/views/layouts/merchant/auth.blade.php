  <!DOCTYPE html>
  <html lang="{{ app()->getLocale() }}">

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ $title ?? config('app.name') }}</title>
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
      @include('partial.css')
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/owl.carousel.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/responsive.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/fontawesome/all.min.css') }}">
      @yield('css')
  </head>

  <body class="hold-transition skin-purple sidebar-mini">
      <noscript>
          <p class="alert alert-danger">
              You need to turn on your javascript. Some functionality will not work if this is disabled.
              <a href="https://www.enable-javascript.com/" target="_blank">Read more</a>
          </p>
      </noscript>

      <div class="my-3">

          <div id="app">
              <header>
                  <div class="container">
                      <div class="row align-items-center">

                          <div class="col-4 align-items-center">
                              <a href="{{ env('APP_URL') }}"><img src="{{ asset('assets/images1/logo.png') }}"
                                      alt="Logo" class="img-fluid"></a>
                          </div>
                          <div class="col-8 text-end">

                              <a href="{{ route('merchant.register.get') }}" class="me-3 btn-primary btn">Register</a>
                              <a href="{{ route('merchant.login') }}" class="me-3">Login</a>

                          </div>
                      </div>
                      </ </header>
                      <main class="py-4">
                          @yield('content')
                      </main>
                  </div>
              </header>
          </div>
      </div>


      @include('partial.js')
      <script src="/assets/js/custom-vendor.min.js"></script>

      @yield('js')

  </body>

  </html>
