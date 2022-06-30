@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    @lang('admin/advertise/title.create')
    @parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        @lang('advertise/title.create')
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('general.dashboard')
            </a>
        </li>
        <li>@lang('advertise/title.groups')</li>
        <li class="active">
            @lang('advertise/title.create')
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> 
                        <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('advertise/title.create')
                    </h4>
                </div>
                <div class="panel-body">
                    {!! $errors->first('slug', '<span class="help-block">Another role with same slug exists, please choose another name</span> ') !!}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="add_advertise" enctype="multipart/form-data" class="form-horizontal" role="form" method="post" files="true" action="{{ route('admin.advertise.store') }}">
                        <!-- CSRF Token -->

                        {{ csrf_field() }}

                        @if (!Sentinel::inRole('vendor'))
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                            Select Vendor <span style="color:red"> * </span>
                            </label>
                            <div class="col-sm-5">
                                <select name="vendor_id" id="vendor_id" class="form-control" required>
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $v)
                                    <option value="{{$v->id}}">{{$v->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('vendor_id', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>
                        @else
                            <input type="text" name="vendor_id" id="vendor_id" value="{{ Sentinel::getUser()->id }}">
                        @endif

                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                Title <span style="color:red"> * </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" id="title" name="title" class="form-control" placeholder="Title" value="{!! old('name') !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                Upload Image/Video <span style="color:red"> * </span>
                            </label>
                            <div class="col-sm-5">
                                <input type="file" id="image" name="image" class="form-control" placeholder="Title" value="{!! old('name') !!}">
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('image', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('admin.groups.index') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>
                            </div>
                        </div>
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
    $('#add_advertise').validate({
        rules: {
            title: {
                minlength: 2,
                required: true
            },
            image:{
                required: true
            }
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