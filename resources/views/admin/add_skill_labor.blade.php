@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add Category
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
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Add Skill labor</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Add Skill labor</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Skill labor</h4>
                     @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail" enctype="multipart/form-data">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <fieldset>
                                <!-- Name input-->

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Category  </label><div class="col-md-10 col-sm-9">
                                        <select name="l_category" id="l_category" class="form-control" required>
                                            <option value="5">Skill labour</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Sub Category <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <select name="l_sub_category" id="l_sub_category" class="form-control" required>
                                            <option value="">Select Sub Category</option>
                                            @foreach($skill_category as $skills)
                                           
                                            <option value="{{ $skills->id }}">{{ $skills->name }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row label-floating is-empty">
                                      <label class="control-label col-md-2 col-sm-3" for="name">Other skill <span style="color:red"> * </span> </label>
                                      <div class="col-md-10 col-sm-9">
                                        <select id="select22" class="form-control select2" name="other_skill[]" multiple required>
                                            @foreach($skill_category as $skills)
                                                <option value="{{ $skills->id }}">{{ $skills->name }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                   </div>
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">First Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="first_name" name="first_name" type="text" class="form-control" required>
                                    </div></div>
                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Last Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="last_name" name="last_name" type="text" class="form-control" required>
                                    </div></div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Phone number <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="Phone" name="Phone" type="text" class="form-control number" required>
                                    </div></div>


                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">City  </label><div class="col-md-10 col-sm-9">
                                        <select name="s_city" id="s_city" class="form-control">
                                    <option value="">Select city</option>
                                    @if (!empty($skill_city))
                                      @foreach($skill_city as $d)
                                        <option value="{{$d->City_Name}}">{{$d->City_Name}}</option>
                                      @endforeach
                                    @endif
                                </select>  
                                        </div>
                                    </div>

                                     <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Area </label><div class="col-md-10 col-sm-9">
                                        <select name="area" id="state" class="form-control">
                                            <option value="">Select Area</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Experience <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="experience_details" name="experience_details" type="text" class="form-control"></div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Age <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="age_details" name="age_details" type="text" class="form-control"></div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Adharnumber <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="adharnumber_details" name="adharnumber_details" type="text" class="form-control"></div>
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


<script type="text/javascript">
$(document).ready(function () {

    $('#addtestimonail').validate({
        rules: {
            
            category: {
                required: true
            },
            l_sub_category:{
                required:true
            },
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            Phone:{
                required:true,
                maxlength: 10,
                minlength: 10,
            },
            s_city:{
                required:true,
            },
            experience_details:{
                required:true
            },
            age_details:{
                required:true
            },
            adharnumber_details:{
                required:true
            },
        },
        messages:{
            l_sub_category:{
                required:"Sub category is required",
            },
            first_name:{
                required:"First name is required",
            },
            last_name:{
                required:"Last name is required",
            },
            Phone:{
                required:"Phone number is required",
                maxlength:"Please Enter Valid Phone Number",
                minlength:"Please Enter Valid Phone Number",
            },
            s_city:{
                required:"City is required"
            },
            experience_details:{
                required:"Experience is required",
            },
            age_details:{
                required:"Age is required",
            },
             adharnumber_details:{
                required:"Adharnumber is required",
            },
        },
    });
});
$(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });



</script>
<script>
    $("#s_city").on('change',function(){
        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#state").empty();

                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
    });
</script>
@stop
