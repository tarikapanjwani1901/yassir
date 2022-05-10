@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add State
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
    <h1>Add State</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> State</a></li>
        <li class="active">Add State</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary testimonialadd">
                <div class="panel-heading">
                    <h4 class="panel-title">Add State</h4>
                </div>
                <div class="panel-body">

                <form method="post" id="addstate" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Country <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                            {!! Form::select('country', $countries, '',['class' => 'form-control select2', 'id' => 'countries']) !!}
                                    <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">State Name <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                        <input id="name" name="name" type="text" class="form-control" autocomplete="off" required>
                                        </div></div>
                                   
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Status <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                            {!! Form::select('status', $status, '',['class' => 'form-control select2', 'id' => 'status']) !!}
                                    <span class="help-block">{{ $errors->first('status', ':message') }}</span>
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
    
<script type="text/javascript">

$(document).ready(function () {

    $('#addstate').validate({
        rules: {
            name: {
                minlength: 2,
                required: true
            },
            country: {
                required: true
            },
			
            status: {
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
