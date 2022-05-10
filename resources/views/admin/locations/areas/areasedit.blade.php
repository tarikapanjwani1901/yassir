@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Area
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
    <h1>Edit Area</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Areas</a></li>
        <li class="active">Edit Area</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Area</h4>
                </div>
                <div class="panel-body testimonialedit">

                <form method="post" id="addareas" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->
                                
                                <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="country">Country <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                            {!! Form::select('country', $countries, $areas[0]->country_id,['class' => 'form-control select2', 'id' => 'country']) !!}
                                    <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                        </div>
                                    
                                 <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="state">State <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                                    {!! Form::select('state', $states,$areas[0]->state_id,['class' => 'form-control select2', 'id' => 'state']) !!}
                                                    
                                    <span class="help-block">{{ $errors->first('state', ':message') }}</span>
                                        </div>
                                    </div>
                                    
                                      <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="city">City <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                           
                                                 {!! Form::select('city', $cities,$areas[0]->city_id,['class' => 'form-control select2', 'id' => 'city']) !!}
                                              
                                    <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                                    
                                        </div>
                                    </div>
                                    
                                    
                                    
                                      <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="sub_city">Sub City <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                           
                                                 {!! Form::select('sub_city', $sub_cities,$areas[0]->sub_city_id,['class' => 'form-control select2', 'id' => 'sub_city']) !!}
                                              
                                    <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                                    
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Area Name <span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                        <input id="name" name="name" type="text" class="form-control" value="{{ $areas[0]->area_name}}" autocomplete="off" required>
                                        </div></div>
                                        
                                        
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="pincode">Pincode<span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                        <input id="pincode" name="pincode" type="text" class="form-control" value="{{ $areas[0]->area_pincode}}" autocomplete="off" required>
                                        </div></div>
                                   
                                   <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="status">Status<span style="color:red"> * </span> </label>    <div class="col-md-10 col-sm-9">
                                           
                                                 {!! Form::select('status', $status,$areas[0]->status,['class' => 'form-control select2', 'id' => 'status']) !!}
                                              
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
                            <input type="hidden" name="id" value="{{ $areas[0]->area_id}}">
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

    $('#addareas').validate({
 rules: {
            
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            sub_city: {
                required: true
            },
			name: {
                minlength: 2,
                required: true
            },
			
			pincode: {
                minlength: 4,
                required: true
            },
           
        },        highlight: function (element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (element) {
            element.text('OK!').addClass('valid')
                .closest('.control-group').removeClass('error').addClass('success');
        }
    });
});

$("#country").on('change',function(){

    var search_country = $('#country').val();
		
		$("#state").empty();
		$("#state").append('<option value="">Please select state</option>');
        $("#city").empty();
		$("#city").append('<option value="">Please select city</option>');
		$("#sub_city").empty();
		$("#sub_city").append('<option value="">Please select sub city</option>');
        
              
    if (search_country !== '') {

        //Populate Sub Category Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/getState')}}?country="+this.value,
            success:function(data){
                if ( data ) {
                    
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
		
	}
});
$("#state").on('change',function(){

    var search_state = $('#state').val();
		$("#city").empty();
		$("#city").append('<option value="">Please select city</option>');
		$("#sub_city").empty();
		$("#sub_city").append('<option value="">Please select sub city</option>');
        
                   
    if (search_state !== '') {

        //Populate Sub Category Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/getCity')}}?state="+this.value,
            success:function(data){
                if ( data ) {
                    
                    $.each( data, function( key, value ) {
                        $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
		
	}
});
$("#city").on('change',function(){

    var search_city = $('#city').val();
		$("#sub_city").empty();
		$("#sub_city").append('<option value="">Please select sub city</option>');
                   
    if (search_city !== '') {

        //Populate Sub Category Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/getSubCity')}}?city="+this.value,
            success:function(data){
                if ( data ) {
                    
                    $.each( data, function( key, value ) {
                        $("#sub_city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
		
	}
});

</script>
@stop
