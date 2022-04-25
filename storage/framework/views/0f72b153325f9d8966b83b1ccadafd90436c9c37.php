<title>About Us</title>
<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body class="stickynav home">
<div id="main" class="inner-content aboutpage">
  	   <div class="inner-banner-row" style="background-image:url(public/assets/images/inner-banner1.png);">
	<?php $__currentLoopData = $cms_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="bannertext">
               <h1><?php echo e($cms->title); ?></h1>
    </div>
	</div>
	<div class="container padd100">		
		<?php echo $cms->description; ?>		
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>