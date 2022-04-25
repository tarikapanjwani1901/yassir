<title>Blog</title>


<?php $__env->startSection('content'); ?>
    <!-- Container Section Strat -->
    <div class="blg-cover">
    <div class="container">
        <div class="commonttl-subttl p-t-150">
                <h2>Blog</h2>
            </div>
        <div class="row">
            <div class="content">
                <div class="bloglisting">
                    <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <!-- BEGIN FEATURED POST -->
                    <div class="blog-box thumbnail">
                        <?php if($blog->image): ?>
                        <figure>
                        <img src="<?php echo e(URL::to('public/uploads/blog/'.$blog->image)); ?>" class="img-responsive" alt="Image"></figure>
                        <?php endif; ?>
                        <div class="featured-text relative-left">
                            <h3 class="primary"><a href="<?php echo e(URL::to('blogitem/'.$blog->slug)); ?>"><?php echo e($blog->title); ?></a></h3>
                            <p>
                               <?php echo App\Http\Controllers\ListingController::getExcerpt($blog->content); ?>

                            </p>
                            <div class="tags">
                                <strong>Tags: </strong>
                                <?php $__empty_2 = true; $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <a href="<?php echo e(URL::to('blog/'.mb_strtolower($tag).'/tag')); ?>"><?php echo e($tag); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    No Tags
                                <?php endif; ?>
                            </div>
                            <p class="additional-post-wrap">
                                <span class="additional-post">
                                    <i class="livicon" data-name="user" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i> by&nbsp;<a href="#"><?php echo e($blog->author->first_name . ' ' . $blog->author->last_name); ?></a>
                                </span>
                                <span class="additional-post">
                                    <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> <?php echo e($blog->created_at->diffForHumans()); ?></a>
                                </span>
                                <span class="additional-post">
                                    <i class="livicon" data-name="comment" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> <?php echo e($blog->comments->count()); ?> comments</a>
                                </span>
                            </p>

                            <p class="text-right">
                                <a href="<?php echo e(URL::to('blogitem/'.$blog->slug)); ?>" class="btn commonbtn">Read more</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                    <!-- /.featured-post-wide -->
                    <!-- END FEATURED POST -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <h3 class="text-center">No Posts Exists!</h3>
                    <?php endif; ?>
                    <ul class="pager">
                        <?php echo $blogs->render(); ?>

                    </ul>
                </div>
                <!-- /.col-md-8 -->
                <!-- /.col-md-4 -->
            </div>
        </div>
    </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>