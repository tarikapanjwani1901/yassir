<?php $__env->startSection('title'); ?>
Add Vendor Listing
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Add Slider Image</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Add Slider Image</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary testimonialadd">
        <div class="panel-heading">
          <h4 class="panel-title">Add Slider Image</h4>
        </div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data">
            <div class="form-group galleryphotos">
                <div class="row">
                    <label class="col-sm-12 control-label" for="form-file-multiple-input">Slider Image</label>

                    <div class="col-sm-12">
                          <div class="sliderimages">
                        <input type="file" id="form-file-multiple-input" name="inputFile">
                         <input type="submit" value="Upload" class="btn btn-primary" >
                         <img id="image_upload_preview" height="100" width="100" style="display: none;" />
                              </div>
                      </div>
                          <div class="col-sm-12 pad-top20">
                        <?php
                            $directory = "public/images/home_galery";
                            if (is_dir($directory)) {
                            $files = array_values(array_diff(scandir($directory), array('..', '.')));
                            $img = '';
                            foreach ($files as $key => $value) { ?>
                              <div id="d_<?php echo e($key); ?>" class="productimg">
                                <img src="/public/images/home_galery/<?php echo e($value); ?>" id="img_<?php echo e($key); ?>">

                               <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove img_remove"  id="<?php echo e($key); ?>"></span>
                               </a>
                             </div>
                            <?php } }
                        ?>
                    </div>
                </div>
            </div>
      <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
      </form>

      <form method="post" enctype="multipart/form-data" action="<?php echo e(url('admin/add_image')); ?>">
          <div class="form-group galleryphotos">
              <div class="row">
                  <label class="col-sm-12 control-label" for="form-file-multiple-input">Add Video</label>

                  <div class="col-sm-12">
                        <div class="sliderimages">
                      <input type="file" id="form-file-multiple-input1" name="inputFile">
                       <input type="submit" value="Upload" class="btn btn-primary" >
                            </div>
                    </div>
                        <div class="col-sm-12 pad-top20">
                      <?php
                          $directory = "public/images/home_add";
                          if (is_dir($directory)) {
                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                          $img = '';
                          foreach ($files as $key => $value) { ?>
                            <div id="add_<?php echo e($key); ?>" class="productimg">
                             

                             <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove video_remove"  id="<?php echo e($key); ?>"></span>
                             </a>
                           </div>
                          <?php } }
                      ?>
                  </div>
              </div>
          </div>
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
      </form>
       <form method="post" enctype="multipart/form-data" action="<?php echo e(url('admin/brand_image')); ?>">
          <div class="form-group galleryphotos">
              <div class="row">
                  <label class="col-sm-12 control-label" for="form-file-multiple-input">Add Brand Logo</label>

                  <div class="col-sm-12">
                        <div class="sliderimages">
                      <input type="file" id="form-file-multiple-input2" name="brand_file">
                       <input type="submit" value="Upload" class="btn btn-primary" >
                       <img id="image_upload_preview2" height="100" width="100" style="display: none;" />
                            </div>
                    </div>
                        <div class="col-sm-12 pad-top20">
                      <?php
                          $directory = "public/images/brand";
                          if (is_dir($directory)) {
                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                          $img = '';
                          foreach ($files as $key => $value) { ?>
                            <div id="add_<?php echo e($key); ?>" class="productimg">
                              <img src="/public/images/brand/<?php echo e($value); ?>" id="imgrmv<?php echo e($key); ?>">

                             <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove brand_remove"  id="<?php echo e($key); ?>"></span>
                             </a>
                           </div>
                          <?php } }
                      ?>
                  </div>
              </div>
          </div>
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
      </form>
  </div>
  </div>
  </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

  <script>
  	$('.img_remove').click(
    function()
    {
      var file = $("#img_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"<?php echo e('/admin/vendorlisting/del_image'); ?>",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#d_"+id).hide();
           window.location.reload();
         }
      });

 });

    $('.brand_remove').click(
    function()
    {
      
      var file = $("#imgrmv"+this.id).attr("src");
      var id = this.id;
      
      $.ajax({
        type:"POST",
        url:"<?php echo e(url('/')); ?>/<?php echo e('admin/vendorlisting/del_video'); ?>",
        data:{file:file},
        dataType: "json",
        success: function(data){
          $("#imgrmv"+id).hide();
          window.location.reload();
         }
      });

 });

      $('.imgadd_remove').click(
    function()
    {
      var file = $("#imgadd_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"<?php echo e('/admin/vendorlisting/del_image'); ?>",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#add_"+id).hide();
           window.location.reload();
         }
      });

 });

      $('.video_remove').click(
    function()
    {
      
      var file = $("#imgadd_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"<?php echo e(url('/')); ?>/<?php echo e('admin/vendorlisting/del_video'); ?>",
        data:{file:file},
        dataType: "json",
        success: function(data){
          $("#imgadd_"+id).hide();
           window.location.reload();
         }
      });

 });
  </script>

  <script type="text/javascript">
      function readURL(input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
      $('#image_upload_preview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
      }

      $("#form-file-multiple-input").change(function () {
      $('#image_upload_preview').show();
      readURL(this);
});
       function readURL2(input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
      $('#image_upload_preview2').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
      }

      $("#form-file-multiple-input2").change(function () {
      $('#image_upload_preview2').show();
      readURL2(this);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>