@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add Category
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
    <h1>Add Category</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Add Category</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Category</h4>
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Category <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <option value="1">Properties</option>
                                            <option value="2">Consultancy</option>
                                            <option value="3">Contractor</option>
                                            <option value="4">Material</option>
                                            <option value="5">Skill labour</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="name" name="name" type="text" class="form-control" required>
                                    </div></div>
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Slug </label><div class="col-md-10 col-sm-9">
                                        <input id="slug" name="slug" type="text" class="form-control"></div>
                                    </div>
                                    <div class="form-group  row slabel-floating is-empty is-fileinput">
                                        <label class="control-label col-md-2 col-sm-3" for="inputFile">Image </label>
                                    <div class="col-md-10 col-sm-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    <img src="http://placehold.it/200x200" alt="profile pic">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                            <div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input id="inputFile" name="inputFile" type="file" class="form-control"/>
                                                </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists"
                                                           data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </div>

                            </fieldset>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
$(document).ready(function () {

    $('#addtestimonail').validate({
        rules: {
            name: {
                minlength: 2,
                required: true
            },
            category: {
                required: true
            },
            slug:{
                required:true
            },
        },
        messages:{
            category:{
                required:"Please select category",
            },
            name:{
                required:"Name is required",
            },
            slug:{
                required:"Slug is required",
            },
        },
        highlight: function (element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (element) {
           
        }
    });
});

</script>
@stop
