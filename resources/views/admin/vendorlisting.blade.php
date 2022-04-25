@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
VendorListing
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1><?php echo (Sentinel::inRole('vendor')) ? 'Profile' : 'Listings'?></h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>

        <li class="active"><?php echo (Sentinel::inRole('vendor')) ? 'Profile' : 'Listings'?></li>

    </ol>

</section>

<!-- Main content -->
<section class="content paddingleft_right15">
  

    <div class="row">
        <div class="col-lg-12">
          @if(Sentinel::inRole('admin'))
          <h5>Total Properties : ({{$total_properties}}) &nbsp;&nbsp;&nbsp;
          Total Consultancy : ({{$total_consultancy}}) &nbsp;&nbsp;&nbsp;
          Total Contractor : ({{$total_contractor}})&nbsp;&nbsp;&nbsp;
          Total Material : ({{$total_material}})</h5>
          @endif
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <?php echo (Sentinel::inRole('vendor')) ? 'Company Info' : 'All Listing'?>

                    </h4>

                    @if(Sentinel::inRole('admin'))
                        <div class="pull-right">
                            <a href="vendorlisting/add" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                        </div>
                    @endif
                </div>

                @if (!Sentinel::inRole('vendor'))
                    <div class="">
                        <form class="reportform padd15" method="get" name="inquiry">
                            <select name="category" id="category">
                                <option value="">Select Category</option>
                                @foreach($category as $c)
                                    @if (isset($cate) && $c->id == $cate)
                                      <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                    @else
                                      <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endif
                                @endforeach
                            </select>

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

                            <select name="vendor" id="vendor">
                                <option value="">Select Vendor</option>
                                @if(!empty($ven))
                                  @foreach($ven as $d)
                                    @if ($d->u_id == $vendor)
                                      <option value="{{$d->u_id}}" selected>{{$d->company_name}}</option>
                                    @else
                                      <option value="{{$d->u_id}}">{{$d->company_name}}</option>
                                    @endif
                                  @endforeach
                                @endif
                            </select>

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

                            <select name="city" id="l_city">
                                <option value="">Select city</option>
                                @if (!empty($area_info))
                                  @foreach($area_info as $d)
                                   @if (isset($city) && $d->City_Id == $city)
                                    <option value="{{$d->City_Name}}" selected>{{$d->City_Name}}</option>
                                     @else
                                      <option value="{{$d->City_Name}}">{{$d->City_Name}}</option>
                                    @endif
                                  @endforeach
                                @endif
                            </select>

                          <select name="area" id="state">
                                <option value="">Select area</option>
                            </select>


                            <input type="submit" value="Submit" id="submit">
                            <a href="{{url('/')}}/admin/vendorlisting"  data-toggle="tooltip" title="" data-original-title="Reset" class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </form>
                    </div>
                @endif

                <div class="panel-body productimges ">
                 <div class="table-responsive ">
                    <table class="table table-bordered">
                       <thead>
                          <tr>
                             <th>Image</th>
                             <th>Listing Information</th>
                             <th>Action</th>
                          </tr>
                       </thead>
                       <tbody>
                         
                            @if(!empty($vendorList))
                            @foreach($vendorList as $vlisting)

                                <tr id="tr_{{$vlisting->vl_id}}">
                                    <?php
                                      $directory = "public/images/".$vlisting->vl_id."/featured_image/";
                                      $directory1 = "public/images/".$vlisting->vl_id."/pics/";
                                      if(is_dir($directory)){
                                        if(is_dir($directory) && count(glob("$directory/*")) !== 0){
                                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                          $img = '';
                                        foreach ($files as $key => $value) { ?>

                                        <td>
                                            <img src="{{ asset('public/images') }}/{{$vlisting->vl_id}}/featured_image/{{ $value }}" class="prodctimg">
                                        </td> <?php
                                    } }else { ?>
                                        <td><img src="{{ asset('public/images/noimage.png') }}"  class="prodctimg"></td>
                                    <?php }
                                }else{
                                        if (is_dir($directory1)){
                                            $files = array_values(array_diff(scandir($directory1), array('..', '.')));
                                            $img = '';
                                                foreach ($files as $key => $value) {
                                                    $img = $value;
                                                    } ?>

                                        <td>
                                            <img src="{{ asset('public/images') }}/{{$vlisting->vl_id}}/pics/{{$img}}" class="prodctimg">
                                        </td> <?php
                                    } else { ?>
                                        <td><img src="{{ asset('public/images/noimage.png') }}"  class="prodctimg"></td>
                                    <?php }
                                }
                                    ?>


                                       <!--  <td><img src="{{ asset('images/noimage.png') }}"></td> -->

                                    <td>
                                      <div class="left">
                                        <ul>
                                          <li><b>Listing Name:</b> {{ $vlisting->l_title }}</li>
                                          <li><b>Listing Description:</b> {{ App\Http\Controllers\ListingController::getExcerpt($vlisting->l_description) }}</li>
                                        </ul>
                                      </div>
                                      <div class="right">
                                        <ul>
                                          <li><b>Avg. Rating:</b> {{ $vlisting->result }}</li>
                                          <li><b>Key Area:</b> {{ $vlisting->l_key_area }}</li>
                                          <li><b>Last Updated At:</b> {{date('d/M/Y', strtotime($vlisting->updated_at))}}</li>

                                          @if($vlisting->l_featured == 1)
                                         <li style="list-style: none;"><strong class="box-success">This is Popular</strong></li>
                                          @endif
                                         <div class="spm"></div>
                                          @if($vlisting->l_prime == 1 && $vlisting->l_category == 1)
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Property</strong></li>
                                          @elseif($vlisting->l_prime == 1 && $vlisting->l_category == 2)
                                         <li style="list-style: none;"><strong class="box-success">This is Premium Consultancy</strong></li>
                                          @elseif($vlisting->l_prime == 1 && $vlisting->l_category == 3)
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Contractor</strong></li>
                                          @elseif($vlisting->l_prime == 1 && $vlisting->l_category == 4)
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Material</strong></li>
                                          @elseif($vlisting->l_prime == 1 && $vlisting->l_category == 5)
                                         <li style="list-style: none;"><strong class="box-success">This is Premium Skill Labour</strong></li>
                                          @endif
                                        </ul>
                                      </div>
                                    </td>
                                    <td class="active-icon">
                                        <a href="vendorlisting/edit/{{$vlisting->vl_id}}" class="btn btn-success"><i class="fa fa-edit"></i></a><br>
                                        @if (!Sentinel::inRole('vendor'))
                                        <a href="#" class="trash-icn btn btn-danger btn-info btn-lg onclick" data-id="{{ $vlisting->vl_id }}" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-trash"></i></a><br>
                                        @endif


                                        
                                        <a class="btn default" href="{{ url('/') }}/detail/{{$vlisting->url_name}}" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Property"></i></a>
                                       @if (Sentinel::inRole('admin'))
                                        @if($vlisting->l_status =='1')
                                        <a href="javascript:void(0);" data-id="{{ $vlisting->vl_id }}" class="onclick default btn btn-success inactive">active</a><br>
                                        <input type="hidden" name="cid" id="cid" value="">
                                        @endif
                                        @if($vlisting->l_status =='0')
                                        <a href="javascript:void(0);" data-id="{{ $vlisting->vl_id }}" class="onclick default btn btn-delete active">inactive</a><br>
                                        <input type="hidden" name="cid" id="cid" value="">
                                        @endif
                                      @endif  
                                    </td>
                                </tr>
                              
                            @endforeach

                            @endif

                       </tbody>
                    </table>
                 </div>
                </div>
           </div>
           @if (!empty($vendorList))
           {{ $vendorList->appends(request()->query())->links() }}
           @endif
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

