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
<style>
  .product_img{position:relative;height: 100%;}
  .product_img a.cross{     position: absolute;
    top: 0px;
    right: 1px;
    width: 20px;
    height: 20px;
    border-radius: 100%;
    background: #d95d77;
    color: #fff;
    text-align: center;
    line-height: 20px;
    font-size: 10px;}
  .productimg{position:relative;}
  .testimonialedit .is-fileinput figure img{max-width:100%;height:100%;}
</style>
{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Edit Category</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Edit Category</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary testimonialedit">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Category</h4>
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->
                                <div class="">
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Name<span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="name" name="name" type="text" class="form-control" value="{{ $categoryResult[0]->name }}">
                                        </div></div>
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Slug</label><div class="col-md-10 col-sm-9">
                                        <input id="slug" name="slug" type="text" class="form-control" value="{{ $categoryResult[0]->slug }}">
                                        </div></div>
                                    <div class="form-group  row label-floating is-empty is-fileinput">
                                        <label class="control-label col-md-2 col-sm-3" for="inputFile">Image</label><div class="col-md-10 col-sm-9">
                                        <figure>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                              <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                      <div class="product_img">
                                                
                                                @if($categoryResult[0]->image)
                                                        <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove f_remove" data-id="{{$categoryResult[0]->id}}" id="{{$categoryResult[0]->image}}" style="padding: 4px;"></span>
                                                        </a>
                                                        <img src="{{url('/')}}/public/images/category/{{$id}}/{{$categoryResult[0]->image}}" alt="img" class="img-responsive"/>
                                                    @else
                                                        <!-- <img src="{!! url('/').'/public/images/category/'.$id.'/'.$categoryResult[0]->image!!}" alt="img" class="img-responsive"/> -->
                                                         <img src="{{ asset('public/images/noimage.png') }}" class="prodctimg" style="height: 100%">
                                                    
                                                @endif
                                            </div>
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
                                       </figure></div> </div>
                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="lid" value="{{ $categoryResult[0]->id }}">
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

$('.f_remove').click(function()
    {
      var file = $(this).attr("id");
      var id = $(this).attr('data-id');

      $.ajax({
        type:"POST",
        url:"{{url('/admin/categories/categories_delimage')}}",
        data:{file:file,id:id},
        dataType: "json",
        success: function(result){
        
          window.location.reload();
         
        }

      });
    });
</script>
@stop
