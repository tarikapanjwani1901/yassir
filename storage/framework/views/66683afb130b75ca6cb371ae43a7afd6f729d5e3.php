<?php $__env->startSection('title'); ?>
Reviews
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<section class="content-header">
    <h1>Manage Contact</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Manage Contact</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-body">
                <div class="table-responsive">
                        <table class="table table-bordered">                       
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Phone No.</th>
                                <th>Email Id</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>

                           <?php if(count($contact)): ?>
                                <?php $__currentLoopData = $contact; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <tr id="tr_<?php echo e($s->id); ?>">
                                        <td><?php echo e($s->description); ?></td>
                                         <td><?php echo e($s->address); ?></td>
                                         <td><?php echo e($s->phone_no); ?></td>
                                         <td><?php echo e($s->email_id); ?></td>
                                        <td> 
                                            <a href="<?php echo e(url('/')); ?>/admin/edit_contact_detail/<?php echo e($s->id); ?>" class="onclick default btn btn-success" >  Edit
                                            </a>
                                            <a href="<?php echo e(url('/')); ?>/contact-us" class="onclick default btn btn-success"  target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Page"></i>
                                            </a>
                                            <input type="hidden" name="cid" id="cid" value="">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5">No result found</td>
                                </tr>    
                            <?php endif; ?>
                        </tbody>
                   
                    </table>
                   
                </div>
            </div>
        </div>
    </div>    <!-- row-->    

</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>