<script>
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var productID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'vendorlisting/delete/'+productID,
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
    var city = $('#l_city').val();
    var state = $('#state').val();

    if (vendor !== '') {
        $("#listing").show();

        $.ajax({
            method:'POST',
            url:'/admin/report',
            data:{v:vendor,r:review,c:category,sc:sub_cat,ct:city,st:state},
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
            url:"{{url('/admin/report/add/vendorlist')}}?category="+this.value+"&sub_cat=",
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

        $("#vendor").empty();
        $("#vendor").append('<option value="">Select Vendor</option>');
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

</script>

<script type="text/javascript">
 $("#l_city").on('change',function(){

        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#state").empty();
                    $("#state").append('<option value="">Select Area name</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
    });
</script>
<script>
    
    $(".inactive").on('click',function(){
      location.reload();
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
        var cityids = $(this).data('id');
        $("#cid").val(cityids);
        var ciid = $("#cid").val();
        $.ajax({
           type:'POST',
           url:'vendorlisting/inactive_property/'+ciid,
           success:function(){
                $('.successs').text('akljsbdkajsbdjkasd');
                   location.reload();
                
           },
           error:function(err){
              //alert(err);
           }
        });
    });

    $(".active").on('click',function(){

        location.reload();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
        var cityidsg = $(this).data('id');
        $("#cid").val(cityidsg);
        var ciidss = $("#cid").val();
        $.ajax({
           type:'POST',
           url:'vendorlisting/active_property/'+ciidss,
           success:function(){
                 $('.successs').text('akljsbdkajsbdjkasd');
                    location.reload();
           },
           error:function(err){
                alert(err);
           }
        });
    });

</script>
@stop