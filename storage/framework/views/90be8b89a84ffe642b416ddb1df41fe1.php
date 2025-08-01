
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>週報管理</h2>
    <a href="<?php echo e(route('admin.bulletins.create')); ?>" class="btn btn-primary mb-3">新增週報</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>日期</th><th>圖片</th><th>操作</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $bulletins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->title); ?></td>
                <td><?php echo e($item->publish_date); ?></td>
                <td><img src="<?php echo e($item->image_url); ?>" alt="週報圖片" style="max-width:120px;"></td>
                <td>
                    <a href="<?php echo e(route('admin.bulletins.edit', $item)); ?>" class="btn btn-sm btn-warning">編輯</a>
                    <form action="<?php echo e(route('admin.bulletins.destroy', $item)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($bulletins->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/bulletins/index.blade.php ENDPATH**/ ?>