@extends('layouts.app_admin')
@section('content')
<div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="category-content">
                            <div class="media">
                                <a href="#" class="media-left"><img src="{{ asset('admin_assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
                                <div class="media-body">
                                    <span class="media-heading text-semibold">Victoria Baker</span>
                                    <div class="text-size-mini text-muted">
                                        <i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
                                    </div>
                                </div>
                                <div class="media-right media-middle">
                                    <ul class="icons-list">
                                        <li><a href="#"><i class="icon-cog3"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /user menu -->

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
                            <li class="active">Subscribers</li>
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
                                        {{-- <div class="panel-heading">
                                            <h4>Total Number of Users is: {{count($users)}}</h4>
                                        </div> --}}
                                        <div class="panel-body table-responsive" style="padding-top: 20px;">
                                            <table class="table datatable-button-html5-basic" id="subscriberTable">
                                                <thead>
                                                    <tr>
                                                    <th>Id</th>
                                                    <th>Firstname</th>
                                                    <th>Lastname</th>
                                                    <th>Created At</th>
                                                    <!-- <th>Action</th> -->
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
    $('#subscriberTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                  "url": "{{ url('subscribersList') }}",
                  "dataType": "json",
                  "type": "POST",
                  "data":{ _token: "{{csrf_token()}}"}
                },
        "columns": [
            { "data": "id" },
            { "data": "firstname" },
            { "data": "lastname" },
            { "data": "created_at" },
            //{ "data": "action" }
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
            ]
        }
      });
  });
</script>
@endsection