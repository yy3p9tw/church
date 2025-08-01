
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>小組管理</h2>
    <a href="<?php echo e(route('admin.groups.create')); ?>" class="btn btn-primary mb-3">新增小組</a>
    <table class="table table-bordered">
        <thead><tr><th>名稱</th><th>類型</th><th>聯絡人</th><th>操作</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($group->name); ?></td>
                <td><?php echo e($group->type); ?></td>
                <td><?php echo e($group->contact_person); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.groups.edit', $group)); ?>" class="btn btn-sm btn-warning">編輯</a>
                    <form action="<?php echo e(route('admin.groups.destroy', $group)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($groups->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/groups/index.blade.php ENDPATH**/ ?>