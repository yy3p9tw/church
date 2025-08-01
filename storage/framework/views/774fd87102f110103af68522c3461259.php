<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', '教會網站'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
    /* 下拉選單 hover 自動展開 */
    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
    .dropdown-menu {
        margin-top: 0;
        min-width: auto;
        width: max-content;
        left: 0;
        right: auto;
        padding: 0.25rem 0;
    }
    .dropdown .dropdown-menu {
        min-width: unset;
        width: max-content;
    }
    .dropdown > a[role="button"] {
        width: 100%;
        display: inline-block;
    }
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
    <header class="main-navbar border-bottom mb-4">
        <div class="container py-3 d-flex justify-content-between align-items-center">
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand fw-bold">教會 LOGO</a>
            <nav class="d-flex align-items-center">
                <div class="dropdown mx-2">
                    <span role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right:0;cursor:pointer;">
                        關於我們
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('mission')); ?>">我們的使命</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('belief')); ?>">信仰宣告</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('staff')); ?>">我們的同工</a></li>
                    </ul>
                </div>
                <div class="dropdown mx-2">
                    <span role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right:0;cursor:pointer;">
                        我們的事工
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(url('/sermons')); ?>">講道</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('/events')); ?>">活動</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('/groups')); ?>">小組</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('/bulletins')); ?>">週報</a></li>
                    </ul>
                </div>
                <div class="dropdown mx-2">
                    <span role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right:0;cursor:pointer;">
                        我們的訊息
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(url('/news')); ?>">消息</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('/bulletins')); ?>">週報</a></li>
                    </ul>
                </div>
                <div class="dropdown mx-2">
                    <span role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right:0;cursor:pointer;">
                        聯絡
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(url('/contact')); ?>">聯絡表單</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(url('/map')); ?>">地圖位置</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mb-5">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="footer-dark text-white py-4 mt-auto">
        <div class="container text-center">
            &copy; 2025 教會網站 | <a href="<?php echo e(url('/')); ?>" class="text-white">首頁</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\church\src\resources\views/layouts/front.blade.php ENDPATH**/ ?>