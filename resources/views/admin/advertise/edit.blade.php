@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Update Product
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link type="text/css" href="{{ asset('public/assets/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/pages/wizard.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
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
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Update Product</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Update Product</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary testimonialedit">
                <div class="panel-heading">
                    <h4 class="panel-title">Update Product</h4>
                </div>
                <div class="panel-body">
                    <form method="post" id="addtestimonail" enctype="multipart/form-data">
                        <fieldset>
                          @if (!Sentinel::inRole('vendor'))
                            <div class="form-group row label-floating is-empty">
                                <label class="control-label col-md-2 col-sm-3" for="name">Select Vendor <span style="color:red"> * </span> </label>
                                <div class="col-md-10 col-sm-9">
                                    <select name="vendor_id" id="vendor_id" class="reviewselect form-control">
                                        <option value="">Select Vendor</option>
                                        @if(!empty($vendors))
                                        @foreach($vendors as $d)
                                            @if ($advertise->id == $d->id)
                                            <option value="{{$d->id}}" selected="selected">{{$d->company_name}}</option>
                                            @else
                                            <option value="{{$d->id}}">{{$d->company_name}}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="vendor_id" id="vendor_id" value="{{ Sentinel::getUser()->id }}">
                            @endif

                           <!-- Name input-->
                            <div class="form-group row label-floating is-empty">
                              <label class="control-label col-md-2 col-sm-3" for="title">Title <span style="color:red"> * </span> </label>
                              <div class="col-md-10 col-sm-9">
                                 <input id="title" name="title" type="text" class="form-control" value="{{ $advertise->title }}" required>
                              </div>
                            </div>

                           <div class="form-group  row label-floating is-empty is-fileinput">
                            <label class="control-label col-md-2 col-sm-3" for="inputFile">Image<span style="color:red"> * </span></label>
                            <div class="col-md-10 col-sm-9">
                            <figure>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <div class="product_img">
                                    @if($advertise->file_name)
                                        @if((substr($advertise->file_name, 0,5)) == 'https')
                                            <a href="javascript:void(0);" class="cross"> 
                                                <span class="glyphicon glyphicon-remove f_remove" data-id="{{$advertise->id}}" id="{{$advertise->file_name}}"></span>
                                            </a>
                                            <img id="image_preview" data-id="1" src="{{$advertise->file_name}}" alt="img" class="img-responsive"/>
                                        @else
                                            <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove f_remove" data-id="{{$advertise->id}}" id="{{$advertise->file_name}}"></span></a>
                                            <img id="image_preview" data-id="1" src="{!! url('/').'/public/images/advertise/'. $advertise->id.'/'. $advertise->file_name!!}" alt="img" class="img-responsive"/>
                                        @endif
                                    @else
                                        <img id="image_preview" data-id="0" src="{{ asset('public/images/noimage.png') }}" class="prodctimg">
                                    @endif
                                    </div>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <div id="img_msg" class="text-success" style="display:none; text-align:center; font-size: 20px">Image Successfully deleted</div>
                                    <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image/video</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input id="image" name="image" type="file" class="form-control"/>
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
                        </fieldset>
                        <input type="hidden" name="pro_id" value="{{ $advertise->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript">

    $(document).ready(function () {

        jQuery.validator.addMethod("imagerequired", function(value, element) {
            if($("#image_preview").attr('data-id')>0)
                return true;
            else if($("#image").val()!='')   
                return true; 
            else
                return false;
        },"Image field is required");

        $('#addtestimonail').validate({
            rules: {
                title: {
                    minlength: 2,
                    required: true
                },
                image:{
                    imagerequired:true
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
        url:"{{url('/admin/advertise/delete_image')}}",
        data:{file:file,id:id},
        dataType: "json",
        success: function(data){
          window.location.reload(); 
        }
      });
    });
    </script>
    <script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" ></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/sifter/sifter.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/microplugin/microplugin.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/selectize/js/selectize.min.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('public/assets/js/pages/custom_elements.js') }}"></script>
@stop