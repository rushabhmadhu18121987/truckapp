@extends('layouts.app_admin')
@section('content')
<div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    @include('layouts.includes.menu')

                </div>
            </div>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span></h4>
                        </div>
                    </div>

                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li class="active">Vehicles Management</li>  
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Main charts -->
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Traffic sources -->
                            <div class="panel panel-flat">
                                <div class="container-fluid">
                                  <div class="content">
                                    <div class="panel panel-flat" style="padding-top: 20px; padding-bottom: 20px;">
                                  <!-- <a class="btn btn-primary ml-20" href="newVehicle">Add New</a> -->
                                        {{-- <div class="panel-heading">
                                            <h4>Total Number of Users is: {{count($users)}}</h4>
                                        </div> --}}
                                        <div class="panel-body table-responsive" style="padding-top: 20px;">
                                            <table class="table datatable-button-html5-basic" id="vehicleTable">
                                                <thead>
                                                    <tr>
                                                    <th>Sr.no.</th>
                                                    <th>Owner</th>
                                                    <th>Vehicle Name</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Make</th>
                                                    <th>Model</th>
                                                    <th>Color</th>
                                                    <th>Vehicle Condition</th>
                                                    <th>Hourly Price</th>
                                                    <th>Daily Price</th>
                                                    <th>Weekly Price</th>
                                                    <th>Monthly Price</th>
                                                    <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right panel-body clear">
                                            {{-- {{ $users->links() }} --}}
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="position-relative" id="traffic-sources"></div>
                            </div>
                            <!-- /traffic sources -->

                        </div>

                       
                    </div>
                    <!-- /main charts -->

                    <!-- Footer -->
                    @include('layouts.includes.footer')
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
<!-- Theme JS files -->
<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('admin_assets/js/core/app.js') }}"></script>
	<!-- <script type="text/javascript" src="{{ asset('admin_assets/js/pages/datatables_extension_buttons_html5.js') }}"></script> -->
    <!-- theme JS files -->
<script>
  $(function() {
    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        }
    });
    $('#vehicleTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                  "url": "{{ url('vehicleList') }}",
                  "dataType": "json",
                  "type": "POST",
                  "data":{ _token: "{{csrf_token()}}"}
                },
        "columns": [
            { "data": "id" },
            { "data": "owner" },
            { "data": "title" },
            { "data": "vehicle_type" },
            { "data": "make" },
            { "data": "model" },
            { "data": "color" },
            { "data": "vehicle_condition" },
            { "data": "hourly_price" },
            { "data": "daily_price" },
            { "data": "weekly_price" },
            { "data": "monthly_price" },
            { "data": "action" }
        ],
        columnDefs: [
            { orderable: false, targets: 1 },
            { orderable: false, targets: 3 },
            { orderable: false, targets: -1 },
            
        ],
        buttons: {            
            dom: {
                button: {
                    className: 'btn btn-default'
                }
            },
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
        }
      });
  });

  function statusChange(sts,id) {
    var url="vehicleStatusChange";
    $.ajax({
      headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
          url: url,
          data:{'sts':sts, 'id':id},
            success: function(resp){
            location.reload();
          }
      });

  }
</script>
@endsection