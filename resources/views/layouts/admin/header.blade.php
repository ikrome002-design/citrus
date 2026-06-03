
<header class="main-header">
    <!-- Logo -->
      @if(Request::segment(2) =='staff')
    <a href="javascript:void(0)" class="logo">
         @elseif(Request::segment(2) =='subadmin')
          <a href="javascript:void(0)" class="logo">
         @else
         <a href="{{route('admin.dashboard')}}" class="logo">
             @endif
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><!-- <img class="admin-logo" src="{{ asset('images/buy-logo.png')}}" alt="BuyVI"> --> 
              @if(Request::segment(2) =='staff')
            <p style="color: #fff; font-size:25px;">Citrus Staff</p></span>
             @elseif(Request::segment(2) =='subadmin' )
              <p style="color: #fff; font-size:25px;">Citrus Subadmin</p></span>
            @else
            <p style="color: #fff; font-size:25px;">Citrus Admin </p></span>
            @endif
            
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
   
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
            <li class="dropdown user user-menu">
                     @if(Request::segment(2) =='staff')
                     
                     @elseif(Request::segment(2) =='subadmin')
                      <?php $notify=DB::table("vendor_msg")->where('reply_id', NULL)->where('read_status', '0')->count();?>
                            @if($notify==0)
                           <a href="{{ route('subadmin.vendors.messages') }}" class="btnn">  
                              <span class="fa fa-bell"></span>  
                              <span class="badge">{{$notify}}</span>  
                            </a>
                            @else
                            <a href="{{ route('subadmin.admin_notification') }}" class="btnn">  
                              <span class="fa fa-bell"></span>  
                              <span class="badge">{{$notify}}</span>  
                            </a>
                            @endif
                     @else
                         <?php $notify=DB::table("vendor_msg")->where('reply_id', NULL)->where('read_status', '0')->count();?>
                                @if($notify==0)
                               <a href="{{ route('admin.vendors.messages') }}" class="btnn">  
                                  <span class="fa fa-bell"></span>  
                                  <span class="badge">{{$notify}}</span>  
                                </a>
                                @else
                                <a href="{{ route('admin.admin_notification') }}" class="btnn">  
                                  <span class="fa fa-bell"></span>  
                                  <span class="badge">{{$notify}}</span>  
                                </a>
                                @endif
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     @endif
                    <a href="javascript:void(0)" class="text-white" data-toggle="dropdown">
                        @if($user->avatar !='')         
                            <img class="user-image1" src="{{ asset( 'storage/profile/users/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                        @else
                            <img class="user-image1" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                        @endif
                         Hi,<span class="hidden-xs">{{ $user->name }}</span>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu mt-3">
                        <!-- User image -->
                        <li class="user-header bg-dark">
                            @if($user->avatar !='')         
                                <img class="card-img-top img-fluid" src="{{ asset( 'storage/profile/users/'.$user->avatar.'' ) }}" alt="{!! $user->name ?: old('name')  !!}"> 
                            @else
                                <img class="card-img-top img-fluid" src="{{ asset('images/dummy-user.png')}}" alt="{!! $user->name ?: old('name')  !!}">
                            @endif

                            <p>
                                {{ $user->name }}
                                <small>Member since {{ date('m Y', strtotime($user->created_at)) }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                @if(Request::segment(2) =='staff')
                                <a href="{{ route('admin.staff_profile') }}" class="btn btn-info btn-flat">Profile</a>
                                 @elseif(Request::segment(2) =='subadmin')
                                 <a href="{{ route('admin.subadmin_profile') }}" class="btn btn-info btn-flat">Profile</a>
                                @else
                                 <a href="{{ route('admin.staffs.profile') }}" class="btn btn-info btn-flat">Profile</a>
                                 @endif
                            </div>
                            <div class="pull-right">
                                @if(Request::segment(2) =='staff')
                                <a href="{{ route('staff.logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                                @elseif(Request::segment(2) =='subadmin')
                                <a href="{{ route('subadmin.logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                                @else
                                <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>