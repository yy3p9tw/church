

<?php $__env->startSection('title', '後台儀表板'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h1 class="mb-4 fw-bold text-center" style="letter-spacing:0.08em;">後台儀表板</h1>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center fs-5 fw-bold" style="letter-spacing:0.06em;">後台管理功能</div>
                    <div class="card-body d-flex flex-wrap justify-content-center gap-4 py-4">
                        <a href="<?php echo e(route('admin.staff.index')); ?>" class="dashboard-btn">
                            <div class="icon">👥</div>
                            <div>同工管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.sliders.index')); ?>" class="dashboard-btn">
                            <div class="icon">🖼️</div>
                            <div>輪播管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.sermons.index')); ?>" class="dashboard-btn">
                            <div class="icon">🎤</div>
                            <div>講道管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.groups.index')); ?>" class="dashboard-btn">
                            <div class="icon">👨‍👩‍👧‍👦</div>
                            <div>小組管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.news.index')); ?>" class="dashboard-btn">
                            <div class="icon">📰</div>
                            <div>消息管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.events.index')); ?>" class="dashboard-btn">
                            <div class="icon">📅</div>
                            <div>活動管理</div>
                        </a>
                        <a href="<?php echo e(route('admin.bulletins.index')); ?>" class="dashboard-btn">
                            <div class="icon">📄</div>
                            <div>週報管理</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .dashboard-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 132px;
            height: 132px;
            background: linear-gradient(135deg, #f8fafc 60%, #e6c98a22 100%);
            border-radius: 1.2rem;
            border: none;
            box-shadow: 0 4px 24px 0 rgba(58,77,57,0.10), 0 1.5px 0 0 #e6c98a33 inset;
            font-size: 1.13rem;
            font-weight: 600;
            color: #263528;
            text-decoration: none;
            transition: transform 0.18s cubic-bezier(.4,0,.2,1), box-shadow 0.18s, background 0.18s, color 0.18s;
            position: relative;
            overflow: hidden;
        }
        .dashboard-btn:before {
            content: '';
            position: absolute;
            left: 0; top: 0; right: 0; bottom: 0;
            background: linear-gradient(120deg, #e6c98a33 0%, #fffbe6 100%);
            opacity: 0;
            transition: opacity 0.18s;
            z-index: 0;
        }
        .dashboard-btn:hover, .dashboard-btn:focus {
            background: linear-gradient(135deg, #fffbe6 60%, #e6c98a55 100%);
            color: #bfa14a;
            box-shadow: 0 8px 32px 0 rgba(191,161,74,0.18), 0 1.5px 0 0 #e6c98a55 inset;
            transform: translateY(-4px) scale(1.045);
        }
        .dashboard-btn:hover:before, .dashboard-btn:focus:before {
            opacity: 0.18;
        }
        .dashboard-btn .icon {
            font-size: 2.7em;
            margin-bottom: 0.38em;
            filter: drop-shadow(0 2px 8px #e6c98a22);
        }
        .dashboard-btn:active {
            transform: scale(0.97);
            box-shadow: 0 2px 8px 0 rgba(191,161,74,0.10);
        }
        @media (max-width: 600px) {
            .dashboard-btn {
                width: 100px;
                height: 100px;
                font-size: 0.98rem;
            }
            .dashboard-btn .icon {
                font-size: 1.7em;
            }
        }
        </style>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\church\src\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>