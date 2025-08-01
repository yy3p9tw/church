<?php
include 'auth.php';
require_once '../config/upload.php';
requireLogin();

$error = '';
$success = '';

// 處理新增/編輯同工
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    $id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? ''); // 使用 title 而不是 position
    $bio = trim($_POST['bio'] ?? '');
    
    if (empty($name) || empty($title)) {
        $error = '姓名和職位不能為空';
    } else {
        try {
            // 處理照片上傳
            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $imageUpload = new ImageUpload('public/uploads/staff/');
                $result = $imageUpload->upload($_FILES['photo']);
                if ($result) {
                    $photo = str_replace('public/', '', $result['path']);
                } else {
                    $error = '照片上傳失敗：' . $imageUpload->getLastError();
                }
            }
            
            if (!$error) {
                if ($action === 'edit' && $id) {
                    // 更新
                    $sql = "UPDATE staff SET name = ?, title = ?, bio = ?";
                    $params = [$name, $title, $bio];
                    
                    if ($photo) {
                        $sql .= ", photo = ?";
                        $params[] = $photo;
                    }
                    
                    $sql .= " WHERE id = ?";
                    $params[] = $id;
                    
                    $db->query($sql, $params);
                    $success = '同工資料已成功更新';
                } else {
                    // 新增
                    $db->query(
                        "INSERT INTO staff (name, title, photo, bio, status, sort_order) VALUES (?, ?, ?, ?, 1, 0)",
                        [$name, $title, $photo, $bio]
                    );
                    $success = '同工資料已成功新增';
                }
            }
        } catch (Exception $e) {
            $error = '資料庫錯誤：' . $e->getMessage();
        }
    }
}

// 處理刪除
if (isset($_GET['delete'])) {
    try {
        $db->query("DELETE FROM staff WHERE id = ?", [$_GET['delete']]);
        $success = '同工資料已刪除';
    } catch (Exception $e) {
        $error = '刪除失敗：' . $e->getMessage();
    }
}

// 獲取同工列表
try {
    $staff = $db->fetchAll("SELECT * FROM staff WHERE status = 1 ORDER BY sort_order, id");
} catch (Exception $e) {
    $staff = [];
    $error = '資料讀取失敗：' . $e->getMessage();
}

// 獲取編輯的同工
$editStaff = null;
if (isset($_GET['edit'])) {
    try {
        $editStaff = $db->fetchOne("SELECT * FROM staff WHERE id = ?", [$_GET['edit']]);
    } catch (Exception $e) {
        $error = '資料讀取失敗：' . $e->getMessage();
    }
}

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
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #f8f9fa;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
                    <a class="nav-link" href="bulletins.php">
                        <i class="fas fa-file-alt me-2"></i>
                        週報管理
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
                <?php if (!empty($staff)): ?>
                    <div class="row">
                        <?php foreach ($staff as $member): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card staff-card h-100">
                                <div class="card-body text-center">
                                    <?php if ($member['photo']): ?>
                                        <img src="../public/<?= $member['photo'] ?>" 
                                             alt="<?= htmlspecialchars($member['name']) ?>" 
                                             class="staff-photo mb-3">
                                    <?php else: ?>
                                        <div class="staff-photo mb-3 d-flex align-items-center justify-content-center bg-light mx-auto">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h5 class="card-title"><?= htmlspecialchars($member['name']) ?></h5>
                                    <p class="text-primary fw-bold"><?= htmlspecialchars($member['title']) ?></p>
                                    
                                    <?php if ($member['bio']): ?>
                                        <p class="card-text small text-muted"><?= htmlspecialchars($member['bio']) ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="?edit=<?= $member['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> 編輯
                                        </a>
                                        <a href="?delete=<?= $member['id'] ?>" class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('確定要刪除這位同工嗎？')">
                                            <i class="fas fa-trash"></i> 刪除
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="text-muted mb-4">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h4>目前沒有同工資料</h4>
                        <p class="text-muted">請點擊上方的「新增同工」按鈕來新增第一位同工。</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- 新增/編輯同工 Modal -->
    <div class="modal fade<?= $editStaff ? ' show' : '' ?>" id="staffModal" tabindex="-1"<?= $editStaff ? ' style="display: block;"' : '' ?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editStaff ? '編輯同工' : '新增同工' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editStaff ? 'edit' : 'add' ?>">
                    <?php if ($editStaff): ?>
                        <input type="hidden" name="id" value="<?= $editStaff['id'] ?>">
                    <?php endif; ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">姓名</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= $editStaff ? htmlspecialchars($editStaff['name']) : '' ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">職位</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= $editStaff ? htmlspecialchars($editStaff['title']) : '' ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">頭像照片</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div class="form-text">建議尺寸：300x300px，支援格式：JPG, PNG, GIF, WebP（最大5MB）</div>
                            <?php if ($editStaff && $editStaff['photo']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前照片：</small><br>
                                    <img src="../public/<?= $editStaff['photo'] ?>" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">個人簡介</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"><?= $editStaff ? htmlspecialchars($editStaff['bio']) : '' ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="staff.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary"><?= $editStaff ? '更新' : '新增' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($editStaff): ?>
    <script>
        // 如果是編輯模式，顯示modal
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('staffModal'));
            modal.show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
