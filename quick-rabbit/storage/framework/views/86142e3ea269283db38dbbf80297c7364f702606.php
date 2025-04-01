
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('errors.menu_others', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_menu'); ?>
    <?php echo $__env->make('errors.others_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<!-- Not Wrapper -->
<div class="not-wrapper">    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <img src="<?php echo e(asset('assets/frontend/img/core-img/404.png')); ?>" alt="">
                <div class="text-center">
                    <h2><?php echo app('translator')->get('index.look_like_lost'); ?></h2>
                    <p><?php echo app('translator')->get('index.page_not_available'); ?></p>
                    <div class="d-flex justify-content-center">
                        <a class="gt-btn w-lg-25" href="<?php echo e(URL::previous()); ?>">
                            <?php echo app('translator')->get('index.go_to_back'); ?> <i class="bi bi-arrow-return-left ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u209993987/domains/opnium.com/public_html/rabbit/resources/views/errors/404.blade.php ENDPATH**/ ?>