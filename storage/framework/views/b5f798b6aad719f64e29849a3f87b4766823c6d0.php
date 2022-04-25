<?php $__env->startSection('title'); ?>
Inquires
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<style type="text/css">
  .dt1 {
    width: 150px;
    display: inline-block;
    margin-left: 6px;
}
</style>
<section class="content-header">
    <h1>Inquires</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Inquires</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="">

             <form class="reportform padd15" action="" method="get" name="inquiry" autocomplete="off">

                   <input type="search" name="inquiry_name" id="inquiry_name" placeholder="search" style="height: 33px;     width: 20%;">
                    
                    <?php if(Sentinel::inRole('admin')): ?>
                    <select class="reviewselect" name="vendors" id="vendors">
                        <option value="">Select Vendor</option>
                        <?php if(!empty($vendors_info)): ?>
                              <?php $__currentLoopData = $vendors_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if($vendors == $d->vl_id): ?>
                                <option value="<?php echo e($d->vl_id); ?>" selected="selected"><?php echo e($d->l_title); ?></option>
                                <?php else: ?>
                                  <option value="<?php echo e($d->vl_id); ?>" ><?php echo e($d->l_title); ?></option>
                                  <?php endif; ?>  
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <?php endif; ?>
                     <input id="datetimepicker6" name="from" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="Start date"/>

                          <input id="datetimepicker7" name="to" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="End date"/>
                     <input type="submit" value="Submit" id="submit">
                     <a href="<?php echo e(url('/')); ?>/admin/inquirylisting" data-toggle="tooltip" title="" data-original-title="Reset" class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </form>    

           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Inquires &nbsp;&nbsp;  
                        <?php if(Sentinel::inRole('admin')): ?>
                        (Total Inquires : <?php echo e($total_inquity); ?>)
                        <?php endif; ?>
                    </h4>
                     <div style="float: right;">
                       
                        
                               <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
                        
                    </div>
                </div>
                <br>

                <div class="panel-body">
                 <div class="table-responsive">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                            <th>Id</th>
                             <th>Vendor</th>
                             <th>Listing Name</th>
                             <th>Name</th>
                             <th>Email</th>
                             <th>Phone</th>
                             <th>Info</th>
                             <th>Date & Time</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php $i = ($inquires->currentpage()-1)*$inquires->perpage() + 1 ?>
                        <?php if(count($inquires)): ?>
                            <?php $__currentLoopData = $inquires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="tr_<?php echo e($inquire->id); ?>">
                                    <td> <?php echo e($i++); ?></td>
                                    <td> <?php echo e(ucfirst($inquire->company_name)); ?> </td>
                                    <td> <?php echo e(ucfirst($inquire->l_title)); ?> </td>
                                    <td> <?php echo e(ucfirst($inquire->iname)); ?> </td>
                                    <td> <?php echo e(ucfirst($inquire->iemail)); ?> </td>
                                    <td> <?php echo e($inquire->iphone); ?> </td>
                                    <td>
                                        <?php if($inquire->idate != ''): ?>
                                            Date: <?php echo e($inquire->idate); ?><br>
                                        <?php endif; ?>

                                        <?php if($inquire->itime != ''): ?>
                                            Time: <?php echo e($inquire->itime); ?><br>
                                        <?php endif; ?>

                                        <?php if($inquire->imessage != ''): ?>
                                            Message: <?php echo e($inquire->imessage); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td> <?php echo date('M j h:ia', strtotime($inquire->created_at)) ?> </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <td colspan="8">No Result Found</td>
                            <?php endif; ?>
                       </tbody>
                    </table>
                    <?php echo e($inquires->links()); ?>

                 </div>
                </div>
           </div>
        </div>
    </div>    <!-- row-->

</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
<script src="<?php echo e(asset('public/assets/vendors/moment/js/moment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/daterangepicker/js/daterangepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/clockface/js/clockface.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/js/pages/datepicker.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('public/assets/vendors/iCheck/js/icheck.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/select2/js/select2.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/js/pages/adduser.js')); ?>"></script>
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
            url:"<?php echo e(url('/admin/report/add/vendor')); ?>?category="+this.value+"&sub_cat=",
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


$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "employee_detail"
                });
            });
$(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker();
    });
</script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>