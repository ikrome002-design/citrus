<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu mt-4">
            

<?php if(Request::segment(2)=='shops'){?>

             <li class="treeview @if(request()->segment(2) == 'dashboard' ||request()->segment(4) == 'dashboard') active @endif"><a href="{{ route('shop.dashboard', Request::segment(3)) }}"> <i class="fa fa-home"></i> Dashboard</a></li>

             <li class="treeview @if(request()->segment(4) == 'products' || request()->segment(3) == 'products' || request()->segment(2) == 'attributes' || request()->segment(2) == 'brands') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-gift"></i> <span>Products</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
               <ul class="treeview-menu">
                    <li><a href="{{ route('products.shop_index', Request::segment(3)) }}"><i class="fa fa-circle-o"></i> List products</a></li>
                    <li><a href="{{ route('products.shop_create', Request::segment(3)) }}"><i class="fa fa-plus"></i> Create product</a></li>
                </ul> 
            </li>
            <li class="treeview @if(request()->segment(4) == 'staffs') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('staffs.shop_staff_index', Request::segment(3)) }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('staffs.shop_create', Request::segment(3))}}" ><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>

            <li class="treeview @if(request()->segment(4) == 'customer') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>Customer</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('customers.shop_list', Request::segment(3)) }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('customers.shop_create', Request::segment(3)) }}" ><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>
             <li class="treeview @if(request()->segment(2) == 'orders' || request()->segment(4) == 'orders') active @endif"><a href="{{ route('shop.orders.index', Request::segment(3)) }}"><i class="fa fa-anchor"></i> Orders</a></li> 
        <?php }else{?>

            <li class="treeview @if(request()->segment(2) == 'dashboard' ||request()->segment(4) == 'dashboard') active @endif"><a href="{{ route('vendor.dashboard') }}"> <i class="fa fa-home"></i> Dashboard</a></li>
   
            <li class="treeview @if(request()->segment(2) == 'shop' || request()->segment(2) == 'shop') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-list-alt"></i> <span>Shop</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('shop.list') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('shop.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                 
                </ul> 

            </li>

            <li class="treeview @if(request()->segment(2) == 'products' || request()->segment(2) == 'attributes' || request()->segment(2) == 'brands') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-gift"></i> <span>Products</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
               <ul class="treeview-menu">
                    <li><a href="{{ route('products.index') }}"><i class="fa fa-circle-o"></i> List products</a></li>
                    <li><a href="{{ route('products.create') }}"><i class="fa fa-plus"></i> Create product</a></li>
                </ul> 
            </li>
            <li class="treeview @if(request()->segment(2) == 'staffs') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('staffs.staff_index') }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('staffs.create') }}" ><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li> 
             <li class="treeview @if(request()->segment(2) == 'customer') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>Customer</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('customers.list') }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('customers.create') }}" ><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'settings') active @endif"><a href="{{route('vendor.settings')}}"><i class="fa fa-cogs"></i> Business Profile</a></li>
             <li class="treeview @if(request()->segment(2) == 'orders' && request()->segment(3) == '') active @endif"><a href="{{ route('vendor.orders.index') }}"><i class="fa fa-anchor"></i> Orders</a></li>

             <li class="treeview @if(request()->segment(2) == 'sociallink') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-link"></i> <span>Social Link</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('sociallink.list') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('sociallink.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                 
                </ul> 

            </li>
         <?php }?>



            <!-- <li class="treeview @if(request()->segment(2) == 'plan') active @endif"><a href="{{ route('vendor.plan') }}"><i class="fa fa-trophy"></i> Plans</a></li> 
           

             <li class="treeview @if(request()->segment(2) == 'vendor_ratings') active @endif"><a href="{{ route('onlyvendor.ratings') }}"><i class="fa fa-stack-exchange"></i>Vendor Reviews</a></li>
             <li class="treeview @if(request()->segment(2) == 'ratings') active @endif"><a href=""><i class="fa fa-star"></i>Reviews</a></li>

            <li class="treeview @if(request()->segment(2) == 'orders' && request()->segment(3) == '') active @endif"><a href=""><i class="fa fa-anchor"></i> Orders</a></li>

            <li class="treeview @if(request()->segment(2) == 'orders' && request()->segment(3) == 'transaction_report') active @endif"><a href=""><i class="fa fa-dollar"></i> Transaction Report</a></li>
            
            <li class="treeview @if(request()->segment(2) == 'report') active @endif"><a href=""><i class="fa fa-pie-chart"></i> Sales Overview </a></li> -->
           

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

