@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('blog/title.add-blog') :: @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('public/assets/vendors/summernote/summernote.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <!--section starts-->
    <h1>@lang('blog/title.add-blog')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="14" data-c="#000" data-loop="true"></i>
                @lang('general.home')
            </a>
        </li>
        <li>
            <a href="#">@lang('blog/title.blog')</a>
        </li>
        <li class="active">@lang('blog/title.add-blog')</li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <!--main content-->
    <div class="row">
        <div class="the-box no-border">
            <form method="POST" autocomplete="off" id="cms_info">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <input type="text" name="title" id="title" placeholder="Title" class="form-control input-lg">
                        </div>
                        <div class='box-body pad form-group'>
                            <textarea rows='5' name="description" id="description" class='textarea form-control' style="width: 100%; height: 200px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                           
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="form-group pull-right">
                            <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                        </div>     
                </div>
            </form>
        </div>
    </div>
    <!--main content ends-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<!-- begining of page level js -->
<!--edit blog-->
<script src="{{ asset('public/assets/vendors/summernote/summernote.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('public/assets/js/pages/add_newblog.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {

    $('#cms_info').validate({
        rules: {
            
            title: {
                required: true
            },
            description:{
                required: true
            },
            
        },
        messages:{
            subcategory:{
                required:"Please select sub category",
            },
            first_name:{
                required:"First name is required",
            },
        },
    });
});

</script>
@stop
