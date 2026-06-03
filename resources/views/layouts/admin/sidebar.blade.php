<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar position-fixed top-0 bottom-0" style="overflow-y:auto">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar ">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu mt-4">

            <li class="treeview @if (request()->segment(2) == '') active @endif"><a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="treeview @if (request()->segment(2) == 'accountTypes' ||
                    request()->segment(2) == 'plans' ||
                    request()->segment(2) == 'backOfficePlans' ||
                    request()->segment(2) == 'branchPlans' ||
                    request()->segment(2) == 'teamLinkPlans') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-list-alt"></i> <span>Accounts & Plans</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li> <a href="{{ route('admin.account.types.index') }}"><i
                                class=" me-1 fa fa-check-square"></i>Account Types</a>
                    </li>
                    <li> <a href="{{ route('admin.plans.index') }}"><i class=" me-1 fa fa-check-square"></i>Main
                            Plans</a>
                    </li>
                    <li> <a href="{{ route('admin.plans.index') }}"><i class=" me-1 fa fa-check-square"></i>Branch
                            Plans
                            Plans</a>
                    </li>
                    <li> <a href="{{ route('admin.plans.index') }}"><i class=" me-1 fa fa-check-square"></i>Team
                            Link
                            Plans</a>
                    </li>
                    <li> <a href="{{ route('admin.plans.index') }}"><i class=" me-1 fa fa-check-square"></i>Back
                            Office
                            Plans</a>
                    </li>

                </ul>
            </li>

            <li class="treeview @if (request()->segment(2) == 'business_type' || request()->segment(2) == 'categories') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-briefcase"></i> <span>Categories & Business</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.business_type.index') }}"><i class="fa-regular fa-building"></i>
                            Business Types</a>
                    </li>
                    <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-list"></i> Categories </a></li>
                </ul>
            </li>

            <li class="treeview @if (request()->segment(2) == 'subAdmin') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Subadmin</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.subadmin_index') }}"><i class="fa fa-circle"></i> List</a></li>
                    <li><a href="{{ route('admin.subadmin_create') }}"><i class="fa fa-plus"></i> Create</a>
                    </li>
                </ul>
            </li>

            <li class="treeview @if (request()->segment(2) == 'vendors') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user-secret"></i> <span>Merchant</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li> <a href="{{ route('admin.merchant.list') }}"><i class="fa fa-circle"></i> List
                            Merchant</a>
                    </li>

                </ul>
            </li>
            <li class=" @if (request()->segment(2) == 'customers' || request()->segment(2) == 'addresses') active @endif"><a
                    href="{{ route('admin.customers.index') }}"><i class="fa fa-user"></i> Customers</a></li>

            <li class=" @if (request()->segment(2) == 'contact-us' || request()->segment(2) == 'contact-us') active @endif"><a href="{{ route('contact.list') }}"><i
                        class="fa fa-address-book"></i> Contacts</a></li>

            <li class="treeview @if (request()->segment(2) == 'blog' || request()->segment(2) == 'blog') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-th-large"></i> <span>Blogs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.blog.index') }}"><i class="fa fa-circle"></i> List</a></li>
                    <li><a href="{{ route('admin.blog.create') }}"><i class="fa fa-plus"></i> Create</a></li>

                </ul>
            </li>

            <li class="treeview @if (request()->segment(2) == 'testimonial' || request()->segment(2) == 'testimonial') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-comments" aria-hidden="true"></i> <span>Testimonial</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.testimonial.index') }}"><i class="fa fa-circle"></i> List</a>
                    </li>
                    <li><a href="{{ route('admin.testimonial.create') }}"><i class="fa fa-plus"></i> Create</a>
                    </li>

                </ul>
            </li>

            <li class="treeview @if (request()->segment(2) == 'roles' || request()->segment(2) == 'permissions') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-tasks"></i> <span>Roles</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.banners.index') }}"><i class="fa fa-circle"></i>Roles</a>
                    </li>
                    <li><a href="{{ route('admin.banners.create') }}"><i class="fa fa-circle"></i>Permissions
                        </a></li>

                </ul>

            </li>


            <li class="treeview @if (request()->segment(2) == 'banners' || request()->segment(2) == 'features') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-flag"></i> <span>Banner</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.banners.index') }}"><i class="fa fa-circle"></i> List Banner</a>
                    </li>
                    <li><a href="{{ route('admin.banners.create') }}"><i class="fa fa-circle"></i>Create Banner
                        </a></li>

                </ul>

            </li>
        </ul>
    </section>

</aside>
