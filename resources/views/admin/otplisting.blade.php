@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
OTPListing
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<style type="text/css">
  .dt1 {
    width: 150px;
    display: inline-block;
    margin-left: 6px;
}
</style>
<section class="content-header">
    <h1>OTP Listings</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">OTP Listings</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
   <div class="">
    <div class="row">
        <div class="portlet box warning">


                <div class="portlet-title">
                    <div class="caption">
                      OTP Listing &nbsp;&nbsp; 
                       @if(Sentinel::inRole('admin'))
                      (Total Otp Listing : {{$total_otp_listing}})
                       @endif 
                      </div>

                    <div style="float: right;">
                        <form action="{{url('/admin/export_otplisting')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @if(isset($_GET['category']))
                                    <input type="hidden" name="category" value="{{$_GET['category']}}">
                                @endif
                                @if(isset($_GET['sub_cat']))
                                    <input type="hidden" name="sub_cat" value="{{$_GET['sub_cat']}}">
                                @endif
                                @if(isset($_GET['vendor']))
                                    <input type="hidden" name="vendor" value="{{$_GET['vendor']}}">
                                @endif
                                @if(isset($_GET['listing']))
                                    <input type="hidden" name="listing" value="{{$_GET['listing']}}">
                                @endif
                                @if(isset($_GET['otpstatus']))
                                    <input type="hidden" name="otpstatus" value="{{$_GET['otpstatus']}}">
                                @endif
                                @if(isset($_GET['daterange']))
                                    <input type="hidden" name="daterange" value="{{$_GET['daterange']}}">
                                @endif
                                @if (Sentinel::inRole('admin'))
                                    <input type="hidden" name="is_admin" value="1">
                                @endif

                                <input type="hidden" name="user_id" value="{{ Sentinel::getUser()->id }}">
                                <input type="submit" value="Export To Excel" class="btn success" ></button>

                        </form>
                    </div>

                </div>

                <div class="">
                    <form class="reportform padd15" method="get" name="inquiry" autocomplete="off">
                        @if (!Sentinel::inRole('vendor'))
                        <select name="category" id="category">
                            <option value="">Select Category</option>
                            @foreach ($category as $key => $value)
                                    @if ($cate == $value->id)
                                   <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                            @endforeach
                        </select>
                        @endif

                        @if (!Sentinel::inRole('vendor'))
                        <select name="sub_cat" id="sub_cat">
                            <option value="">Select Sub Category</option>
                            <?php if ($type) {
                                foreach ($type as $key => $value) { ?>
                                    @if ($subCate == $value->id)
                                        <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endif

                                <?php }
                            } ?>
                        </select>
                        @endif

                          @if (!Sentinel::inRole('vendor'))
                        <select name="vendor" id="vendor">
                            <option value="">Select Vendor</option>
                           
                              @foreach($ven as $d)
                                @if ($d->vl_id == $vendor)
                                  <option value="{{$d->vl_id}}" selected>{{$d->company_name}}</option>
                                @else
                                  <option value="{{$d->vl_id}}">{{$d->company_name}}</option>
                                @endif
                              @endforeach
                           
                        </select>
                        @endif

                            @if (!Sentinel::inRole('vendor'))
                         <select name="listing" id="listing">
                            <option value="">Select Listing</option>
                            @if (!empty($venListing))
                              @foreach($venListing as $d)
                                @if ($d->vl_id == $listing)
                                  <option value="{{$d->vl_id}}" selected>{{$d->l_title}}</option>
                                @else
                                  <option value="{{$d->vl_id}}">{{$d->l_title}}</option>
                                @endif
                              @endforeach
                            @endif
                        </select>
                        @endif  

                        <select name="otpstatus" id="otpstatus">
                            <option value="">Select Status</option>
                            <option value="1" <?php echo ($otpstatus == '1') ? 'selected': '' ?>>Valid</option>
                            <option value="3" <?php echo ($otpstatus == '3') ? 'selected': '' ?>>In Valid</option>
                            <option value="2" <?php echo ($otpstatus == '2') ? 'selected': '' ?>>No Action</option>
                        </select>  
                        
                          <input id="datetimepicker6" name="from" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="Start date"/>

                          <input id="datetimepicker7" name="to" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="End date"/>                                  
                  
                        <input type="submit" value="Submit" id="submit">
                        <a class="btn default" href="{{url('/')}}/admin/otplisting"><i class="fa fa-refresh" data-toggle="tooltip" title="" data-original-title="Reset"></i></a>
                
                    </form>
                </div>
                <div class="portlet-body testimoniallist">
                 <div class="table-responsive">
                  <form action="{{url('admin/mdelete')}}" method="post">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
                    <table class="table table-bordered">
                       <thead>
                          <tr><th><input type="checkbox" name="" id="checkall"></th> 
                             <th>Id</th>
                             <th>Listing Name</th>
                             <th>User</th>
                             <th>User Phone</th>
                             <th>Date</th>
                             <th>Message</th>
                             <th>Action</th>
                          </tr>
                       </thead>
                       <tbody>
                        @if(count($otpListing))
                         @php $i = ($otpListing->currentpage()-1)*$otpListing->perpage() + 1 @endphp
                            @foreach($otpListing as $otp)
                                <tr id="tr_{{$otp->id}}">
                                  <td><input type="checkbox" name="all_data[]" value="{{$otp->id}}" class="cb-element"></td>
                                    <td>{{$i++}}</td>
                                    <td>
                                    @if(is_numeric($otp->l_id))
                                     {{ $otp->l_title }}
                                     @else
                                     {{ $otp->l_id}} 
                                      @endif  
                                    </td>
                                    <td> {{ ucfirst($otp->u_name) }} </td>
                                    <td> {{ $otp->u_phone }} </td>
                                    <td> <?php echo date('M j h:ia', strtotime($otp->otp_date)) ?> </td>
                                    <td>{{$otp->audio_description}}</td>
                                   @if (!Sentinel::inRole('vendor'))
                                     
                                    <td>
                                        @if ($otp->admin_status == '2' || $otp->admin_status == '')
                                        <a href="javascript:void(0);" id="valid_{{$otp->id}}" class="update_status btn default btn-edit">
                                            Valid
                                        </a>
                                        <a href="javascript:void(0);" id="invalid_{{$otp->id}}" class="update_status btn default btn-delete">
                                            In Valid
                                        </a>
                                        <a href="javascript:void(0);" id="reset_{{$otp->id}}" style="display: none;" class="update_status btn default">
                                            Reset
                                        </a>

                                        <a   class="btn default etst" href="{{url('/')}}/detail/{{$otp->url_name}}"  target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Detail"></i></a>

                                        <a href="{{url('/')}}/admin/otplisting/audio/{{$otp->id}}" class="btn default btn-edit">Upload audio
            
                    

                                <?php
                                      if($otp->audio_id){
                                      $directory = "public/uploads/audio/".$otp->id;
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = ''; ?>
                                            
                                          <a href="{{url('/')}}/admin/public/uploads/audio/{{$otp->id}}/" class="btn default btn-edit">View Audio
                              <?php } } ?>

                                        <input type="hidden" id="cid" value="">

                                        @elseif ($otp->admin_status == '1')
                                
                                            <a href="javascript:void(0);" id="valid_{{$otp->id}}" class="update_status btn default btn-edit">
                                                Valid
                                            </a>
                                            <a href="javascript:void(0);" id="invalid_{{$otp->id}}" style="display: none;" class="update_status btn default btn-delete">
                                                In Valid
                                            </a>
                                            <a href="javascript:void(0);" id="reset_{{$otp->id}}" class="update_status btn default">
                                                Reset
                                            </a>

                                            <a   class="btn default etst" href="{{url('/')}}/detail/{{$otp->url_name}}"  target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Detail"></i></a>

                                            <a href="{{url('/')}}/admin/otplisting/audio/{{$otp->id}}" class="btn default btn-edit">Upload audio
                                            </a>

                                <?php
                                       if($otp->audio_id){
                                      $directory = "public/uploads/audio/".$otp->id;
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = ''; ?>
                                   
                                          <a href="{{url('/')}}/admin/public/uploads/audio/{{$otp->id}}/" class="btn defaults btn-edit">View Audio   
                                     
                              <?php } } ?>

                                        @else
                                            <a href="javascript:void(0);" id="valid_{{$otp->id}}" style="display: none;" class="update_status btn default btn-edit">
                                                Valid
                                            </a>
                                            <a href="javascript:void(0);" id="invalid_{{$otp->id}}" class="update_status btn default btn-delete">
                                                In Valid
                                            </a>
                                            <a href="javascript:void(0);" id="reset_{{$otp->id}}" class="update_status btn default">
                                                Reset
                                            </a>
                                            <a  class="btn default etst" href="{{url('/')}}/detail/{{$otp->url_name}}"  target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Detail"></i></a>
                                            <a href="{{url('/')}}/admin/otplisting/audio/{{$otp->id}}" class="btn default btn-edit">Upload audio
                                            </a>

                                  <?php
                                    if($otp->audio_id){  
                                      $directory = "public/uploads/audio/".$otp->id;
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = ''; ?>
                                   
                                          <a href="{{url('/')}}/admin/public/uploads/audio/{{$otp->id}}/" class="btn default btn-edit">View Audio

                                      <?php } } ?>


                                        @endif
                                    </td>
                                    @endif


                                    @if (Sentinel::inRole('vendor'))
                                  
                                    <td>
                                        @if ($otp->admin_status == '2')
                                        <a href="javascript:void(0);" id="valid_{{$otp->id}}" class=" btn default btn-edit">
                                            Valid
                                        </a>
                                        <a href="javascript:void(0);" id="invalid_{{$otp->id}}" class=" btn default btn-delete">
                                            In 
                                        </a>
                                        @elseif ($otp->admin_status == '1')
                                            <a  href="javascript:void(0);" id="valid_{{$otp->id}}" class=" btn default btn-edit">
                                                Valid
                                            </a>
                                        @else
                                            <a  href="javascript:void(0);" id="invalid_{{$otp->id}}" class=" btn default btn-delete">
                                                In Valid
                                            </a>
                                    @endif

                                    <?php

                                      $directory = "public/uploads/audio/".$otp->id;

                                      if($otp->audio_id){
                                        if (is_dir($directory)) {
                                        $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                        $img = ''; ?>
                                        <a href="{{url('/')}}/admin/public/uploads/audio/{{$otp->id}}/" class="btn default btn-edit">View Audio</a>
                                    <?php } ?>
                                  <?php } ?>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            @else
                            <tr>
                              <td colspan="6" align="center">No Result Found</td>
                            </tr>
                            @endif
                       </tbody>
                    </table>
                    <input type="submit" name="submit" value="Multiple Delete" class="alldelete">
                    </form>
                 </div>
                </div>
           </div>
           {{ $otpListing->appends(request()->query())->links() }}
        </div>
    </div>    <!-- row-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Product</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <input type="hidden" name="bookId" id="bookId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="btn_ok_1" class="btn btn-primary">Sure</button>
            </div>
        </div>
    </div>
  </div>

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/datepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
<script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/adduser.js') }}"></script>
<script>



  $(document).ready(function(){
    var submit = $(".alldelete").css('display','none');
  });
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var productID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'product/delete/'+productID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+productID).css('display','none');
                }
           }
        });
    });
