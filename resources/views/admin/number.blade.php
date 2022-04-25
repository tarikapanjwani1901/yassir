@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Category
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/css/pages/wizard.css') }}" rel="stylesheet">
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">

               

    <h1>Manage Numbers</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Manage Numbers</li>
    </ol>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary testimonialedit">
                <div class="panel-heading">
                    <h4 class="panel-title">Manage Numbers</h4>
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail" enctype="multipart/form-data">
                   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <fieldset>
                                <!-- Name input-->
                               
                               
                                <div class="">
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Visitor<span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="visitor" name="visitor" type="text" class="form-control" value="{{ $visitor_count[0]->visitor }}" placeholder="Visitor">
                                        </div></div>

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Happy customer<span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="happy_cust" name="happy_cust" type="text" class="form-control" value="{{ $visitor_count[0]->happy_cust }}" placeholder="Happy customer">
                                        </div></div>
                                     
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Vendor<span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="vendor" name="vendor" type="text" class="form-control" value="{{ $visitor_count[0]->vendor }}" placeholder="Vendor">
                                        </div></div>        

                                    
                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </div>
                                </div>
                            
                            </fieldset>
                           
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>
<script type="text/javascript">
<script type="text/javascript">

$(document).ready(function () {

    $('#addtestimonail').validate({
        rules: {
            visitor: {
              
                required: true
            },
            happy_cust: {
                required: true
            },
            vendor:{
                required: true
            },

        },
        highlight: function (element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (element) {
            element.text('OK!').addClass('valid')
                .closest('.control-group').removeClass('error').addClass('success');
        }
    });
});

</script>
@stop
