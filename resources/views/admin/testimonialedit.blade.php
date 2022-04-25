@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Testimonial
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
    <h1>Edit Testimonial</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Testimonials</a></li>
        <li class="active">Edit Testimonial</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Testimonial</h4>
                </div>
                <div class="panel-body testimonialedit">

                <form method="post" id="addtestimonail" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Name</label>
                                        <div class="col-md-10 col-sm-9">
                                        <input id="name" name="name" type="text" class="form-control" autocomplete="off"  value="{{ $testimonials[0]->t_name }}"></div>
                                </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Company</label><div class="col-md-10 col-sm-9">
                                        <input id="company" name="company" type="text" class="form-control" autocomplete="off" value="{{ $testimonials[0]->t_company }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Rating</label><div class="col-md-10 col-sm-9">
                                        <select id="rating" name="rating" class="form-control">
                                            <option value="">Select Rating</option>
                                            <?php
                                                for ($i=5; $i > 0 ; $i--) {
                                                    if ($i == $testimonials[0]->t_rating) { ?>
                                                        <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                                    <?php } else { ?>
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    <?php }
                                                }
                                            ?>
                                        </select></div>
                                    </div>
                                    <!-- Message body -->
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Your message</label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="message" name="message" autocomplete="off" rows="5">{{ $testimonials[0]->t_quote }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty is-fileinput">
                                        <label class="control-label col-md-2 col-sm-3" for="inputFile">Image</label>
                                    <div class="col-md-10 col-sm-9">
                                        <figure>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">

                                                        @if($testimonials[0]->t_image)
                                                            @if((substr($testimonials[0]->t_image, 0,5)) == 'https')
                                                                <img src="{{ $testimonials[0]->t_image }}" alt="img" class="img-responsive"/>
                                                            @else
                                                                <img src="{!! url('/').'/public/images/testimonial/'.$testimonials[0]->t_id .'/'. $testimonials[0]->t_image!!}" alt="img" class="img-responsive"/>
                                                            @endif
                                                        @endif
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input id="inputFile" name="inputFile" type="file" class="form-control"/>
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput" style="color: black !important;">Remove</a>
                                                </div>
                                            </div>
                                            </figure></div>

                                    </div>
                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </div>

                            </fieldset>
                            <input type="hidden" name="id" value="{{ $testimonials[0]->t_id }}">
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
            company: {
                minlength: 2,
                required: true
            },
            message: {
                minlength: 2,
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
