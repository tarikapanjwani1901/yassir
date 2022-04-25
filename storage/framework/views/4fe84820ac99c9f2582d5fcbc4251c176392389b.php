<?php $__env->startSection('title'); ?>
Category
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>All CMS</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">All CMS</li>
    </ol>
</section>

<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">

            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-title">
                    <div class="caption">
                       All CMS
                    </div>
                </div>

                

                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($cms_info)): ?>
                            <?php $__currentLoopData = $cms_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                 <td>
                                    <?php echo e($cms->id); ?>

                                </td>
                                <td>
                                    <?php echo e($cms->title); ?>

                                </td>
                                 
                                <td>
                                        
                                    <!--
                                    <?php if($cms->status == "in-active"): ?>   
                                    <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="<?php echo e($cms->id); ?>" class="onclick default btn btn-success active" style="width:80px;" >  

                                        Active
                                    </a>
                                    <input type="hidden" name="cid" id="cid" value="">
                                    <?php endif; ?>
                                   
                                        
                                   <?php if($cms->status == "active"): ?>   
                                    <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="<?php echo e($cms->id); ?>" class="onclick default btn btn-delete inactive">   
                                    Deactive
                                    </a>
                                    <input type="hidden" name="cid" id="cid" value="">
                                    <?php endif; ?>--->
                                           
                                         <a href="manage_cms/edit/<?php echo e($cms->id); ?>" class="btn default btn-edit">Edit
                                            </a>

                                         <a href="<?php echo e(url('/')); ?>/<?php echo e($cms->link); ?>" class="btn default" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="View Page" data-original-title="reset"></i>
                                            </a>   
                                            
                                        </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">No records found</td>
                            </tr>
                            <?php endif; ?>
                            

                                

                            </tbody>
                        </table>
                        
                    </div>
                </div>
        </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>

<script>


    $(".inactive").on('click',function(){
        var cityids = $(this).data('id');
        $("#cid").val(cityids);
        var id = $("#cid").val();
       
        $.ajax({
           type:'POST',
           url:'manage_cms/inactive_cms/'+id,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                $('.successs').text('akljsbdkajsbdjkasd');
                
           }
        });
    });

    $(".active").on('click',function(){
        var cityidsg = $(this).data('id');
        $("#cid").val(cityidsg);
        var id = $("#cid").val();
       
        $.ajax({
           type:'POST',
           url:'manage_cms/active_cms/'+id,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                 $('.successs').text('akljsbdkajsbdjkasd');
           }
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>