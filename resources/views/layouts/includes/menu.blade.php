<!-- User menu -->
<div class="sidebar-user">
    <div class="category-content">
        <div class="media">
            <a href="#" class="media-left"><img src="{{ asset('admin_assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
            <div class="media-body">
                <span class="media-heading text-semibold">Super Admin</span>
                <!-- <div class="text-size-mini text-muted">
                    <i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
                </div> -->
            </div>
            <!-- <div class="media-right media-middle">
                <ul class="icons-list">
                    <li><a href="#"><i class="icon-cog3"></i></a></li>
                </ul>
            </div> -->
        </div>
    </div>
</div>
<!-- /user menu -->
<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">

            <!-- Main -->
            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
            <li <?php echo (Request::segment(1) == 'home') ? 'class="active"' : ""; ?>><a href="{{url('home')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
            <li <?php echo (Request::segment(1) == 'users') ? 'class="active"' : ""; ?>>
                <a href="#"><i class="icon-copy"></i> <span>Users</span></a>
                <ul>
                  <li <?php echo (Request::segment(1) == 'users') ? 'class="active"' : ""; ?>><a href="{{ url('users') }}" id="layout1">All Users</a></li>
                    <!-- <li><a href="{{ url('lenders') }}" id="layout1">Lenders</a></li>
                    <li><a href="{{ url('customers') }}">Customers </a></li> -->
                </ul>
            </li>
            <li <?php echo (Request::segment(1) == 'subscribers') ? 'class="active"' : ""; ?>><a href="{{ url('subscribers') }}"><i class="icon-droplet2"></i> <span>Subscribers</span></a></li>
            <li <?php echo (Request::segment(1) == 'vehicleCat') ? 'class="active"' : ""; ?>><a href="{{ url('vehicleCat') }}"><i class="icon-droplet2"></i> <span>Vehicle Category</span></a></li>
            <li><a href="#"><i class="icon-droplet2"></i> <span>Plans</span></a></li>
            <li <?php echo (Request::segment(1) == 'orders') ? 'class="active"' : ""; ?>><a href="{{ url('orders') }}"><i class="icon-stack"></i> <span>Orders</span></a></li>
            <li><a href="#"><i class="icon-pencil3"></i> <span>Account Settings</span></a></li>
            <li><a href="#"><i class="icon-file-css"></i> <span>Roles</span></a></li>
            <li><a href="#"><i class="icon-spell-check"></i> <span>Report</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- /main navigation -->