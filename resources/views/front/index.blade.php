@extends('layouts.front.app')
@section('content')
    <section id="banner" class="banner">
        <div class="container">
            <div class="owl-carousel owl-theme d-block">
                @foreach ($banner_contents as $banner)
                    <div class="item">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-lg-6 col-12">
                                <div class="slide-content">
                                    <h2>{{ $banner->title }}</h2>

                                    <h3 class="mt-3 mb-2">{{ $banner->subtitle }}</h3>
                                    <p>{{ $banner->description }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-12">
                                <div class="slide-img">
                                    <figure><img src="{{ asset('storage/banners/' . $banner->banner_image . '') }}">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <section id="categorie-box" class="categorie-box">
        <div class="container">
            <div class="row py-5">
                <div class="col-md-12 col-lg-12 col-xl-12 text-center pt-4">
                    <div class="categorie-text">
                        <h2 class="blue-heading mb-3">Categories</h2>
                        <p class="custom-p">There are a lot of categories in which you can sell or buy your desired
                            products services. We hope you will get maximum from our side. Enjoy!</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12 text-center">
                    <ul class="categorie-list">
                        @foreach ($business_types as $business_type)
                            <li><a href="javascript:void(0)">{{ $business_type->title }}</a></li>
                        @endforeach
                    </ul>
                    <div class="slider-arrow">
                        <div class="bar-head">
                            <div class="bar-inner"></div>
                            <div class="arrow">
                                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chevron-down"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                    class="svg-inline--fa fa-chevron-down fa-w-14 fa-3x">
                                    <path fill="currentColor"
                                        d="M441.9 167.3l-19.8-19.8c-4.7-4.7-12.3-4.7-17 0L224 328.2 42.9 147.5c-4.7-4.7-12.3-4.7-17 0L6.1 167.3c-4.7 4.7-4.7 12.3 0 17l209.4 209.4c4.7 4.7 12.3 4.7 17 0l209.4-209.4c4.7-4.7 4.7-12.3 0-17z"
                                        class="">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="readyBox" class="readyBox my-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6 col-12">
                    <div class="readyBox-text">
                        <h2 class="font-45 font-bold text-white mb-3">Ready To Do It Your Way?</h2>
                        <p class="text-white">We’re busy putting the finishing touches on a truley unique
                            experiance
                            that will set you free to do anything.Want Instant Updates</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-12 text-center">
                    <a class="blue-bt" href="{{ route('login') }}">Login Now</a>
                </div>
            </div>
        </div>
    </section>
    <section id="discoveredbox" class="discovered">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <figure><img class="w-100" src="{{ asset('assets/images1/slide.png') }}"></figure>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="discovered-content">
                        <h2 class="text-orange font-16 font-weight-light">We Have, We’ve Built It</h2>
                        <h3 class="font-bold text-black mb-2">Discovered The Future Of Shopping Yet?</h3>
                        <p>Shopping is about having fun, enjoying yourself, and taking life easy. It’s why we’ve
                            built a
                            powerful system that allows you to do exactly that:</p>
                        <ul class="list-unstyled mt-5">
                            <li class="media mb-4">
                                <figure><i class="fa fa-shopping-bag"></i></figure>
                                <div class="media-body pl-4 pt-2">
                                    <h5 class="mt-0 mb-1 font-weight-bold text-black">Search Any Shop</h5>
                                    <p>Using an exclusive Citrus I.D. and QR code</p>
                                </div>
                            </li>
                            <li class="media my-4">
                                <figure><i class="fa fa-edit"></i></figure>
                                <div class="media-body pl-4 pt-2">
                                    <h5 class="mt-0 mb-1 font-weight-bold text-black">Bag Your Products</h5>
                                    <p>Without having to set foot in the store</p>
                                </div>
                            </li>
                            <li class="media">
                                <figure><i class="fa fa-paper-plane"></i></figure>
                                <div class="media-body pl-4 pt-2">
                                    <h5 class="mt-0 mb-1 font-weight-bold text-black">Pay Instantly</h5>
                                    <p>Online and get a receipt sent via email or Whatsapp</p>
                                </div>
                            </li>
                        </ul>
                        <h4 class="mt-5">Ready For The Future?</h4>
                        <p>From the moment you get started, you won’t shop any other way.</p>
                        <a class="site-bt mt-3" href="javascript:void(0)">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="serviceBox" class="service-box">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6 col-12">
                    <h2 class="blue-heading">Manage Your Sales</h2>
                    <p class="custom-p">Manage your sale from single dashboard.</p>
                </div>
                <div class="col-md-6 col-lg-6 col-12">
                    <figure><img class="w-100" src="{{ asset('assets/images1/dashboard.png') }}"></figure>
                </div>
            </div>
            <div class="row align-items-center my-5">
                <div class="col-md-6 col-lg-6 col-12">
                    <figure><img class="w-100" src="{{ asset('assets/images1/manage.png') }}"></figure>
                </div>
                <div class="col-md-6 col-lg-6 col-12">
                    <h2 class="blue-heading">Manage Your Business</h2>
                    <p class="custom-p mt-2 mb-3">When it’s all about keeping your customers happy, there’s nothing
                        better than giving them exactly what they want.Not sure what that is? We already know</p>
                    <ul>
                        <li><strong>-Instant Online Payments</strong> make every transaction effortless</li>
                        <li><strong>-Paperless Functionality</strong> simplifies everything with a single click</li>
                        <li><strong>-Flexible Options</strong> allow you to accept PayPal, VISA, MasterCard and more
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6 col-12">
                    <h2 class="blue-heading">Checkout Your Goods</h2>
                    <p class="custom-p">Manage inventory, add stock manage item prices from inventory section.</p>
                </div>
                <div class="col-md-6 col-lg-6 col-12">
                    <figure><img class="img-fluid" src="{{ asset('assets/images1/checkout.png') }}"></figure>
                </div>
            </div>
        </div>
    </section>
    <section id="testimony" class="testimony">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center mb-5">
                    <h2 class="blue-heading pb-3">Testimonials</h2>
                </div>
                <div class="col-md-12 col-lg-12 col-12">
                    <div class="owl-carousel owl-theme testimony-slide">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimony-content text-center">
                                    <figure><img src="{{ asset('storage/testimonial/' . $testimonial->image . '') }}">
                                    </figure>
                                    <p class="custom-p">{{ $testimonial->description }}</p>
                                    <strong>{{ $testimonial->title }}</strong>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="Blogbox" class="blog-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                    <p class="sec_text">BLOG</p>
                    <h2 class="blue-heading mb-2">Our Blog</h2>
                    <p class="custom-p mb-5">Far far away, behind the word mountains, far from the countries
                        Vokalia
                        and Consonantia</p>
                </div>
                @foreach ($blogs as $blog)
                    <?php $mydate = $blog->created_at;
                    $month = date('F', strtotime($mydate));
                    $date = date('d', strtotime($mydate));
                    $year = date('Y', strtotime($mydate));
                    ?>
                    <div class="col-md-6 col-lg-4 col-xl-4 col-12">
                        <div class="card border-0">
                            <img class="card-img-top" src="{{ asset('storage/blog/' . $blog->image . '') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <div class="blog-date text-center">
                                    <strong>{{ $date }}</strong>
                                    <p>{{ $month }} &nbsp; {{ $year }}</p>
                                </div>
                                <h2 class="card-title">{{ $blog->title }}</h2>
                                <p class="card-text">{{ $blog->description }}</p>
                                <!-- <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-0">
                             <div class="card-bt"><a class="site-bt " href="javascript:void(0)">Read More</a></div>
                             <div class="card-links">
                             <a href="javascript:void(0)">glasoft</a>
                             <a href="javascript:void(0)">3</a>
                             </div>
                             </div> -->
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section id="contactBox" class="contactBox">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-12 px-0">
                    <div class="contactBox-text">
                        <h2 class="getTouch">Get In Touch</h2>
                        <p class="contactText mb-5 mt-2">Far far away, behind the word mountains, far from the
                            countries Vokalia and Consonantia</p>
                        <div class="contactaddress">
                            <div class="contact-tileBox">
                                <h3>ADDRESS</h3>
                                <p>JKUAT Towers, 17th floor, Kenyatta Avenue, Nairobi, Kenya. P.O. Box 15168 -
                                    00400,
                                    Nairobi.</p>
                            </div>
                            <div class="contact-tileBox">
                                <h3>CONTACT NUMBER</h3>
                                <a href="tel:254205157073">+254 20 5157073</a>
                            </div>
                            <div class="contact-tileBox">
                                <h3>EMAIL ADDRESS</h3>
                                <a href="mailto:info@yoursite.com">info@yoursite.com</a>
                            </div>
                            <div class="contact-tileBox">
                                <h3>WEBSITE</h3>
                                <a href="javascript:void(0)">yoursite.com</a>
                            </div>
                        </div>
                        <form method="post" action="{{ route('contact.form') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6 col-12 pr-lg-0">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Your Name" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email"
                                            placeholder="Your Email" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="subject" placeholder="Subject"
                                            value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" placeholder="Message" name="message" required=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">Send
                                            Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-12 px-0">
                    <div class="contactMap h-100">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319"
                            frameborder="0" style="border:0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
