<?php $__env->startSection('title'); ?>
Add Category
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('public/assets/vendors/select2/css/select2.min.css')); ?>" type="text/css" rel="stylesheet">
<link href="<?php echo e(asset('public/assets/vendors/select2/css/select2-bootstrap.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('public/assets/vendors/iCheck/css/all.css')); ?>"  rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/css/pages/wizard.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Edit Property List</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Edit Property List</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Property List</h4>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <div class="panel-body">

                <form method="post" id="addtestimonail">
                     <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <fieldset>
                                <!-- Name input-->          

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Title <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="title" name="title" type="text" class="form-control" value="<?php echo e($edit_data[0]->title); ?>" >
                                    </div></div>              

                                    <div class="form-group  row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Link <span style="color:red"> * </span> </label><div class="col-md-10 col-sm-9">
                                        <input id="link" name="link" type="text" class="form-control" value="<?php echo e($edit_data[0]->link); ?>"  >
                                    </div></div>
                                                             
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>
    <script src="<?php echo e(asset('public/assets/vendors/moment/js/moment.min.js')); ?>" ></script>
    <script src="<?php echo e(asset('public/assets/vendors/iCheck/js/icheck.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>"  type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/select2/js/select2.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/js/pages/edituser.js')); ?>"></script>


<script type="text/javascript">
$(document).ready(function () {

    $('#addtestimonail').validate({
        rules: {
            
            title: {
                required: true
            },
            link:{
                required:true
            },
        },
        messages:{
            title:{
                required:"Please select sub category",
            },
            link:{
                required:"First name is required",
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>