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
    <h1>All Property Listing</h1>

    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>

        <li class="active">All Property Listing</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="property_search" method="get" autocomplete="off">
        <?php if(session()->has('status')): ?>
                <div class="alert alert-success" role="alert" id="success-alert">
                    <?php echo e(session()->get('status')); ?>

                </div>
            <?php endif; ?>

         <div style="color: red;">
           Notes : use this link listing?s_key=&s_city=&s_category=1&s_type=             
         </div>   
        
    </form>
</div>
<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">

            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($property_list)): ?>
                            <?php $__currentLoopData = $property_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="tr_<?php echo e($property_detail->id); ?>">
                            <td><?php echo e($property_detail->title); ?></td>
                            <td><?php echo e($property_detail->link); ?></td>
                            <td>          

                                 <a href="manage_property_list/edit/<?php echo e($property_detail->id); ?>" class="btn default btn-edit">Edit
                                            </a>      

                                <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="<?php echo e($property_detail->id); ?>" class="onclick btn btn-delete">
                                                Delete
                                </a>    

                                <a class="btn default" href="<?php echo e(url('/')); ?>/<?php echo e($property_detail->link); ?>" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View"></i></a>

                            </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                            <?php else: ?>
                            <tr>
                                <td colspan="10">No records found</td>
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

<div class="modal-dialog" role="document" id="tes_delete_confirm" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Delete Property Listing</h4>
    </div>
    <div class="modal-body">
        Are you sure?
    </div>
    <input type="hidden" name="bookId" id="bookId" value=""/>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="button" id="btn_ok_1" class="btn btn-primary">OK</button>
    </div>
  </div>
</div>

<script>
    $(document).on("click", ".onclick", function () {
        var myBookId = $(this).data('id');

        $(".modal-dialog #bookId").val(myBookId);
    });

    $("#btn_ok_1").on('click',function(){
        var reviewID = $("#bookId").val();
        //alert(reviewID);
        $.ajax({
           type:'POST',
           url:'manage_property_list/delete/'+reviewID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+reviewID).css('display','none');
                }
           }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>