
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>輪播管理</h2>
    <a href="<?php echo e(route('admin.sliders.create')); ?>" class="btn btn-primary mb-3">新增輪播</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>圖片</th><th>連結</th><th>排序</th><th>操作</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->title); ?></td>
                <td><img src="<?php echo e($item->image_url); ?>" alt="輪播圖片" style="max-width:120px;"></td>
                <td><?php echo e($item->link_url); ?></td>
                <td><?php echo e($item->sort_order); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.sliders.edit', $item)); ?>" class="btn btn-sm btn-warning">編輯</a>
                    <form action="<?php echo e(route('admin.sliders.destroy', $item)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/sliders/index.blade.php ENDPATH**/ ?>