<ul class="navbar-nav navbar-nav-scroll me-auto mb-3 mb-lg-0 menu-others" id="supportyNav">
    <li>
        <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?> <?php echo e(empty(urlPrefix()) ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('index.home'); ?></a>
    </li>
    <li>
        <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?>" href="<?php echo e(route('home')); ?>#knowledge-article"><?php echo app('translator')->get('index.articles'); ?></a>
    </li>
    <li>
        <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?>" href="<?php echo e(route('home')); ?>#faq"><?php echo app('translator')->get('index.faq'); ?></a>
    </li>
    <li>
        <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?>" href="<?php echo e(route('blogs')); ?>"><?php echo app('translator')->get('index.blog'); ?></a>
    </li>
    <li class="dropdown-list">
        <a href="javascript:void(0)" class="<?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?>"><?php echo app('translator')->get('index.page'); ?></a>
        <ul class="dropdown-body">
            <li>
                <a href="<?php echo e(route('about-us')); ?>">
                    <?php echo app('translator')->get('index.about_us'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('our-services')); ?>">
                    <?php echo app('translator')->get('index.our_services'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('support-policy')); ?>">
                    <?php echo app('translator')->get('index.support_policy'); ?>
                </a>
            </li>
            <?php $__currentLoopData = getAllPages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('page-details',$page->slug)); ?>">
                    <?php echo e($page->title ?? ""); ?>

                </a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </li>
        <li>
            <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?> <?php echo e(urlPrefix() == "forum" ? 'active' : ''); ?>" href="<?php echo e(route('forum')); ?>"><?php echo app('translator')->get('index.forum'); ?>
            </a>
        </li>
        <li>
            <a class="set_active <?php echo e(request()->url() == route('home') ? '' : 'color-menu'); ?> <?php echo e(urlPrefix() == "contact" ? 'active' : ''); ?>" href="<?php echo e(route("contact")); ?>">
            <?php echo app('translator')->get('index.contact'); ?>
            </a>
    </li>
</ul><?php /**PATH /home/u209993987/domains/opnium.com/public_html/rabbit/resources/views/frontend/menu_others.blade.php ENDPATH**/ ?>