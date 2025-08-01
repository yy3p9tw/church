<?php
include 'auth.php';
requireLogin();

$error = '';
$success = '';

// 處理檔案上傳和新增同工
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    if (empty($name) || empty($position)) {
        $error = '姓名和職位不能為空';
    } else {
        // 處理頭像上傳
        $photoPath = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../public/storage/staff/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                $photoPath = $fileName;
            }
        }
        
        // 模擬保存到資料庫
        $success = '同工資料已成功保存';
    }
}

// 模擬同工數據
$staff = [
    [
        'id' => 1,
        'name' => '王恩典',
        'position' => '主任牧師',
        'email' => 'pastor.wang@church.com',
        'phone' => '02-1234-5678',
        'photo' => '4ho7qyTWvJxTEZ3ieJJ0xPKDCerb8DoO7iyTzoCr.jpg',
        'bio' => '擁有神學碩士學位，在教會服事超過15年，致力於福音傳播和信徒造就。'
    ],
    [
        'id' => 2,
        'name' => '李喜樂',
        'position' => '副牧師',
        'email' => 'pastor.lee@church.com',
        'phone' => '02-2345-6789',
        'photo' => 'eEjY7LkDDHTe09CrljkSWcRZUIOEnMr2Wcow744r.jpg',
        'bio' => '負責青年事工和小組牧養，熱心於青年事工的發展。'
    ],
    [
        'id' => 3,
        'name' => '張平安',
        'position' => '長老',
        'email' => 'elder.zhang@church.com',
        'phone' => '02-3456-7890',
        'photo' => 'uFeHYUIuFnQZdoGvrFrvlnXmEpnGwHIDbeHoWlsG.jpg',
        'bio' => '教會創始成員之一，負責教會行政和財務管理工作。'
    ],
];

$title = '後台管理 - 同工管理';
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
        .staff-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }
        .staff-card {
            transition: transform 0.2s;
        }
        .staff-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
                    <a class="nav-link" href="events.php">
                        <i class="fas fa-calendar me-2"></i>
                        活動管理
                    </a>
                    <a class="nav-link active" href="staff.php">
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
                    <h2>同工管理</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staffModal">
                        <i class="fas fa-plus me-2"></i>新增同工
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
                
                <!-- 同工列表 -->
                <div class="row">
                    <?php foreach ($staff as $member): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card staff-card h-100">
                            <div class="card-body text-center">
                                <img src="../public/storage/staff/<?= $member['photo'] ?>" 
                                     alt="<?= htmlspecialchars($member['name']) ?>" 
                                     class="staff-photo mb-3">
                                <h5 class="card-title"><?= htmlspecialchars($member['name']) ?></h5>
                                <p class="text-primary fw-bold"><?= htmlspecialchars($member['position']) ?></p>
                                
                                <div class="text-start small text-muted mb-3">
                                    <?php if ($member['email']): ?>
                                    <div class="mb-1">
                                        <i class="fas fa-envelope me-2"></i><?= htmlspecialchars($member['email']) ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($member['phone']): ?>
                                    <div class="mb-2">
                                        <i class="fas fa-phone me-2"></i><?= htmlspecialchars($member['phone']) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="card-text small text-muted"><?= htmlspecialchars($member['bio']) ?></p>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editStaff(<?= $member['id'] ?>)">
                                        <i class="fas fa-edit"></i> 編輯
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteStaff(<?= $member['id'] ?>)">
                                        <i class="fas fa-trash"></i> 刪除
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 新增/編輯同工 Modal -->
    <div class="modal fade" id="staffModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">新增同工</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">姓名</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">職位</label>
                                    <input type="text" class="form-control" id="position" name="position" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">電子郵件</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">電話</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">頭像照片</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div class="form-text">建議尺寸：300x300px，支援格式：JPG, PNG</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">個人簡介</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"></textarea>
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
        function editStaff(id) {
            alert('編輯功能待實作，ID: ' + id);
        }
        
        function deleteStaff(id) {
            if (confirm('確定要刪除這位同工嗎？')) {
                alert('刪除功能待實作，ID: ' + id);
            }
        }
    </script>
</body>
</html>
