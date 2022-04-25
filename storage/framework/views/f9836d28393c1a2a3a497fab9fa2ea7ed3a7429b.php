<?php $__env->startSection('title'); ?>

OTPListing

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##

<?php $__env->stopSection(); ?>





<?php $__env->startSection('header_styles'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />

<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo e(asset('public/assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo e(asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?>

<section class="content-header">

    <h1>Vendor Product Brochure</h1>

    <ol class="breadcrumb">

        <li>

            <a href="<?php echo e(route('admin.dashboard')); ?>">

                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>

                Dashboard

            </a>

        </li>

        <li class="active">Vendor Product Brochure</li>

    </ol>

</section>

<!-- Main content -->

<section class="content paddingleft_right15">

    <div class="row">

        <div class="portlet box warning">

                <div class="portlet-title">

                <div class="portlet-body testimoniallist">

                 <div class="table-responsive">

                    <table class="table table-bordered">

                       <thead>

                          <tr>

                             <th>Vendor Name</th>

                             <th>Action</th>

                          </tr>

                       </thead>

                       <tbody>      

                        <?php $__currentLoopData = $usde; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usdes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>

                                    <td> <?php echo e($usdes->l_title); ?> </td>

                                    <td><a target="_blank" href="<?php echo e(url('/')); ?>/admin/brochure/<?php echo e($usdes->id); ?>" class="btn btn success" data-id="<?php echo e($usdes->id); ?>" style="color: white">Create Brochure</a>

                                    </td>

                                </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    

                       </tbody>

                    </table>

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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>