    <?php echo $__env->make('../header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- slider / breadcrumbs section -->
    <?php echo $__env->yieldContent('top'); ?>

    <!-- Content -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer Section Start -->
    <?php echo $__env->make('../footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>