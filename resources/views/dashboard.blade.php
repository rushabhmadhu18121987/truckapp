@extends('layouts.app_admin')
@section('content')
<div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">
                   <!-- Main navigation -->
                    @include('layouts.includes.menu')
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
                        </div>

                        <!-- <div class="heading-elements">
                            <div class="heading-btn-group">
                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                            </div>
                        </div> -->
                    </div>

                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li class="active">Dashboard</li>
                        </ul>

                        <ul class="breadcrumb-elements">
                            <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-gear position-left"></i>
                                    Settings
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
                                    <li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
                                    <li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                   

                    <!-- Dashboard content -->
                    <div class="row">
                        <div class="col-lg-12">

                            

                            <!-- Quick stats boxes -->
                            <div class="row">
                                <div class="col-lg-3">

                                    <!-- Members online -->
                                    <div class="panel bg-teal-400">
                                        <div class="panel-body">
                                            <!-- <div class="heading-elements">
                                                <span class="heading-text badge bg-teal-800">+53,6%</span>
                                            </div> -->
                                            <h3 class="no-margin">{{$users}}</h3>
                                            Customers
                                            <!-- <div class="text-muted text-size-small">489 avg</div> -->
                                        </div>

                                        <div class="container-fluid">
                                            <div id="members-online"></div>
                                        </div>
                                    </div>
                                    <!-- /members online -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Current server load -->
                                    <div class="panel bg-pink-400">
                                        <div class="panel-body">
                                            
                                            <h3 class="no-margin">{{$subscribers}}</h3>
                                            Subscribers
                                            <!-- <div class="text-muted text-size-small">34.6% avg</div> -->
                                        </div>

                                        <div id="server-load"></div>
                                    </div>
                                    <!-- /current server load -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Today's revenue -->
                                    <div class="panel bg-blue-400">
                                        <div class="panel-body">
                                            <!-- <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="reload"></a></li>
                                                </ul>
                                            </div> -->

                                            <h3 class="no-margin">{{$vehicles}}</h3>
                                            Total Vehicles
                                            <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                                        </div>

                                        <div id="today-revenue"></div>
                                    </div>
                                    <!-- /today's revenue -->

                                </div>
                                <div class="col-lg-3">

                                    <!-- Today's revenue -->
                                    <div class="panel bg-green-400">
                                        <div class="panel-body">
                                            <!-- <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="reload"></a></li>
                                                </ul>
                                            </div> -->

                                            <h3 class="no-margin">{{$category}}</h3>
                                            Total Category
                                            <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                                        </div>

                                        <div id="today-revenue"></div>
                                    </div>
                                    <!-- /today's revenue -->

                                </div>
                                <div class="col-lg-3">
                                    <div class="panel bg-info-400">
                                        <div class="panel-body">
                                            <h3 class="no-margin">{{$orders}}</h3>
                                            Total Order
                                            <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                                        </div>
                                        <div id="today-revenue"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="panel bg-success-400">
                                        <div class="panel-body">
                                            <h3 class="no-margin">{{$completed_order}}</h3>
                                            Completed Order
                                            <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                                        </div>
                                        <div id="today-revenue"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="panel bg-warning-400">
                                        <div class="panel-body">
                                            <h3 class="no-margin">{{$canceled_order}}</h3>
                                            Canceled Order
                                            <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                                        </div>
                                        <div id="today-revenue"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /quick stats boxes -->


                            

                        </div>

                        
                    </div>
                    <!-- /dashboard content -->


                    <!-- Footer -->
                    <div class="footer text-muted">
                        &copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
@endsection