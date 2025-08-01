
<?php
    use Illuminate\Support\Str;
?>


<?php $__env->startSection('title', '教會首頁'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- 輪播區塊（後台管理） -->
    <?php if($sliders->count()): ?>
    <div id="welcomeCarousel" class="carousel slide mb-5 slider-fullscreen" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-item <?php if($i === 0): ?> active <?php endif; ?>">
                    <?php if($slider->link_url): ?>
                        <a href="<?php echo e($slider->link_url); ?>" target="_blank"><img src="<?php echo e($slider->image_url); ?>" class="d-block slider-img" alt="<?php echo e($slider->title); ?>"></a>
                    <?php else: ?>
                        <img src="<?php echo e($slider->image_url); ?>" class="d-block slider-img" alt="<?php echo e($slider->title); ?>">
                    <?php endif; ?>
                    <?php if($slider->title): ?>
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                            <h2 class="fw-bold"><?php echo e($slider->title); ?></h2>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    <?php endif; ?>

    <!-- 主日時間地點地圖 -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
            <h3 class="fw-bold">主日聚會</h3>
            <p class="mb-1">每週日 10:00</p>
            <p class="mb-1">台北市信義區松仁路100號</p>
        </div>
        <div class="col-md-6">
            <iframe src="https://www.google.com/maps?q=台北市信義區松仁路100號&output=embed" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <!-- 我們的事工 -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">我們的事工</h3>
        <div class="row g-4">
            <?php $__currentLoopData = $groups->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($group->name); ?></h5>
                            <p class="card-text"><?php echo e($group->description); ?></p>
                            <a href="<?php echo e(url('/groups/'.$group->id)); ?>" class="btn btn-outline-primary">了解更多</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $events->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($event->title); ?></h5>
                            <p class="card-text"><?php echo e($event->start_time); ?><br><?php echo e($event->location); ?></p>
                            <a href="<?php echo e(url('/events/'.$event->id)); ?>" class="btn btn-outline-primary">活動詳情</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- 主日訊息講道（最新3筆） -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">主日訊息講道</h3>
        <div class="row g-4">
            <?php $__currentLoopData = $sermons->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sermon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($sermon->title); ?></h5>
                            <p class="card-text">講員：<?php echo e($sermon->speaker); ?><br>日期：<?php echo e($sermon->sermon_date); ?></p>
                            <a href="<?php echo e(url('/sermons/'.$sermon->id)); ?>" class="btn btn-outline-primary">觀看內容</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- 最新消息 -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">最新消息</h3>
        <ul class="list-group">
            <?php $__currentLoopData = $news->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo e($item->title); ?></span>
                    <a href="<?php echo e(url('/news/'.$item->id)); ?>" class="btn btn-sm btn-outline-secondary">查看</a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/front/home.blade.php ENDPATH**/ ?>