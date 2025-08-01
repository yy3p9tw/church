<?php
include 'auth.php';
requireLogin();

$error = '';
$success = '';

// 處理新增/編輯活動
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if (empty($title) || empty($date) || empty($location)) {
        $error = '標題、日期和地點不能為空';
    } else {
        // 模擬保存到資料庫
        $success = '活動已成功保存';
    }
}

// 模擬活動數據
$events = [
    [
        'id' => 1,
        'title' => '聖誕節特別聚會',
        'date' => '2024-12-25',
        'time' => '19:00',
        'location' => '主堂',
        'description' => '聖誕節特別聚會，歡迎所有弟兄姊妹參加'
    ],
    [
        'id' => 2,
        'title' => '新年禱告會',
        'date' => '2024-12-31',
        'time' => '23:00',
        'location' => '禱告室',
        'description' => '迎接新年的特別禱告會'
    ],
    [
        'id' => 3,
        'title' => '青年團契活動',
        'date' => '2024-12-20',
        'time' => '15:00',
        'location' => '青年活動室',
        'description' => '青年團契戶外活動，增進彼此情誼'
    ],
    [
        'id' => 4,
        'title' => '長者關懷聚會',
        'date' => '2024-12-18',
        'time' => '14:00',
        'location' => '交誼廳',
        'description' => '關懷長者的特別聚會'
    ],
];

$title = '後台管理 - 活動管理';
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
        .event-card {
            border-left: 4px solid #3498db;
            background: #f8f9fa;
        }
        .event-date {
            background: #3498db;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-right: 15px;
            min-width: 80px;
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
                    <a class="nav-link" href="index.php">
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
                    <a class="nav-link active" href="events.php">
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
                    <h2>活動管理</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                        <i class="fas fa-plus me-2"></i>新增活動
                    </button>
                </div>
                
                <!-- 錯誤/成功訊息 -->
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- 活動列表 -->
                <div class="row">
                    <?php foreach ($events as $event): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card event-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="event-date">
                                        <div class="fw-bold"><?= date('d', strtotime($event['date'])) ?></div>
                                        <div class="small"><?= date('M', strtotime($event['date'])) ?></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2"><?= htmlspecialchars($event['title']) ?></h5>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-clock me-1"></i><?= $event['time'] ?>
                                        </p>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($event['location']) ?>
                                        </p>
                                        <p class="card-text small"><?= htmlspecialchars($event['description']) ?></p>
                                        
                                        <div class="d-flex justify-content-between mt-3">
                                            <button class="btn btn-sm btn-outline-primary" onclick="editEvent(<?= $event['id'] ?>)">
                                                <i class="fas fa-edit"></i> 編輯
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(<?= $event['id'] ?>)">
                                                <i class="fas fa-trash"></i> 刪除
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 新增/編輯活動 Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">新增活動</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">活動標題</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">活動日期</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="time" class="form-label">活動時間</label>
                                    <input type="time" class="form-control" id="time" name="time">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">活動地點</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">活動描述</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editEvent(id) {
            alert('編輯功能待實作，ID: ' + id);
        }
        
        function deleteEvent(id) {
            if (confirm('確定要刪除這個活動嗎？')) {
                alert('刪除功能待實作，ID: ' + id);
            }
        }
    </script>
</body>
</html>
