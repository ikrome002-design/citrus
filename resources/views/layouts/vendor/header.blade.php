  
<header class="main-header">
    <!-- Logo -->
    <a href="{{route('vendor.dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">C</span>
        <!-- logo for regular state and mobile devices -->
         <span class="logo-lg"><!-- <img src="{{ asset('images/buy-logo.png')}}" alt="Citrus" width="150px;" height="50px;"> --> <p style="color: #fff; font-size:25px;">Citrus </p></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <?php 
         $notify=DB::table("vendor_msg")->where('vendor_id', auth('vendor')->user()->id)->where('status', 'replied')->where('read_status', '1')->count();?>
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <?php if(Request::segment(2)=='shops'){
                ?>
               <li class="dropdown user user-menu">
            
                @if($notify==0)
               <a href="" class="btnn">  
                  <span class="fa fa-bell"></span>  
                  <span class="badge">{{$notify}}</span>  
                </a>
                @else
                <a href="" class="btnn">  
                  <span class="fa fa-bell"></span>  
                  <span class="badge">{{$notify}}</span>  
                </a>
                @endif

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if($user->avatar !='')         
                            <img class="user-image1" src="{{ asset( 'storage/profile/vendors/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                        @else
                            <img class="user-image1" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                        @endif
                        <span class="hidden-xs">{{ $user->first_name }}</span>
                    </a>
                    <ul class="dropdown-menu login-dropdown">
                        <!-- User image -->
                        <li class="user-header p-0">
                            @if($user->avatar !='')         
                                <img class="card-img-top img-fluid" src="{{ asset( 'storage/profile/vendors/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                            @else
                                <img class="card-img-top img-fluid" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                            @endif
                             </li>
                            <h3 class="text-dark text-center font-18">
                                {{ $user->first_name }}
                                <small class="d-block font-13">Member since {{ date('m Y', strtotime($user->created_at)) }}</small>
                            </h3>
                       
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('vendor.shop_profile', Request::segment(3)) }}" class="btn btn-success btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('vendor.logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>


                <?php }else{?> 

                
                <li class="dropdown user user-menu">
            
                @if($notify==0)
               <a href="{{ route('vendor.vendor_messages') }}" class="btnn">  
                  <span class="fa fa-bell"></span>  
                  <span class="badge">{{$notify}}</span>  
                </a>
                @else
                <a href="{{ route('vendor.notification') }}" class="btnn">  
                  <span class="fa fa-bell"></span>  
                  <span class="badge">{{$notify}}</span>  
                </a>
                @endif

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if($user->avatar !='')         
                            <img class="user-image1" src="{{ asset( 'storage/profile/vendors/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                        @else
                            <img class="user-image1" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                        @endif
                        <span class="hidden-xs">{{ $user->first_name }}</span>
                    </a>
                    <ul class="dropdown-menu login-dropdown">
                        <!-- User image -->
                        <li class="user-header p-0">
                            @if($user->avatar !='')         
                                <img class="card-img-top img-fluid" src="{{ asset( 'storage/profile/vendors/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                            @else
                                <img class="card-img-top img-fluid" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                            @endif
                             </li>
                            <h3 class="text-dark text-center font-18">
                                {{ $user->first_name }}
                                <small class="d-block font-13">Member since {{ date('m Y', strtotime($user->created_at)) }}</small>
                            </h3>
                       
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('vendor.profile') }}" class="btn btn-success btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('vendor.logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php }?>
            </ul>
        </div>
    </nav>
</header>