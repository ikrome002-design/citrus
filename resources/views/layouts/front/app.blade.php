@php($description = 'Citrus is best marketpalce for sellers and buyers')
@php($title = $title ?? config('app.name'))
@php($header_image = $header_image ?? config('app.url') . '/assets/images1/logo.png')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ $title }}</title>
    <meta name="description" content="{{ $description }} ">
    <meta name="keywords" content="seel online, buy online,">
    <meta name="author" content="Citrus">

    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link rel="icon" type="image" href="{{ asset('assets/images1/favicon.png') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css1/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/fontawesome/all.min.css') }}">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images1/faviocn.png') }}">
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/images1/faviocn.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- facebook -->
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $header_image }}" />
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:description" content="{{ $description }}" />
    <meta name="twitter:image" content=" {{ $header_image }}" />
    @yield('css')

    <link rel="canonical" href="{{ url()->current() }}">
    @yield('og')
</head>

<body>
    <header>
        <div class="container py-1">
            <!-- Large screen header -->
            <div class="d-none d-lg-block ">
                <div class="row align-items-center sticky-top">
                    <div class="col-lg-1">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images1/logo.png') }}"
                                alt="Logo" class="img-fluid"></a>
                    </div>
                    <div class="col-lg-8">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded-start-pill "
                                            placeholder="Search for products">
                                        <button class="btn btn-primary" style="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4">
                                <button class="btn-primary btn">Search by Merchant ID / Name</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-end">
                        @if (auth()->check())
                            <div class="dropdown d-inline-block me-3">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Become a Seller </a></li>
                                    <li><a class="dropdown-item" href="#">Sign in as a Seller </a></li>
                                    <li><a class="dropdown-item" href="#">Log out</a></li>
                                </ul>
                            </div>
                        @else
                            <div class="dropdown d-inline-block me-3">
                                <a class="dropdown-toggle btn btn-primary" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Register
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Register
                                            as
                                            Customer</a></li>
                                    <li><a class="dropdown-item" href="{{ route('vendor.register.get') }}">Register
                                            as Merchant </a></li>
                                </ul>
                            </div>
                            <a href="#" class="me-3">Login</a>
                        @endif
                        <a href="#" class="position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="bg-primary text-white header-total-items">3</span>
                        </a>
                    </div>
                </div>

                <div class="row mt-2 nav-links-header">

                    <div class="col border-top">
                        <nav>
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Home <span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#serviceBox">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Blogbox">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#banner">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#testimony">Testimony</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#contactBox">Contact</a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Medium and Small screen header -->
            <div class="d-lg-none sticky-top">
                <div class="row align-items-center">
                    <div class="col-1">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>
                    <div class="col-3 align-items-center">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images1/logo.png') }}"
                                alt="Logo" class="img-fluid"></a>
                    </div>
                    <div class="col-8 text-end px-0">
                        @if (auth()->check())
                            <div class="dropdown d-inline-block me-3">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Become a Seller </a></li>
                                    <li><a class="dropdown-item" href="#">Sign in as a Seller </a></li>
                                    <li><a class="dropdown-item" href="#">Log out</a></li>
                                </ul>
                            </div>
                        @else
                            <a href="#" class="me-3 btn-primary btn">Register</a>
                            <a href="#" class="me-3">Login</a>
                        @endif
                        <a href="#" class="position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="bg-primary text-white header-total-items">3</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">

                        <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNav"
                            aria-labelledby="navbarNavLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="navbarNavLabel"><a href="{{ route('home') }}"><img
                                            src="{{ asset('assets/images1/logo.png') }}" alt="Logo"
                                            class="img-fluid"></a></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('home') }}">Home <span
                                                class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#serviceBox">Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#Blogbox">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#banner">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#testimony">Testimony</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#contactBox">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 nav-links-header">
                    <div class="row">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="mb-3">
                                    <form action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded-start-pill "
                                                placeholder="Search for products">
                                            <button class="btn btn-primary" style="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <button class="btn-primary btn btn-sm">Search or Scan Merchant ID /
                                        Name</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <body>
        @if ($errors->any() || session('success') || session('warning') || session('info'))
            <div class="fixed-top-messages w-100 text-center">
                @include('partial.error-messages')
            </div>
        @endif
        @include('layouts.front.header-cart')

        @yield('content')

        <footer class="siteFooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-3 col-xl-3 col-12">
                        <div class="siteFlogo">
                            <a href="{{ route('home') }}">
                                <figure><img src="{{ asset('assets/images1/logo.png') }}"></figure>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3 col-12">
                        <div class="footer-tileBox">
                            <h2>About Us</h2>
                            <p>Rendamised HTML Version Out Now 11 Mins ago</p>
                        </div>
                        <div class="footer-tileBox">
                            <h2>FAQ</h2>
                            <p>Rendamised HTML Version Out Now 11 Mins ago</p>
                        </div>
                        <div class="footer-tileBox">
                            <h2>Testimonials</h2>
                            <p>Rendamised HTML Version Out Now 11 Mins ago</p>
                        </div>
                        <div class="footer-tileBox">
                            <h2>Services</h2>
                            <p>Rendamised HTML Version Out Now 11 Mins ago</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3 col-12">
                        <div class="footerBlog">
                            <ul class="list-unstyled">
                                <li class="media">
                                    <div class="fotrBlogDate">
                                        <p><span>23</span>APR</p>
                                    </div>
                                    <div class="media-body">
                                        <p>Rendamised Wards Which Don't Look eveable.</p>
                                    </div>
                                </li>
                                <li class="media my-4">
                                    <div class="fotrBlogDate">
                                        <p><span>23</span>APR</p>
                                    </div>
                                    <div class="media-body">
                                        <p>Rendamised Wards Which Don't Look eveable.</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="fotrBlogDate">
                                        <p><span>23</span>APR</p>
                                    </div>
                                    <div class="media-body">
                                        <p>Rendamised Wards Which Don't Look eveable.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3 col-12">
                        <div class="footerQuestion">
                            <h2 class="mb-3">Ask Away</h2>
                            <p style="color: #e8622e; font-weight: 600;">Love it</p>
                            <p>Write your testimonials</p>
                        </div>
                    </div>
                </div>
                <div class="row Footerbottom">
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                        <p>© 2021 Citrus Labs Limited. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>

        <!--------------------------- Script Area --------------------------->
        <script src="{{ asset('assets/js1/bootstrap.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="{{ asset('assets/js1/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js1/custom.js') }}"></script>
        <script src="{{ asset('assets/lib/fontawesome/all.min.js') }}"></script>
        @include('sweetalert::alert')
        <script src="{{ asset('js/front.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        @yield('js')
        <script>
            var url = ''
            url = '<?php echo url(''); ?>'
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <script>
            $(document).ready(function() {
                jQuery(document).ready(function() {
                    jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
                    jQuery(".colors a").click(function() {
                        if ($(this).attr("class") != "default") {
                            $("#jquery-accordion-menu").removeClass();
                            $("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(
                                this).attr("class"));
                        } else {
                            $("#jquery-accordion-menu").removeClass();
                            $("#jquery-accordion-menu").addClass("jquery-accordion-menu");
                        }
                    });
                });
            });

            eval(function(p, a, c, k, e, d) {
                e = function(c) {
                    return c
                };
                if (!''.replace(/^/, String)) {
                    while (c--) {
                        d[c] = k[c] || c
                    }
                    k = [function(e) {
                        return d[e]
                    }];
                    e = function() {
                        return '\\w+'
                    };
                    c = 1
                };
                while (c--) {
                    if (k[c]) {
                        p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c])
                    }
                }
                return p
            }('94(61(54,52,50,53,51,55){51=61(50){64(50<52?\'\':51(95(50/52)))+((50=50%52)>35?68.98(50+29):50.97(36))};73(!\'\'.70(/^/,68)){71(50--){55[51(50)]=53[50]||51(50)}53=[61(51){64 55[51]}];51=61(){64\'\\\\59+\'};50=1};71(50--){73(53[50]){54=54.70(109 96(\'\\\\56\'+51(50)+\'\\\\56\',\'57\'),53[50])}}64 54}(\'86(31(54,52,50,53,51,55){51=31(50){32(50<52?\\\'\\\':51(91(50/52)))+((50=50%52)>35?34.39(50+29):50.84(36))};38(!\\\'\\\'.37(/^/,34)){33(50--){55[51(50)]=53[50]||51(50)}53=[31(51){32 55[51]}];51=31(){32\\\'\\\\\\\\59+\\\'};50=1};33(50--){38(53[50]){54=54.37(125 83(\\\'\\\\\\\\56\\\'+51(50)+\\\'\\\\\\\\56\\\',\\\'57\\\'),53[50])}}32 54}(\\\'219(63(54,52,50,53,51,55){51=63(50){60(50<52?\\\\\\\'\\\\\\\':51(220(50/52)))+((50=50%52)>218?99.217(50+29):50.22(21))};74(!\\\\\\\'\\\\\\\'.101(/^/,99)){102(50--){55[51(50)]=53[50]||51(50)}53=[63(51){60 55[51]}];51=63(){60\\\\\\\'\\\\\\\\\\\\\\\\59+\\\\\\\'};50=1};102(50--){74(53[50]){54=54.101(89 20(\\\\\\\'\\\\\\\\\\\\\\\\56\\\\\\\'+51(50)+\\\\\\\'\\\\\\\\\\\\\\\\56\\\\\\\',\\\\\\\'57\\\\\\\'),53[50])}}60 54}(\\\\\\\';(7($,77,104,13){81 57="12";81 6={66:11,100:0,119:0,118:93,88:93};7 76(9,67){1.9=9;1.221=$.103({},6,67);1.10=6;1.14=57;1.87()};$.103(76.15,{87:7(){1.92();1.106();8(6.88){1.59()}},92:7(){$(1.9).5("225").58("19").113("112 111",7(51){51.18();51.16();8($(1).5(".3").54>0){8($(1).5(".3").80("17")=="223"){$(1).5(".3").116(6.100).213(6.66);$(1).5(".3").56("52").115("3-50-65");8(6.118){$(1).56().5(".3").120(6.66);$(1).56().5(".3").56("52").72("3-50-65")}117 202}203{$(1).5(".3").116(6.119).120(6.66)}8($(1).5(".3").56("52").199("3-50-65")){$(1).5(".3").56("52").72("3-50-65")}}77.205.108=$(1).5("52").210("108")})},106:7(){8($(1.9).58(".3").54>0){$(1.9).58(".3").56("52").206("<53 124=\\\\\\\\\\\\\\\'3-50\\\\\\\\\\\\\\\'>+</53>")}},59:7(){81 4,55,79,75;$(1.9).58("52").113("112 111",7(51){$(".4").248();8($(1).5(".4").54===0){$(1).250("<53 124=\\\\\\\\\\\\\\\'4\\\\\\\\\\\\\\\'></53>")}4=$(1).58(".4");4.72("121-4");8(!4.78()&&!4.69()){55=262.260($(1).259(),$(1).257());4.80({78:55,69:55})}79=51.247-$(1).110().107-4.69()/2;75=51.237-$(1).110().105-4.78()/2;4.80({105:75+\\\\\\\\\\\\\\\'114\\\\\\\\\\\\\\\',107:79+\\\\\\\\\\\\\\\'114\\\\\\\\\\\\\\\'}).115("121-4")})}});$.242[57]=7(67){1.240(7(){8(!$.122(1,"123"+57)){$.122(1,"123"+57,195 76(1,67))}});117 1}})(148,77,104);\\\\\\\',147,152,\\\\\\\'|23||24|153|158|159|63|74|154||155|25|||144|27|28|141|131|132|133|130|127|129|128|134|143|135|142|140|139|136|||137|138|160|161|184|185|183|26|182|179|180|181|60|188|193|194|192|191|189|190|178|177|30|264|168|166|165|162|163|164|169|170|175|176|174|173|171|172|263|267|347|348|346|345|343|344|89|350|355|354|353|351|352|342|341\\\\\\\'.332(\\\\\\\'|\\\\\\\'),0,{}))\\\',82,333,\\\'||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||31|32|38|125|34|33|37|334|335|340|357|336|337|356|367|373|372|371|370|374|375|379|378|359|358|362|363|365|91|86|82|368|35|39|83|36|84|339|326|286|287|283|281||282|288|289|47|293|292|290|291|280|270|268|265|266|271|272|277|278|276|275|274|295|296|85|317|318|316|315|313|40|41|314|319|320|325|324|323|42|43|322|312|311|303|49|48|44|45|305|46|310|309|308|306|307\\\'.85(\\\'|\\\'),0,{}))\',62,284,\'|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||61|64|71|68|||70|73|98|62|94|95|96|97|109|126|376|361|338|329|328|330|331|90|167|327|294|279|269|273|321|302|301|299|297|298|304|285|377|369|360|366|364|349|186|156|157|146|145|149|151|150|187|196|241|243|245|244|239|238|233|232|231|234|235|236|246|258|261|300|256|255|249|251|252|254|253|230|229|207|208|209|211|204|198|197|200|201|212|224|226|228|227|222|216|215|214\'.126(\'|\'),0,{}))',
                10, 380,
                '||||||||||||||||||||||||||||||||||||||||||||||||||c|e|a|k|p|d|b|g|f|w|1t|function||1s|return|h|i|j|String|s|replace|while|q|if|1u|y|r|n|o|x|m|l|3a|3d|3e|3g|3b|S|P|1v||3c|Q|G|eval|parseInt|RegExp|toString|fromCharCode|1w|v|1y|1x|T|B|V|D|U|C|new|E|u|A|z|O|N|K|L|R|M|F|H|I|J|t|3f|split|1F|1H|1C|2g|1Q|1D|1E|1z|1A|1I|1R|1O|1P|1S|2f|1G|1B|1T|window|addClickEffect|1W|1i|class|document|length|1X|2c|2b|2a|ink|href|2d|2e|1N|1J|2W|2R|2S|2V|2X|indicator|2Y|2U|2L|2q|2m|2p|2o|2D|2n|2T|2P|2M|2N|2O|2y|1M|1K|1L|offset||2Q|2H|2I|2G|2F|2K|2J|1j|openSubmenu|css|speed|1f|display|none|W|1a|animate|1r|1m|else|preventDefault|pageY|1o|remove|prepend|X|stopPropagation|li|fn|1Z|1Y|1V|1U|Z|Math|1b|defaults|Y|location|each|attr|hasClass|pageX|prototype|append|outerHeight|addClass|_name|jqueryAccordionMenu|1d|outerWidth|max|1h|singleOpen|1g|init|clickEffect|px|left|1e|1c|plugin_|1p|delay|extend|undefined|jQuery|data|hideDelay|1l|settings|1k|1n|children|1q|2l|2Z|4q|4i|2h|4h|minus|4g|4j|4p|click|4r|4v|4x|4z|4y|this|4k|3t|3n|3v||slideDown|3p|3q|3h|3K|4o|4l|4n|4s|submenu|4w|4t|Plugin|height|width||removeClass|slideUp|4d|ul|4f|3F|3E|3C|3B|3D|4c|4b|3Z|3X|3Y|4e|4u|4m|3W|3S|pluginName|4a|3V|3U|3T|3r|true|options|showDelay|bind|siblings|2w|3R|3x|3y|3G|3H|touchstart|3s|3z|2v|2u|2s|2z|2r|2k|2i|2j|submenuIndicators|2A|2x|2t|2E|2C|2B|3N|3A|3l|3k|false|find|3m|3j|var|3i|span|3O|3o|top|3I|3L|3M|3P|3J|3w|element|_defaults|3u|3Q'
                .split('|'), 0, {}))
        </script>
    </body>

</html>
