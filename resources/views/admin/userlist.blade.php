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
                            <li class="active">User List</li>
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
                                            <table class="table datatable-button-html5-basic" id="UserListdataTable">
                                                <thead>
                                                    <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Fullname</th>
                                                    <th>Email</th>
                                                    <th>Mobile Number</th>
                                                    <th>Profile Photo</th>
                                                    <th>License</th>
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
<!-- Start - Modal -->
<div id="userdetails_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <table id="userdetails">
          
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End - Modal -->
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
  /*$(document).ready(function () {
        //$('#UserListdataTable').DataTable().destroy();
        $('#UserListdataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                    "url": "{{ url('allusers') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                  },
            "columns": [
                { "data": "id" },
                { "data": "firstname" },
                { "data": "lastname" },
                { "data": "created_at" },
                { "data": "action" }
            ]	 
            
      });
  });*/
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


    // Basic initialization
    $('#UserListdataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                "url": "{{ url('allusers') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
                },
        "columns": [
            { "data": "id" },
            { "data": "fullname" },
            { "data": "email" },
            { "data": "mobile" },
            { "data": "profile_image" },
            { "data": "license" },
            { "data": "action" }
        ],
        columnDefs: [
            { orderable: false, targets: 1 },
            { orderable: false, targets: 4 },
            { orderable: false, targets: 5 },
            { orderable: false, targets: 6 },
            
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
function statusChange(status, id) {
  var url = 'statusChange';
  $.ajax({
      type: "POST",
      url: url,
      dataType: "json",
      data: {'id':id,'status':status, "_token": "{{ csrf_token() }}"},
      success: function(data){
        location.reload();
      }
  });
}

function showUserDetails(id) {
  var url = 'showUserDetails';
  $.ajax({
      type: "POST",
      url: url,
      dataType: "json",
      data: {'id':id, "_token": "{{ csrf_token() }}"},
      success: function(data){
        $('#userdetails').html('');
        var html = "";
        html += '';
        $('#userdetails').html(data);
        $('#userdetails_modal').modal('show');
      }
  });
}

/*"headers": {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },*/
</script>
@endsection