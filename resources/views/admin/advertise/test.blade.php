@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    Accordion
    @parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Accordion
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
                    <div class="form-group col-md-12">
                        <label for="title" class="col-sm-2 control-label">
                        Select <span style="color:red"> * </span>
                        </label>
                        <div class="col-sm-5">
                            <select name="property_type" id="property_type" class="form-control" >
                                <option value="">Select</option>
                                <option value="1bhk">1bhk</option>
                                <option value="1.5bhk">1.5bhk</option>
                                <option value="2bhk">2bhk</option>
                                <option value="2.5bhk">2.5bhk</option>
                            </select>
                        </div>
                        <button id="add_property" name="" class="add_property" >Add</button>
                    </div>
                    
                    <div class="accordion property_type_accordion" id="accordionExample" >
                        
                    </div>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on("click","#add_property",function(){
        var value = $("#property_type").val();
        if(value!=''){

            var html = '';
            html += '<div class="accordion-item">';
            html += '<h2 class="accordion-header" id="headingOne">';
            html += '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">';
            html += value;
            html += '</button>';
            html += '</h2>';
            html += '<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">';
            html += '<div class="accordion-body">';
            
            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Add Area Details <span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="Carpet Area" value="">';
                html += '</div>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="Super Built-up Area" value="">';
                html += '</div>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-12 control-label">';
                html += 'Add Room Details <span style="color:red"> * </span>';
                html += '</label>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'No of Bedrooms<span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="No of Bedrooms" value="">';
                html += '</div>';
            html += '</div>';
            
            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'No of Bathrooms<span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="No of Bathrooms" value="">';
                html += '</div>';
            html += '</div>';
            
            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'No of Balconies<span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="No of Balconies" value="">';
                html += '</div>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Other Rooms (optional)';
                html += '</label>';
                html += '<div class="col-sm-10">';
                html += '<input type="checkbox" id="poojaroom" name="vehicle1" value="Pooja Room">';
                html += '&nbsp;<label for="vehicle1">Pooja Room</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="checkbox" id="vehicle1" name="vehicle1" value="Servant Room">';
                html += '&nbsp;<label for="vehicle1">Servant Room</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="checkbox" id="vehicle1" name="vehicle1" value="Storeroom">';
                html += '&nbsp;<label for="vehicle1">Storeroom</label>&nbsp;&nbsp;&nbsp;';
                html += '</div>';
            html += '</div>';
                
            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Furnishing (optional)';
                html += '</label>';
                html += '<div class="col-sm-10">';
                html += '<input type="checkbox" id="poojaroom" name="vehicle1" value="Furnished">';
                html += '&nbsp;<label for="vehicle1">Furnished</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="checkbox" id="vehicle1" name="vehicle1" value="Semi-furnished">';
                html += '&nbsp;<label for="vehicle1">Semi-furnished</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="checkbox" id="vehicle1" name="vehicle1" value="Un furnished">';
                html += '&nbsp;<label for="vehicle1">Un furnished</label>&nbsp;&nbsp;&nbsp;';
                html += '</div>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Reserved Parking (optional)';
                html += '</label>';
                html += '<div class="col-sm-10">';
                html += '<input type="checkbox" id="poojaroom" name="vehicle1" value="Covered Parking">';
                html += '&nbsp;<label for="vehicle1">Covered Parking</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="checkbox" id="vehicle1" name="vehicle1" value="Open Parking">';
                html += '&nbsp;<label for="vehicle1">Open Parking</label>&nbsp;&nbsp;&nbsp;';
                html += '</div>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Floor Details <span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="No. of Floor" value="">';
                html += '</div>';
                html += '<div class="col-sm-5">';
                html += '<input type="text" id="title" name="title" class="form-control" placeholder="No. of Blocks" value="">';
                html += '</div>';
            html += '</div>';

            html += '<div class="form-group row label-floating is-empty">';
                html += '<label for="title" class="col-sm-2 control-label">';
                html += 'Status<span style="color:red"> * </span>';
                html += '</label>';
                html += '<div class="col-sm-10">';
                html += '<input type="radio" id="poojaroom" name="vehicle1" value="Ready to move">';
                html += '&nbsp;<label for="vehicle1">Ready to move</label>&nbsp;&nbsp;&nbsp;';
                html += '<input type="radio" id="vehicle1" name="vehicle1" value="Under Construction">';
                html += '&nbsp;<label for="vehicle1">Under Construction</label>&nbsp;&nbsp;&nbsp;';
                html += '</div>';
            html += '</div>';  
                
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $(".property_type_accordion").append(html);
        }
        else{
            alert("Please select value");
        }
    });
});

</script>
@stop