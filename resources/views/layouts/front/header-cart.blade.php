<!-- new header -->
<!-- <div class="top-bar py-2">
  <div class="container">
      <div class="row">
          <div class="col-12 text-center text-white tw">
              <p class="text-uppercase"><a href="{{ route('vendor.register') }}">Sign up and Become a Vendor Today</a></p>
          </div>
      </div>
  </div>
</div> -->
<!-------------------------------header Start Here------------------------------->
<header>
  <div class="container-fluid top-nav mt-4 text-center" id="loading1">
      <div class="header-inner">
          <div class="logo-box" >                        
              <a href="{{ route('home') }}"><img src="{{ asset('assets/images1/logo.png')}}" style="width:119px; height:36px;"></a>                        
          </div>
          <div class="top-search-bar order-xs-3">
          
          </div>
          <div class="top-account-box order-xs-2" >
              <ul style="padding-right:52px;" >
                @if(auth()->check())
                <li>
                    <a class="user-account" href="{{ route('accounts', ['tab' =>'v-pills-account-details']) }}"><i class="fa fa-user-o"></i><span class="d-none d-md-block">Account</span></a>
                </li>
                <li>
                    <a class="user-logout" href="{{ route('logout') }}"><i class="fa fa-sign-out"></i><span class="d-none d-md-block">Logout</span></a>
                </li>

                <li>
                     <a class="wishlist" href="{{ route('wishlist_detail') }}"><i class="fa fa-heart-o"></i><span class="d-none d-md-block">Lists</span></a>
                </li>

                 <li>
                    <a class="cart" href="{{ route('cart.index') }}"><span class="badge badge-pill cart-count">{{ $cartCount }}</span><i class="fa fa-shopping-cart"></i><span class="d-none d-md-block">Cart</span></a>
                </li> 
                @else
                <li class="user-login">
                    <a href="{{ route('login') }}"> <i class="fa fa-lock"></i> <span class="d-none d-md-block">Login</span></a>
                </li>
                    <li class="user-login">
                        <a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> <span class="d-none d-md-block">Register</span></a>
                    </li>


                @endif
               
               
            </ul>
          </div>
      </div>
      
  </div>
</header>
<!-- new header-->
<div id="notification-bar">
    <div>
        <p id="notMsg"></p>
    </div> 
</div>


