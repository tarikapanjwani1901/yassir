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
    <h1>Generate Invoice</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Generate Invoice</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Generate Invoice</h4>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <fieldset id="dynamic_field">

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">First Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="first_name" name="first_name" type="text" class="form-control" value="{{ $edit_data[0]->first_name }}" placeholder="Enter First Name" >
                                    </div></div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Last Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="last_name" name="last_name" type="text" class="form-control" value="{{ $edit_data[0]->last_name }}" placeholder="Enter Last Name">
                                    </div></div>
                                          <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Inovice Number<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="invoice_number" name="invoice_number" type="text" class="form-control"  placeholder="Enter Inovice Number">
                                       
                                    </div></div>
                                      <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">CGST<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="cgst" name="cgst[]" type="text" class="form-control gst"  value="9%"  placeholder="Enter Cgst Number">
                                    </div></div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">SGST<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="sgst" name="sgst[]" type="text" class="form-control gst"  value="9%"   placeholder="Enter Sgst Number">
                                    </div></div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Package <span style="color:red"> * </span> </label> <div class="col-md-10 col-sm-9">
                                        <input id="package" name="package[]" type="text" class="form-control" placeholder="Enter Package Name">
                                    </div>
                                    </div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Select Package Duration<span style="color:red"> * </span> </label> <div class="col-md-10 col-sm-9">
                                        <select name="package_duration" class="form-control" >
                                                            <option value="">Select Package Duration</option>
                                                            <option value="3 Months" @if($edit_data[0]->package_duration == '3 Months') selected="selected" @endif >3 Months</option>
                                                            <option value="6 Months" @if($edit_data[0]->package_duration == '6 Months') selected="selected" @endif>6 Months</option>
                                                            <option value="12 Months" @if($edit_data[0]->package_duration == '12 Months') selected="selected" @endif>12 Months</option>
                                                        </select>
                                    </div>
                                    </div>

                                     <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Price<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="price" name="price[]"  type="text" class="form-control price"  placeholder="Enter Price">
                                       
                                    </div></div>

                                     <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">HSN /SAC<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="hsn" name="hsn[]" type="text" placeholder="Enter HSN /SAC" class="form-control" >
                                       
                                    </div></div>

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Qnty.<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="qnty" name="qnty[]" type="text"  placeholder="Enter Qnty"  class="form-control" >
                                        
                                    </div></div>

                                  

                                    <div class="form-group  row label-floating is-empty add_more">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Total Price<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="total" name="total[]" type="text"  class="form-control total"  placeholder="Enter Total Price" >
                                        

                                    </div></div>

                                    <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add Package</button>
                                    
                                    

                            </fieldset>
                            <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
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

    
     var i=1;  


      $('.add-more').click(function(){  
       
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="panel-body btn_price"><fieldset><div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">Package Name <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input  placeholder="Package name" id="package" name="package[]" type="text" class="form-control price123"></div></div>\
                                        <div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">Price<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input placeholder="price" id="price1" name="price[]" type="text" class="form-control price123"></div></div><div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">HSN /SAC<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input  placeholder="hsn" id="hsn" name="hsn[]" type="text" class="form-control" ></div></div><div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">Qnty.<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input  placeholder="qnty" id="qnty" name="qnty[]" type="text" class="form-control" ></div></div><div class="form-group  row label-floating is-empty add_more">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">Total Price<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input  placeholder="total"  id="total" name="total[]" type="text"  class="form-control more_total"></div></div><div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">CGST<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9"><input  placeholder="cgst"  id="cgst" name="cgst[]" type="text" class="form-control more_gst" ></div></div> <div class="form-group  row label-floating is-empty">\
                                        <label class="control-label col-md-2 col-sm-3" for="name">SGST<span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">\
                                        <input id="sgst" name="sgst[]" type="text" class="form-control more_gst1"  value="9%"  value="{{ $edit_data[0]->sgst }}" placeholder="Enter Sgst Number">\
                                    </div></div><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr></fieldset></div>');  
      }); 


    $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
    });


     $(document).on('click', '.btn_price', function(){  
          
          var price = $(this).find('#price1').val();
           var cgstPrice =  $('#cgst').val();
           var sgstPrice =  $('#sgst').val();

           var prices = $('.price123').val();
           var cgst = $('.more_gst').val();
           var sgst = $('.more_gst1').val();

           var a  = cgstPrice = price * 0.09;
           var b  = sgstPrice = price * 0.09;

           var total_amount = parseInt(prices) + parseInt(cgst) + parseInt(sgst);
          

           var more_total = parseInt(cgstPrice) + parseInt(sgstPrice) + parseInt(price);
           $(this).find('.more_total').val(more_total);


        //  var b = $(this).attr('id');

          $(this).find('.more_gst').val(a);
          $(this).find('.more_gst1').val(b);

           
    }); 
 

    $('#package').on('change',function() {
        $('#hsn').val('');
        $('#price').val('');
        $('#qnty').val('');
        $('#total').val('');
    });

    $('#addtestimonail').validate({
        rules: {
            
            invoice_number: {
                required: true,
            },
            'package[]':{
                required:true,
            },
            'price[]': {
                required: true,
            },
            'hsn[]': {
                required: true
            },
            Phone:{
                required:true,
                maxlength:10,
                minlength:10
            },
            'qnty[]':{
                required:true
            },
            age_details:{
                required:true
            },
            adharnumber_details:{
                required:true
            },
            package_duration:{
                required:true
            },
        },
        messages:{
            invoice_number:{
                required:"Invoice number is required",
            },
            'package[]':{
                required:"First name is required",
            },
            'price[]':{
                required:"Last name is required",
            },
            'hsn[]':{
                required:"Phone number is required",
                maxlength:"Please enter valid phone number",
                minlength:"Please enter valid phone number",
            },
            'qnty[]':{
                required:"Experience is required",
            },
            age_details:{
                required:"Age is required",
            },
             adharnumber_details:{
                required:"Adharnumber is required",
            },
            package_duration:{
                required:"Select package duration"
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

 <script type="text/javascript">

  $('.price').on('change', function(){


    var exPrice = $('#price').val();
    var cgstPrice =  $('#cgst').val();
    var sgstPrice =  $('#sgst').val();

      cgstPrice = exPrice * 0.09;
      sgstPrice = exPrice * 0.09;

    var TPrice = parseInt(cgstPrice) + parseInt(sgstPrice) + parseInt(exPrice);

    $('#cgst').val(cgstPrice);
    $('#sgst').val(sgstPrice);
    $('#total').val(TPrice);



     $('.total').val(TPrice);
     $('.cgst').val(cgstPrice);
     $('.sgst').val(sgstPrice);

  });



  $('#price1').change(function(){
   
     var trid = $(this).parent('tr').attr('id');
     });


 


</script>
@stop
