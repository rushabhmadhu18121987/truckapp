<!-- User menu -->
<div class="sidebar-user">
    <div class="category-content">
        <div class="media">
            <a href="#" class="media-left"><img src="{{ asset('admin_assets/images/Mooch.png') }}" class="img-circle img-sm" alt=""></a>
            <div class="media-body">
                <span class="media-heading text-semibold">Super Admin</span>
            </div>
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
                <a href="{{ url('users') }}"><i class="icon-users"></i> <span>Users</span></a>
               
            </li> 
            <li <?php echo (Request::segment(1) == 'subscribers') ? 'class="active"' : ""; ?>><a href="{{ url('subscribers') }}"><i class="icon-check"></i> <span>Subscribers</span></a></li>
            <li <?php echo (Request::segment(1) == 'vehicleCat') ? 'class="active"' : ""; ?>><a href="{{ url('vehicleCat') }}"><i class="icon-truck"></i> <span>Vehicle Category</span></a></li>
            <li <?php echo (Request::segment(1) == 'vehicle') ? 'class="active"' : ""; ?>><a href="{{ url('vehicle') }}"><i class="icon-truck"></i> <span>Vehicle Management</span></a></li>
            <li <?php echo (Request::segment(1) == 'promocode') ? 'class="active"' : ""; ?>><a href="{{ url('promocode') }}"><i class="icon-paypal"></i> <span>Promo codes</span></a></li>
            <li <?php echo (Request::segment(1) == 'orders') ? 'class="active"' : ""; ?>><a href="{{ url('orders') }}"><i class="icon-stack"></i> <span>Orders</span></a></li>
            <!-- <li><a href="#"><i class="icon-file-css"></i> <span>Roles</span></a></li>
            <li><a href="#"><i class="icon-spell-check"></i> <span>Report</span></a> -->
            </li>
        </ul>
    </div>
</div>
<!-- /main navigation -->