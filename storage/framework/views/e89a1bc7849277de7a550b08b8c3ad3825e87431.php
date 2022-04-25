<?php $__env->startSection('title'); ?>
VendorListing
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1><?php echo (Sentinel::inRole('vendor')) ? 'Profile' : 'Listings'?></h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
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
          <?php if(Sentinel::inRole('admin')): ?>
          <h5>Total Properties : (<?php echo e($total_properties); ?>) &nbsp;&nbsp;&nbsp;
          Total Consultancy : (<?php echo e($total_consultancy); ?>) &nbsp;&nbsp;&nbsp;
          Total Contractor : (<?php echo e($total_contractor); ?>)&nbsp;&nbsp;&nbsp;
          Total Material : (<?php echo e($total_material); ?>)</h5>
          <?php endif; ?>
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <?php echo (Sentinel::inRole('vendor')) ? 'Company Info' : 'All Listing'?>

                    </h4>

                    <?php if(Sentinel::inRole('admin')): ?>
                        <div class="pull-right">
                            <a href="vendorlisting/add" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if(!Sentinel::inRole('vendor')): ?>
                    <div class="">
                        <form class="reportform padd15" method="get" name="inquiry">
                            <select name="category" id="category">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($cate) && $c->id == $cate): ?>
                                      <option value="<?php echo e($c->id); ?>" selected><?php echo e($c->name); ?></option>
                                    <?php else: ?>
                                      <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <select name="sub_cat" id="sub_cat">
                                <option value="">Select Sub Category</option>
                                <?php if ($type) {
                                    foreach ($type as $key => $value) { ?>
                                        <?php if($subCate == $value->id): ?>
                                            <option value="<?php echo e($value->id); ?>" selected><?php echo e($value->name); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
                                        <?php endif; ?>

                                    <?php }
                                } ?>
                            </select>

                            <select name="vendor" id="vendor">
                                <option value="">Select Vendor</option>
                                <?php if(!empty($ven)): ?>
                                  <?php $__currentLoopData = $ven; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($d->u_id == $vendor): ?>
                                      <option value="<?php echo e($d->u_id); ?>" selected><?php echo e($d->company_name); ?></option>
                                    <?php else: ?>
                                      <option value="<?php echo e($d->u_id); ?>"><?php echo e($d->company_name); ?></option>
                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>

                             <select name="listing" id="listing">
                                <option value="">Select Listing</option>
                                <?php if(!empty($venListing)): ?>
                                  <?php $__currentLoopData = $venListing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($d->vl_id == $listing): ?>
                                      <option value="<?php echo e($d->vl_id); ?>" selected><?php echo e($d->l_title); ?></option>
                                    <?php else: ?>
                                      <option value="<?php echo e($d->vl_id); ?>"><?php echo e($d->l_title); ?></option>
                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>

                            <select name="city" id="l_city">
                                <option value="">Select city</option>
                                <?php if(!empty($area_info)): ?>
                                  <?php $__currentLoopData = $area_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <?php if(isset($city) && $d->City_Id == $city): ?>
                                    <option value="<?php echo e($d->City_Name); ?>" selected><?php echo e($d->City_Name); ?></option>
                                     <?php else: ?>
                                      <option value="<?php echo e($d->City_Name); ?>"><?php echo e($d->City_Name); ?></option>
                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>

                          <select name="area" id="state">
                                <option value="">Select area</option>
                            </select>


                            <input type="submit" value="Submit" id="submit">
                            <a href="<?php echo e(url('/')); ?>/admin/vendorlisting"  data-toggle="tooltip" title="" data-original-title="Reset" class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </form>
                    </div>
                <?php endif; ?>

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
                         
                            <?php if(!empty($vendorList)): ?>
                            <?php $__currentLoopData = $vendorList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vlisting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr id="tr_<?php echo e($vlisting->vl_id); ?>">
                                    <?php
                                      $directory = "public/images/".$vlisting->vl_id."/featured_image/";
                                      $directory1 = "public/images/".$vlisting->vl_id."/pics/";
                                      if(is_dir($directory)){
                                        if(is_dir($directory) && count(glob("$directory/*")) !== 0){
                                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                          $img = '';
                                        foreach ($files as $key => $value) { ?>

                                        <td>
                                            <img src="<?php echo e(asset('public/images')); ?>/<?php echo e($vlisting->vl_id); ?>/featured_image/<?php echo e($value); ?>" class="prodctimg">
                                        </td> <?php
                                    } }else { ?>
                                        <td><img src="<?php echo e(asset('public/images/noimage.png')); ?>"  class="prodctimg"></td>
                                    <?php }
                                }else{
                                        if (is_dir($directory1)){
                                            $files = array_values(array_diff(scandir($directory1), array('..', '.')));
                                            $img = '';
                                                foreach ($files as $key => $value) {
                                                    $img = $value;
                                                    } ?>

                                        <td>
                                            <img src="<?php echo e(asset('public/images')); ?>/<?php echo e($vlisting->vl_id); ?>/pics/<?php echo e($img); ?>" class="prodctimg">
                                        </td> <?php
                                    } else { ?>
                                        <td><img src="<?php echo e(asset('public/images/noimage.png')); ?>"  class="prodctimg"></td>
                                    <?php }
                                }
                                    ?>


                                       <!--  <td><img src="<?php echo e(asset('images/noimage.png')); ?>"></td> -->

                                    <td>
                                      <div class="left">
                                        <ul>
                                          <li><b>Listing Name:</b> <?php echo e($vlisting->l_title); ?></li>
                                          <li><b>Listing Description:</b> <?php echo e(App\Http\Controllers\ListingController::getExcerpt($vlisting->l_description)); ?></li>
                                        </ul>
                                      </div>
                                      <div class="right">
                                        <ul>
                                          <li><b>Avg. Rating:</b> <?php echo e($vlisting->result); ?></li>
                                          <li><b>Key Area:</b> <?php echo e($vlisting->l_key_area); ?></li>
                                          <li><b>Last Updated At:</b> <?php echo e(date('d/M/Y', strtotime($vlisting->updated_at))); ?></li>

                                          <?php if($vlisting->l_featured == 1): ?>
                                         <li style="list-style: none;"><strong class="box-success">This is Popular</strong></li>
                                          <?php endif; ?>
                                         <div class="spm"></div>
                                          <?php if($vlisting->l_prime == 1 && $vlisting->l_category == 1): ?>
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Property</strong></li>
                                          <?php elseif($vlisting->l_prime == 1 && $vlisting->l_category == 2): ?>
                                         <li style="list-style: none;"><strong class="box-success">This is Premium Consultancy</strong></li>
                                          <?php elseif($vlisting->l_prime == 1 && $vlisting->l_category == 3): ?>
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Contractor</strong></li>
                                          <?php elseif($vlisting->l_prime == 1 && $vlisting->l_category == 4): ?>
                                          <li style="list-style: none;"><strong class="box-success">This is Premium Material</strong></li>
                                          <?php elseif($vlisting->l_prime == 1 && $vlisting->l_category == 5): ?>
                                         <li style="list-style: none;"><strong class="box-success">This is Premium Skill Labour</strong></li>
                                          <?php endif; ?>
                                        </ul>
                                      </div>
                                    </td>
                                    <td class="active-icon">
                                        <a href="vendorlisting/edit/<?php echo e($vlisting->vl_id); ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><br>
                                        <?php if(!Sentinel::inRole('vendor')): ?>
                                        <a href="#" class="trash-icn btn btn-danger btn-info btn-lg onclick" data-id="<?php echo e($vlisting->vl_id); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-trash"></i></a><br>
                                        <?php endif; ?>


                                        
                                        <a class="btn default" href="<?php echo e(url('/')); ?>/detail/<?php echo e($vlisting->url_name); ?>" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Property"></i></a>
                                       <?php if(Sentinel::inRole('admin')): ?>
                                        <?php if($vlisting->l_status =='1'): ?>
                                        <a href="javascript:void(0);" data-id="<?php echo e($vlisting->vl_id); ?>" class="onclick default btn btn-success inactive">active</a><br>
                                        <input type="hidden" name="cid" id="cid" value="">
                                        <?php endif; ?>
                                        <?php if($vlisting->l_status =='0'): ?>
                                        <a href="javascript:void(0);" data-id="<?php echo e($vlisting->vl_id); ?>" class="onclick default btn btn-delete active">inactive</a><br>
                                        <input type="hidden" name="cid" id="cid" value="">
                                        <?php endif; ?>
                                      <?php endif; ?>  
                                    </td>
                                </tr>
                              
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>

                       </tbody>
                    </table>
                 </div>
                </div>
           </div>
           <?php if(!empty($vendorList)): ?>
           <?php echo e($vendorList->appends(request()->query())->links()); ?>

           <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

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
            url:"<?php echo e(url('/admin/report/add/sub')); ?>?category="+this.value,
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
            url:"<?php echo e(url('/admin/report/add/vendorlist')); ?>?category="+this.value+"&sub_cat=",
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
        url:"<?php echo e(url('/admin/report/add/vendor')); ?>?category="+cat+"&sub_cat="+sub_cat,
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
            url:"<?php echo e(url('/getareas')); ?>?City_Id="+City_Id,
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>