</script>

<script type="text/javascript">

function getdata() {
    var vendor=$("#vendor").val();
    var review=$('#review').val();
    var category=$('#category').val();
    var sub_cat=$('#sub_cat').val();

    if (vendor !== '') {
        $("#listing").show();

        $.ajax({
            method:'POST',
            url:'/admin/report',
            data:{v:vendor,r:review,c:category,sc:sub_cat},
            success:function(data)
            {
                $("#listing").empty();
                $("#listing").append('<option value="">Select Listing</option>');
                $('#listing').append($.parseJSON(data).select);
            }
        });
    } else {
        $("#listing").empty();
        $("#listing").append('<option value="">Select Listing</option>');
    }
}

$('#vendor').change(getdata);

jQuery("#category").on('change',function(){
    var category="";
    var cat=$('#category').val();

    if (cat != '') {
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/report/add/sub')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    $('#sub_cat').show();
                    //Empty Drop Down
                    $("#sub_cat").empty();
                    $("#sub_cat").append('<option value="">Select Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#sub_cat").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })

        //Populate Vendor Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/report/add/vendor')}}?category="+this.value+"&sub_cat=",
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#vendor").empty();
                    $("#vendor").append('<option value="">Vendor</option>');
                    $.each( data, function( key, value ) {
                        $("#vendor").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                    });
                }
            }
        })

        //Rest the listing drop down
        $("#listing").empty();
        $("#listing").append('<option value="">Select Listing</option>');

    } else {
        $("#sub_cat").empty();
        $("#sub_cat").append('<option value="">Sub Category</option>');
    }
});

