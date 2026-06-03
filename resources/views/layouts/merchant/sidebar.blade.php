<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu mt-4">
            <li class="treeview @if ((request()->segment(1) == 'dashboard') == 'dashboard') active @endif"><a
                    href="{{ route('vendor.dashboard') }}"> <i class="fa fa-home"></i> Dashboard</a></li>

            <li class="treeview @if (request()->segment(1) == 'branches') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-list-alt"></i> <span>Branches</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>

            </li>

            <li class="treeview @if (request()->segment(1) == 'products') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-gift"></i> <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List products</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create product</a></li>
                </ul>
            </li>
            <li class="treeview @if (request()->segment(1) == 'staffs') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-list"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>

            </li>
            <li class="treeview @if (request()->segment(1) == 'orders') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview @if (request()->segment(1) == 'payments') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>Payments</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview @if (request()->segment(1) == 'refunds') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>Refunds</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>
            <li class="treeview @if (request()->segment(2) == 'customers') active @endif">

                <a href="javascript:void(0)">
                    <i class="fa fa-user"></i> <span>Customers</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>
                </ul>
            </li>


            <li class="treeview @if (request()->segment(2) == 'sociallink') active @endif">
                <a href="javascript:void(0)">
                    <i class="fa fa-link"></i> <span>Social Link</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href=""><i class="fa fa-plus"></i> Create</a></li>

                </ul>

            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
