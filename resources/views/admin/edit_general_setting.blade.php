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
    <h1>Edit General Setting</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> General Setting</a></li>
        <li class="active">Edit General Setting</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit General Setting</h4>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="panel-body">

                <form method="post" id="edit_setting">
                    {{csrf_field()}}
                            <fieldset>
                                <!-- Name input-->
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Contact No.</label><div class="col-md-10 col-sm-9">
                                        <input id="contact_no" name="contact_no" type="text" class="form-control" value="{{ $edit[0]->contact_no }}">
                                        </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Facebook Link</label><div class="col-md-10 col-sm-9">
                                        <input id="facebook_link" name="facebook_link" type="text" class="form-control" value="{{ $edit[0]->facebook_link }}">
                                        </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Twitter Link</label><div class="col-md-10 col-sm-9">
                                        <input id="twitter_link" name="twitter_link" type="text" class="form-control" value="{{ $edit[0]->twitter_link }}">
                                        </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Instagram Link</label><div class="col-md-10 col-sm-9">
                                        <input id="instagram_link" name="instagram_link" type="text" class="form-control" value="{{ $edit[0]->instagram_link }}">
                                        </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Youtube Link</label><div class="col-md-10 col-sm-9">
                                        <input id="youtube_link" name="youtube_link" type="text" class="form-control" value="{{ $edit[0]->youtube_link }}">
                                        </div>
                                    </div>

                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
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
$(document).ready(function () {

    $('#edit_setting').validate({
        rules: {
            contact_no: {
                required: true
            },
            facebook_link:{
                required:true
            },
            twitter_link: {
                required: true
            },
            instagram_link: {
                required: true
            },
            youtube_link: {
                required: true
            },
        },
        messages:{
            contact_no:{
                required:"Please select Contact No.",
            },
            facebook_link:{
                required:"Facebook Link is required",
            },
            twitter_link:{
                required:"Twiter Link is required",
            },
            instagram_link:{
                required:"Instagram Link is required",
            },
            youtube_link:{
                required:"Youtube Link is required",
            },
        },
    });
});
</script>

@stop