$("#sub_cat").on('change',function(){

    var cat = $('#category').val();
    var sub_cat = $("#sub_cat").val();

    $.ajax({
        type:"GET",
        dataType: "json",
        url:"{{url('/admin/report/add/vendor')}}?category="+cat+"&sub_cat="+sub_cat,
        success:function(data){
            if ( data ) {
                //Empty Drop Down
                $("#vendor").empty();
                $("#vendor").append('<option value="">Select Vendor</option>');
                $.each( data, function( key, value ) {
                    $("#vendor").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                });
            }
        }
    })

    //Rest the listing drop down
    $("#listing").hide();
    $("#listing").empty();
    $("#listing").append('<option value="">Select Listing</option>');
});

$(".update_status").on('click',function(){
 

    var arr = this.id.split('_');
   
    //Send the
    $.ajax({
        type:"GET",
        dataType: "json",
        url:"{{url('/admin/otplisting/update')}}?status="+this.id,
        success:function(data){
            if (data == '1') {
                $("#invalid_"+arr[1]).css("display","none");
                $("#reset_"+arr[1]).show();
            } else if(data == '2'){
                $("#reset_"+arr[1]).css("display","none");
                $("#valid_"+arr[1]).show();
                $("#invalid_"+arr[1]).show();
            } else {
                $("#valid_"+arr[1]).css("display","none");
                $("#reset_"+arr[1]).show();
            }
        },
        error:function(result) {
          alert(result);
        }
    })
});

$(".delete").on('click',function(){

        var cityids = $(this).data('id');
        $("#cid").val(cityids);
        var ciid = $("#cid").val();
        alert(ciid);
        
        $.ajax({
           type:'POST',
           url:'otplisting/deleteaudio/'+ciid,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                $('.successs').text('akljsbdkajsbdjkasd');
                   //location.reload();
           },
           error:function(err){
              
           }
        });
    });
  
  
  $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker();
    });


var submit = $(".alldelete").hide();
$("#checkall").change(function () {
    var cbs = $("input:checkbox").prop('checked', $(this).prop("checked"));
    submit.toggle(cbs.is(":checked") );
});


$(".cb-element").change(function () {
  
  if($(".cb-element").length==$(".cb-element:checked").length){
      $("#checkall").prop('checked', true);
  } else{
       $("#checkall").prop('checked', false);
  }
    var flag = 0;
    $('input[type=checkbox]').each(function () {
        if (this.checked) {
                   flag ++;
        }               
    });
    if (flag >= 1) {
      $(".alldelete").css('display','block')
    }else{
      $(".alldelete").css('display','none')
    }
});
</script>
@stop