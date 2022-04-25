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
    <h1>All Category</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">All Category</li>
    </ol>
</section>

<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">

            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-title">
                    <div class="caption">
                       All Category
                    </div>
                </div>

                <form method="get" id="category">
                    <select name="cate" id="categoryname">
                    <option value="">Select Category</option>
                    <?php
                        foreach ($category as $key => $value) { ?>
                            <?php if($cat_id == $value->id): ?>
                                <option value="<?php echo e($value->id); ?>" selected="selected"> <?php echo e($value->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo e($value->id); ?>"> <?php echo e($value->name); ?></option>
                            <?php endif; ?>
                        <?php }
                    ?>
                    </select>
                    <input type="submit" id="submit" value="Submit">
                    <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
                </form>

                <input type="hidden" name="cat_id" value="<?php echo e($cat_id); ?>" id="cat_id">

                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="printableArea">
                            <thead>
                            <tr>
                                <th align="center" class="ac">Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th class="ac">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($category_list as $key => $value) { ?>
                                    <tr id="tr_<?php echo e($value->id); ?>">
                                        <td class="ac" align="center">
                                            <?php if($value->image): ?>
                                            <img src="<?php echo e(url('/')); ?>/public/images/category/<?php echo e($cat_id); ?>/<?php echo e($value->image); ?>" class="testimonial-user" >
                                            <?php else: ?>
                                             <img src="<?php echo e(asset('public/images/noimage.png')); ?>" class="prodctimg" class="testimonial-user" width="50px" height="50px">
                                            <?php endif; ?>
                                        </td>

                                        <td><?php echo $value->name; ?></td>
                                        <td><?php echo ucfirst($value->slug); ?></td>
                                        <td class="ac">
                                            <a href="categories/edit/<?php echo e($cat_id); ?>/<?php echo e($value->id); ?>" class="btn default btn-edit">Edit
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="<?php echo e($value->id); ?>" class="onclick btn btn-delete">
                                                Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                        <?php echo $category_list->appends(['cate' => $cat_id  ])->render(); ?>

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
      <h4 class="modal-title" id="myModalLabel">Delete Testimonial</h4>
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
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var testimonialID = jQuery("#bookId").val();
        var id = jQuery("#cat_id").val();

        $.ajax({
           type:'POST',
           url:'categories/delete/'+id+'/'+testimonialID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+testimonialID).css('display','none');
                }
           }
        });
    });
</script>
<script src="<?php echo e(asset('public/assets/js/table2excel.js')); ?>"></script>
<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "SystemCategory_details"
                });
            });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>