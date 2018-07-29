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
                            <li class="active">Promocode</li>
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
                                        <div class="panel-body table-responsive" style="padding-top: 20px;">
                                            <form method="post" name="promoform" id="promoform" action="addPromocode" parsley-validate>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group">
                                                    <label for="promocode_title">Promocode Title:</label>
                                                    <input type="text" name="promocode_title" class="form-control" id="promocode_title" value="" parsley-required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="promo_code">Promocode</label>
                                                    <input type="text" name="promo_code" class="form-control" id="promo_code" value="" parsley-required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="promotypes">Promocode Type</label>
                                                    <select name="promotypes" id="promotypes" class="form-control" parsley-required="true">
                                                      <option value="1" selected>Price</option>
                                                      <option value="2">Percentage</option>
                                                    </select>
                                                </div>
                                                <div class="form-group price_div">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" class="form-control" id="price" value="">
                                                </div>
                                                <div class="form-group percentage_div" style="display:none;">
                                                    <label for="percentage">Percentage</label>
                                                    <input type="text" name="percentage" class="form-control" id="percentage" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="startdate">Promocode Startdate(MM/DD/YYYY)</label>
                                                    <div class='input-group date col-md-6' id='startdate'>
                                                        <input type='text' class="form-control" name="startdate" parsley-required="true" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="enddate">Promocode Enddate(MM/DD/YYYY)</label>
                                                    <div class='input-group date col-md-6' id='enddate'>
                                                        <input type='text' class="form-control" name="enddate" parsley-required="true" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Promocode</button>
                                            </form>
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
//   function statusChange(sts,id) {
//     var formdata = $("#catform").serialize()
//     var url="updateCategory";
// 	$.ajax({
// 		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 		type: 'POST',
//         url: url,
//         data:formdata,
//         success: function(resp){
// 			location.reload();
//         }
//     });
//   }
$('#promotypes').change(function(){
  var types = $('#promotypes').val();
  if(types == '1'){
    $('.percentage_div').css('display','none');
    $('.price_div').css('display','block');
    // $('.percentage_div').removeAttr('parsley-required','true');
    // $('.price_div').attr('parsley-required','true');
  }else{
    $('.price_div').css('display','none');
    $('.percentage_div').css('display','block');
    // $('.price_div').removeAttr('parsley-required','true');
    // $('.percentage_div').attr('parsley-required','true');
  }
});

</script>
<script type="text/javascript">
    $(function () {
        $('#startdate').datetimepicker({format: 'MM/DD/YYYY'});
        $('#enddate').datetimepicker({format: 'MM/DD/YYYY'});
    });
</script>
@endsection