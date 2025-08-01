
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2>活動管理</h2>
    <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary mb-3">新增活動</a>
    <table class="table table-bordered">
        <thead><tr><th>標題</th><th>開始時間</th><th>結束時間</th><th>地點</th><th>操作</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($event->title); ?></td>
                <td><?php echo e($event->start_time); ?></td>
                <td><?php echo e($event->end_time); ?></td>
                <td><?php echo e($event->location); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="btn btn-sm btn-warning">編輯</a>
                    <form action="<?php echo e(route('admin.events.destroy', $event)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($events->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/events/index.blade.php ENDPATH**/ ?>