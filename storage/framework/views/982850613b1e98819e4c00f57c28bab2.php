
<?php $__env->startSection('title', '週報'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4">週報</h2>
    <div class="row g-4">
        <?php $__currentLoopData = $bulletins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <a href="<?php echo e(route('front.bulletins.show', $item->id)); ?>">
                        <img src="<?php echo e($item->image_url); ?>" class="card-img-top" alt="週報圖片" style="transition:0.2s;cursor:zoom-in;">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php echo e(route('front.bulletins.show', $item->id)); ?>" class="text-decoration-none"><?php echo e($item->title); ?></a>
                        </h5>
                        <p class="card-text text-muted"><?php echo e($item->publish_date); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4"><?php echo e($bulletins->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/front/bulletins/index.blade.php ENDPATH**/ ?>