<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', '後台管理'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(url('/admin')); ?>">後台管理</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin')); ?>">儀表板</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/sliders')); ?>">輪播管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/sermons')); ?>">講道管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/groups')); ?>">小組管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/news')); ?>">消息管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/events')); ?>">活動管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/bulletins')); ?>">週報管理</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/staff')); ?>">同工管理</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="text-center py-4 text-muted">
        &copy; <?php echo e(date('Y')); ?> 教會網站後台
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\church\src\resources\views/layouts/admin.blade.php ENDPATH**/ ?>