<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Truck App</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_assets/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_assets/css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin_assets/css/colors.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/loaders/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin_assets/js/core/app.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('admin_assets/js/pages/dashboard.js') }}"></script> -->
    
    
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> -->
    
</head>
<body>
    @include('layouts.includes.header')
    @yield('content')
</body>
</html>
