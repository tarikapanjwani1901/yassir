<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div id="main" class="inner-content  product-detail1">
      <div class="commonttl-subttl paddtop">
         <!--   <div class="lightttl">Catalog of Categories</div>-->
            <h2><?php echo e($category[0]->cate_name); ?></h2>
            <span><?php echo e($category[0]->cate_desc); ?></span>
        </div>
<div class="container-fluid">
    <!--repet this in loop-->
     <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-sm-12">
    <div class="detailbox">
    <div class="like-product">
      <span> <i class="fa fa-heart"></i> </span>
    </div>
      <div class="row">
         <div class="col-sm-5 text-center">
             <figure>
              <?php if($d->product_img != ''): ?>
                <img src="/public/images/product/<?php echo e($d->id); ?>/<?php echo e($d->product_img); ?>" alt="product">
              <?php else: ?>
                <img src="/public/images/noimage.png" alt="noimage">
              <?php endif; ?>


              <!-- <div class="text-center">

                  <a class="commonbtn" href="#">Get a Best Quote <i class="fa fa-angle-right" aria-hidden="true"></i></a>

              </div> --></figure>
          </div>
          <div class="col-sm-7">
            <h3><?php echo e($d->product_name); ?></h3>

                <div class="price">
                  <?php if($d->product_price != '0'): ?>
                 Approx Price: <strong><?php echo e($d->product_price); ?> /Piece</strong>
                  <?php else: ?>
                For Price Contact Vendor
                <?php endif; ?>
                </div>

                <?php if($d->product_qty != '0'): ?>
              <div class="minumorder">Minimum Order Quantity: <strong><?php echo e($d->product_qty); ?></strong> </div><br>
              <?php endif; ?>


              <p><?php echo e($d->product_detail); ?></p>

              <div class="text-centr">
              <a class="commonbtn" href="/detail/<?php echo e($vl_id); ?>">I am interested <i class="fa fa-angle-right" aria-hidden="true"></i></a>

              </div>
          </div>

      </div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 </div>

</div>

  <!-- main content end-->

<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>