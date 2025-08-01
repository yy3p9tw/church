<?php
include 'auth.php';
requireLogin();

$error = '';
$success = '';

// 處理設定更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'site_info':
            $site_name = trim($_POST['site_name'] ?? '');
            $site_description = trim($_POST['site_description'] ?? '');
            $contact_email = trim($_POST['contact_email'] ?? '');
            $contact_phone = trim($_POST['contact_phone'] ?? '');
            $contact_address = trim($_POST['contact_address'] ?? '');
            
            if (empty($site_name)) {
                $error = '網站名稱不能為空';
            } else {
                // 模擬保存設定
                $success = '網站資訊已更新';
            }
            break;
            
        case 'change_password':
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($current_password) || empty($new_password)) {
                $error = '請填寫所有密碼欄位';
            } elseif ($new_password !== $confirm_password) {
                $error = '新密碼與確認密碼不符';
            } elseif (strlen($new_password) < 6) {
                $error = '新密碼至少需要6個字元';
            } else {
                // 模擬密碼更新
                $success = '密碼已更新';
            }
            break;
            
        case 'backup':
            // 模擬備份
            $success = '資料備份已完成';
            break;
    }
}

$title = '後台管理 - 系統設定';
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
        .settings-nav {
            border-right: 1px solid #dee2e6;
        }
        .settings-nav .nav-link {
            color: #495057;
            padding: 10px 15px;
            border-radius: 0;
        }
        .settings-nav .nav-link.active {
            background: #e9ecef;
            color: #495057;
            font-weight: 500;
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
                    <a class="nav-link" href="bulletins.php">
                        <i class="fas fa-file-alt me-2"></i>
                        週報管理
                    </a>
                    <a class="nav-link" href="staff.php">
                        <i class="fas fa-users me-2"></i>
                        同工管理
                    </a>
                    <a class="nav-link active" href="settings.php">
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
                <div class="mb-4">
                    <h2>系統設定</h2>
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
                
                <div class="row">
                    <!-- 設定導航 -->
                    <div class="col-md-3">
                        <div class="settings-nav">
                            <nav class="nav flex-column">
                                <a class="nav-link active" href="#site-info" data-bs-toggle="tab">
                                    <i class="fas fa-info-circle me-2"></i>網站資訊
                                </a>
                                <a class="nav-link" href="#security" data-bs-toggle="tab">
                                    <i class="fas fa-shield-alt me-2"></i>安全設定
                                </a>
                                <a class="nav-link" href="#backup" data-bs-toggle="tab">
                                    <i class="fas fa-database me-2"></i>備份管理
                                </a>
                                <a class="nav-link" href="#system" data-bs-toggle="tab">
                                    <i class="fas fa-server me-2"></i>系統資訊
                                </a>
                            </nav>
                        </div>
                    </div>
                    
                    <!-- 設定內容 -->
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- 網站資訊 -->
                            <div class="tab-pane fade show active" id="site-info">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">網站基本資訊</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="site_info">
                                            <div class="mb-3">
                                                <label for="site_name" class="form-label">網站名稱</label>
                                                <input type="text" class="form-control" id="site_name" name="site_name" value="恩典教會">
                                            </div>
                                            <div class="mb-3">
                                                <label for="site_description" class="form-label">網站描述</label>
                                                <textarea class="form-control" id="site_description" name="site_description" rows="3">歡迎來到恩典教會，讓我們一起在主的愛中成長</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact_email" class="form-label">聯絡信箱</label>
                                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="info@gracechurch.com">
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact_phone" class="form-label">聯絡電話</label>
                                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="02-1234-5678">
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact_address" class="form-label">教會地址</label>
                                                <textarea class="form-control" id="contact_address" name="contact_address" rows="2">台北市中正區和平西路一段123號</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">更新設定</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 安全設定 -->
                            <div class="tab-pane fade" id="security">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">修改密碼</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="change_password">
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">目前密碼</label>
                                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">新密碼</label>
                                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                                <div class="form-text">密碼至少需要6個字元</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirm_password" class="form-label">確認新密碼</label>
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                            </div>
                                            <button type="submit" class="btn btn-warning">更新密碼</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 備份管理 -->
                            <div class="tab-pane fade" id="backup">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">資料備份</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">定期備份您的網站資料，確保資料安全。</p>
                                        <form method="POST">
                                            <input type="hidden" name="action" value="backup">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-download me-2"></i>立即備份
                                            </button>
                                        </form>
                                        
                                        <hr>
                                        
                                        <h6>備份記錄</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>備份時間</th>
                                                        <th>檔案大小</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2024-12-15 10:30:00</td>
                                                        <td>2.5 MB</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary">下載</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2024-12-10 09:15:00</td>
                                                        <td>2.3 MB</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary">下載</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 系統資訊 -->
                            <div class="tab-pane fade" id="system">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">系統資訊</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>PHP 版本</strong></td>
                                                        <td><?= PHP_VERSION ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>作業系統</strong></td>
                                                        <td><?= PHP_OS ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>伺服器軟體</strong></td>
                                                        <td><?= $_SERVER['SERVER_SOFTWARE'] ?? '未知' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>記憶體限制</strong></td>
                                                        <td><?= ini_get('memory_limit') ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>最大上傳大小</strong></td>
                                                        <td><?= ini_get('upload_max_filesize') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>執行時間限制</strong></td>
                                                        <td><?= ini_get('max_execution_time') ?>秒</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>系統時間</strong></td>
                                                        <td><?= date('Y-m-d H:i:s') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>磁碟可用空間</strong></td>
                                                        <td><?= round(disk_free_space('.') / 1024 / 1024 / 1024, 2) ?> GB</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
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
