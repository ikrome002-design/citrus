
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu mt-4">
         @if($user->type==1)
            <li class="treeview @if(request()->segment(3) == '') active @endif"><a href="{{ route('admin.staff_dashboard') }}"> <i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="treeview @if(request()->segment(2) == 'customer') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Customer</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.customers.list') }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <!-- <li><a href="{{ route('admin.customers.create_customer') }}" ><i class="fa fa-plus"></i> Create</a></li> -->
                </ul>
            </li>
            @endif
            
             @if($user->type==2)
            <li class="treeview @if(request()->segment(2) == 'subadmin') active @endif"><a href="{{ route('admin.subadmin_dashboard') }}"> <i class="fa fa-dashboard"></i> Dashboard</a></li>
           
            @endif
            
            @if($user->hasRole('superadmin'))
            <li class="treeview @if(request()->segment(2) == '') active @endif"><a href="{{ route('admin.dashboard') }}"> <i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="treeview @if(request()->segment(2) == 'business_type' || request()->segment(2) == 'business_type') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-briefcase"></i> <span>Business Type</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu"> 
                    <li><a href="{{ route('admin.business_type.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.business_type.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                 
                </ul> 
            </li>

            <li class="treeview @if(request()->segment(2) == 'categories' || request()->segment(2) == 'categories') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-list-alt"></i> <span>Categories</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                    <!--  <li><a href="{{ route('admin.categories.type', 1) }}"><i class="fa fa-circle-o"></i> Navigation Bar</a></li>
                    <li><a href="{{ route('admin.categories.type', 0) }}"><i class="fa fa-circle-o"></i> Other Category list</a></li> -->
                </ul> 

            </li>
            
            <li class="treeview @if(request()->segment(2) == 'subAdmin') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Subadmin</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('subadmin.subadmin_index') }}" ><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('subadmin.subadmin_create') }}" ><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li> 

            <li class="treeview @if(request()->segment(2) == 'vendors') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user-secret"></i> <span>Merchant</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li> <a  href="{{ route('admin.merchant.list') }}" ><i class="fa fa-circle-o"></i> List Merchant</a> 
                    </li>
                  
                </ul>
            </li>
            <li class=" @if(request()->segment(2) == 'customers' || request()->segment(2) == 'addresses') active @endif"><a  href="{{ route('admin.customers.index') }}"><i class="fa fa-user"></i> Customers</a></li>

             <li class=" @if(request()->segment(2) == 'contact-us' || request()->segment(2) == 'contact-us') active @endif"><a  href="{{ route('contact.list') }}"><i class="fa fa-address-book"></i> Contacts</a></li>

             <li class="treeview @if(request()->segment(2) == 'blog' || request()->segment(2) == 'blog') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-th-large"></i> <span>Blogs</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.blog.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.blog.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                 
                </ul> 
            </li>

            <li class="treeview @if(request()->segment(2) == 'testimonial' || request()->segment(2) == 'testimonial') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-comments" aria-hidden="true"></i> <span>Testimonial</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.testimonial.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.testimonial.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                 
                </ul> 
            </li>

               <li class="treeview @if(request()->segment(2) == 'banners' || request()->segment(2) == 'features') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-flag"></i> <span>Banner</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.banners.index') }}"><i class="fa fa-circle-o"></i> List Banner</a></li>
                    <li><a href="{{ route('admin.banners.create') }}"><i class="fa fa-circle-o"></i>Create  Banner </a></li>

                 </ul>
                 
            </li>

            @endif

            <!-- @if($user->hasRole('admin') || $user->hasRole('staff'))

            <li class="treeview @if(request()->segment(2) == 'staffVendorList' || request()->segment(2) == 'staffVendorCreate') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user-secret"></i> <span>Vendors</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview @if(request()->segment(2) == 'staffVendorList' || request()->segment(2) == 'staffVendorCreate') active @endif"><a href="{{ route('admin.staff.staffVendorList') }}"><i class="fa fa-circle-o"></i> List Vendor</a></li>
                    <li><a href="{{ route('admin.staff.staffVendorCreate') }}"><i class="fa fa-plus"></i> Create Vendor</a></li>
                </ul>
            </li>
           @endif

            @if($user->hasRole('superadmin'))
           <li class="treeview @if(request()->segment(2) == 'memberships') active @endif">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Plans</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.memberships.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.memberships.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li> 
            <li class="treeview @if(request()->segment(2) == 'taxes') active @endif">
                <a href="#">
                    <i class="fa fa-percent"></i> <span>Taxes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.taxes.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ route('admin.taxes.create') }}"><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>-->
             
             
          <!--   <li class="treeview @if(request()->segment(2) == 'products' || request()->segment(2) == 'attributes' ) active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-gift"></i> <span>Products</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if($user->hasPermission('view-product'))<li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i> List products</a></li>@endif
                  @if($user->hasPermission('create-product'))
                  <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i> Create product</a></li>
                  @endif
                </ul> 
            </li> --> 
            <!-- <li class="@if(request()->segment(2) == 'brands') active @endif"><a href="{{ route('admin.brands.index') }}"><i class="fa fa-tag"></i> Brands</a></li> -->

            <!-- <li class="@if(request()->segment(2) == 'brands') active @endif">
                    <a href="javascript:void(0)">
                        <i class="fa fa-tag"></i> <span>Brands</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                   <ul class="treeview-menu">
                        <li><a href="{{ route('admin.brands.index') }}"><i class="fa fa-circle-o"></i> List brands</a></li>
                        <li><a href="{{ route('admin.brands.create') }}"><i class="fa fa-plus"></i> Create brand</a></li>
                    </ul> 
                    </li> -->
           <!--  <li class="treeview @if(request()->segment(2) == 'product_reviews') active @endif">
                <a href="">
                    <i class="fa fa-star"></i> <span>Product Reviews</span></a>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
           

           

            <li class="treeview @if(request()->segment(2) == 'orders') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-anchor"></i> <span>Orders </span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
              <ul class="treeview-menu">
                    <li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i> List orders</a></li>
                  
                </ul> 
            </li>

             <li class="treeview @if(request()->segment(3) == 'transaction_report') active @endif"><a href="" ><i class="fa fa-dollar"></i> Transaction report</a></li>

              <li class="treeview @if(request()->segment(3) == 'transaction-History') active @endif"><a href=""><i class="fa fa-openid"></i> Transaction  history</a></li>
            
            <li class="treeview @if(request()->segment(2) == 'order-status') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-first-order"></i> <span>Order Status</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                 <ul class="treeview-menu">
                    <li><a href="{{ route('admin.order-status.index') }}"><i class="fa fa-circle-o"></i> List order status</a></li>
                    <li><a href="{{ route('admin.order-status.create') }}"><i class="fa fa-plus"></i> Create order status</a></li>
                </ul>
            </li>
            <li class="treeview @if(request()->segment(2) == 'banners' || request()->segment(2) == 'features') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-flag"></i> <span>Homepage Settings</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.banners.index') }}"><i class="fa fa-circle-o"></i> List Banner</a></li>
                    <li><a href="{{ route('admin.banners.create') }}"><i class="fa fa-circle-o"></i>Create  Banner </a></li>

                 </ul>
                 <ul class="treeview-menu">
                    <li><a href="{{ route('admin.features.index') }}"><i class="fa fa-circle-o"></i> List Feature</a></li>
                    <li><a href="{{ route('admin.features.create') }}"><i class="fa fa-circle-o"></i>Create  Feature </a></li>

                 </ul> 
            </li>  -->


            <!-- <li class="treeview @if(request()->segment(2) == 'couriers') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-truck"></i> <span>Couriers</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.couriers.index') }}"><i class="fa fa-circle-o"></i> List couriers</a></li>
                    <li><a href="{{ route('admin.couriers.create') }}"><i class="fa fa-plus"></i> Create courier</a></li>
                </ul>
            </li> -->

            

            <!-- <li class="treeview @if(request()->segment(2) == 'footers') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-link"></i> <span>Footers Settings</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.footers.index','type=0') }}"><i class="fa fa-circle-o"></i> MY ACCOUNT LINKS</a></li>
                    <li><a href="{{ route('admin.footers.index','type=1') }}"><i class="fa fa-circle-o"></i>LET US HELP LINKS</a></li>
                    <li><a href="{{ route('admin.footers.index','type=2') }}"><i class="fa fa-circle-o"></i> OTHER LINKS</a></li>
                 </ul>
                
            </li>  
            @endif
            @if($user->hasRole('admin') || $user->hasRole('staff'))
                <li class="treeview @if(request()->segment(2) == 'clients') active @endif"><a href="{{ route('admin.manage.client') }}"><i class="fa fa-users"></i> Manage Clients</a></li>
                <li class="treeview @if(request()->segment(2) == 'profile') active @endif"><a href="{{ route('admin.staffs.profile') }}"><i class="fa fa-cog"></i> My Profile</a></li>
            @endif -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

