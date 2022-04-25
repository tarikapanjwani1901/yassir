<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->getFromJson('blog/title.add-blog'); ?> :: ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>

    <link href="<?php echo e(asset('public/assets/vendors/summernote/summernote.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/vendors/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public/assets/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/css/pages/blog.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>">
    <!--end of page level css-->
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<section class="content-header">
    <!--section starts-->
    <h1><?php echo app('translator')->getFromJson('blog/title.add-blog'); ?></h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>"> <i class="livicon" data-name="home" data-size="14" data-c="#000" data-loop="true"></i>
                <?php echo app('translator')->getFromJson('general.home'); ?>
            </a>
        </li>
        <li>
            <a href="#"><?php echo app('translator')->getFromJson('blog/title.blog'); ?></a>
        </li>
        <li class="active"><?php echo app('translator')->getFromJson('blog/title.add-blog'); ?></li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <!--main content-->
    <div class="row">
        <div class="the-box no-border">
            <form method="POST" autocomplete="off" id="cms_info">
           <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group <?php echo e($errors->first('title', 'has-error')); ?>">
                            <input type="text" name="title" id="title" placeholder="Title" class="form-control input-lg" value="<?php echo e($edit_data[0]->title); ?>">
                        </div>
                        <div class='box-body pad form-group'>
                            <textarea rows='5' name="description" id="description" class='textarea form-control' style="width: 100%; height: 200px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $edit_data[0]->description  ?></textarea>
                           
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="form-group pull-right">
                            <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                        </div>     
                </div>
            </form>
        </div>
    </div>
    <!--main content ends-->
</section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>
<!-- begining of page level js -->
<!--edit blog-->
<script src="<?php echo e(asset('public/assets/vendors/summernote/summernote.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/select2/js/select2.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js')); ?>" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/pages/add_newblog.js')); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {

    $('#cms_info').validate({
        rules: {
            
            title: {
                required: true
            },
            description:{
                required: true
            },
            
        },
        messages:{
            subcategory:{
                required:"Please select sub category",
            },
            first_name:{
                required:"First name is required",
            },
        },
    });
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>