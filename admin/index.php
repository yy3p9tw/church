<?php
include 'auth.php';
requireLogin();

if (isset($_GET['logout'])) {
    logout();
}

$title = '後台管理 - 儀表板';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }
        .sidebar .nav-link:hover {
            background: #34495e;
            color: white;
        }
        .sidebar .nav-link.active {
            background: #3498db;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="row g-0">
        <!-- 側邊欄 -->
        <div class="col-md-3 col-lg-2">
            <div class="sidebar">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-church me-2"></i>
                        教會後台
                    </h5>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        儀表板
                    </a>
                    <a class="nav-link" href="news.php">
                        <i class="fas fa-newspaper me-2"></i>
                        最新消息
                    </a>
                    <a class="nav-link" href="sermons.php">
                        <i class="fas fa-microphone me-2"></i>
                        講道管理
                    </a>
                    <a class="nav-link" href="events.php">
                        <i class="fas fa-calendar me-2"></i>
                        活動管理
                    </a>
                    <a class="nav-link" href="staff.php">
                        <i class="fas fa-users me-2"></i>
                        同工管理
                    </a>
                    <a class="nav-link" href="settings.php">
                        <i class="fas fa-cog me-2"></i>
                        系統設定
                    </a>
                    <hr class="border-secondary">
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        查看前台
                    </a>
                    <a class="nav-link" href="?logout=1">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        登出
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- 主要內容 -->
        <div class="col-md-9 col-lg-10">
            <div class="main-content">
                <!-- 頁首 -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>儀表板</h2>
                    <div class="text-muted">
                        歡迎，<?= $_SESSION['admin_user'] ?>
                    </div>
                </div>
                
                <!-- 統計卡片 -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-newspaper fa-2x mb-2"></i>
                                <h4>12</h4>
                                <p class="mb-0">最新消息</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-microphone fa-2x mb-2"></i>
                                <h4>28</h4>
                                <p class="mb-0">講道篇數</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar fa-2x mb-2"></i>
                                <h4>5</h4>
                                <p class="mb-0">近期活動</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <h4>8</h4>
                                <p class="mb-0">同工人員</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 快速功能 -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">快速操作</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="news.php?action=add" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>新增消息
                                    </a>
                                    <a href="sermons.php?action=add" class="btn btn-success">
                                        <i class="fas fa-plus me-2"></i>新增講道
                                    </a>
                                    <a href="events.php?action=add" class="btn btn-info">
                                        <i class="fas fa-plus me-2"></i>新增活動
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">系統狀態</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>PHP 版本</span>
                                        <span class="badge bg-success"><?= PHP_VERSION ?></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>系統時間</span>
                                        <span class="text-muted"><?= date('Y-m-d H:i:s') ?></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>網站狀態</span>
                                        <span class="badge bg-success">運行正常</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
