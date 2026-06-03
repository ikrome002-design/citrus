<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="footer-logo-box text-md-center">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <figure><img class="w-100" src="{{ asset("images/header_logo.svg") }}" alt="footer Logo" /></figure>
                    </a>
                    <ul class="footer-social-media">
                        <li><a target="_blank" href="https://www.facebook.com/BuyVi.ca"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/BuyVanIsland"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a target="_blank" href="https://www.instagram.com/buyvi.ca/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <h2 class="footer-heading">MY ACCOUNT</h2>
                <nav class="footer-links">
                    <ul>
                        @foreach($my_account as $my_account_data)
                        <li><a href="{{$my_account_data->link}}">{{$my_account_data->title}}</a></li>
                        @endforeach
                    </ul>                       
                </nav>
            </div>
            <div class="col">
                <h2 class="footer-heading">LET US HELP</h2>
                <nav class="footer-links">
                    <ul>
                        @foreach($let_us as $let_us_data)
                        <li><a href="{{$let_us_data->link}}">{{$let_us_data->title}}</a></li>
                         @endforeach
                    </ul>
                </nav>
            </div>
            <div class="col">
                <h2 class="footer-heading">OTHER LINKS</h2>
                <nav class="footer-links">
                    <ul>
                       @foreach($other_link as $other_link_data)
                        <li><a href="{{$other_link_data->link}}">{{$other_link_data->title}}</a></li>
                        
                         @endforeach
                    </ul>
                </nav>
            </div>
            <div class="col">
                <div class="footer-subscribe">
                    <h2 class="footer-heading">Subscribe to our newsletter</h2>
                        <p>stay up to date with our exclusive newsletter!</p>
                        @if(session()->has('message1'))
                            <div class="box no-border">
                                <div class="box-tools">
                                    <p class="alert alert-success alert-dismissible">
                                      {{ session()->get('message1') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </p>
                                </div>
                            </div>
                        @elseif(session()->has('error1'))
                            <div class="box no-border">
                                <div class="box-tools">
                                    <p class="alert alert-danger alert-dismissible">
                                        {{ session()->get('error1') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </p>
                                </div>
                            </div>
                        @endif
                        <form action="#" method="post" id="subscription_form">
                          
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="email" name="email" class="newsletter-input subscribe-form-control" placeholder="Your email address" value="" oninvalid="this.setCustomValidity('Enter email id')" oninput="foremail(this)" required>
                            <span id="error_message" style="color:red;"></span>
                            <br>
                            <button class="btn btn-primary" id="Subscribe" type="button">Subscribe Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12 text-center">
                    <p><strong>Copyright &copy; {{ date('Y') }} - {{ date('Y') + 1 }} <a href="{{config('app.url')}}">{{config('app.name')}}</a>.</strong> All rights reserved.</p>

                </div>
            </div>
        </div>
    </div>
</footer>


