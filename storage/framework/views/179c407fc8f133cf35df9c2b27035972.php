
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>同工管理</h2>
    <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary mb-3">新增同工</a>
    <table class="table table-bordered">
        <thead><tr><th>姓名</th><th>職稱</th><th>照片</th><th>狀態</th><th>排序</th><th>操作</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->name); ?></td>
                <td><?php echo e($item->title); ?></td>
                <td><?php if($item->photo): ?><img src="<?php echo e(asset('storage/'.$item->photo)); ?>" width="60"><?php endif; ?></td>
                <td><?php echo e($item->status ? '啟用' : '停用'); ?></td>
                <td><?php echo e($item->sort_order); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.staff.edit', $item)); ?>" class="btn btn-sm btn-warning">編輯</a>
                    <form action="<?php echo e(route('admin.staff.destroy', $item)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($staff->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/staff/index.blade.php ENDPATH**/ ?>