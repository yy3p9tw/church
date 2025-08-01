<?php
include 'auth.php';
require_once '../config/upload.php';
requireLogin();

$error = '';
$success = '';

// 處理新增/編輯週報
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
    
    if (empty($title)) {
        $error = '週報標題不能為空';
    } else {
        try {
            // 處理圖片上傳
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageUpload = new ImageUpload('public/uploads/bulletins/');
                $result = $imageUpload->upload($_FILES['image']);
                if ($result) {
                    $image_url = str_replace('public/', '', $result['path']);
                } else {
                    $error = '圖片上傳失敗：' . $imageUpload->getLastError();
                }
            }
            
            // 處理 PDF 上傳
            $pdf_url = '';
            if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                $pdfUpload = new AudioUpload('public/uploads/bulletins/'); // 重用 AudioUpload 類別
                $pdfUpload->setAllowedTypes(['pdf']); // 只允許 PDF
                $result = $pdfUpload->upload($_FILES['pdf']);
                if ($result) {
                    $pdf_url = str_replace('public/', '', $result['path']);
                } else {
                    $error = 'PDF 上傳失敗：' . $pdfUpload->getLastError();
                }
            }
            
            if (!$error) {
                if ($action === 'edit' && $id) {
                    // 更新
                    $sql = "UPDATE bulletins SET title = ?, publish_date = ?";
                    $params = [$title, $publish_date];
                    
                    if ($image_url) {
                        $sql .= ", image_url = ?";
                        $params[] = $image_url;
                    }
                    
                    if ($pdf_url) {
                        $sql .= ", pdf_url = ?";
                        $params[] = $pdf_url;
                    }
                    
                    $sql .= ", updated_at = " . $db->now() . " WHERE id = ?";
                    $params[] = $id;
                    
                    $db->query($sql, $params);
                    $success = '週報已成功更新';
                } else {
                    // 新增
                    $db->query(
                        "INSERT INTO bulletins (title, image_url, pdf_url, publish_date, created_at, updated_at) VALUES (?, ?, ?, ?, " . $db->now() . ", " . $db->now() . ")",
                        [$title, $image_url, $pdf_url, $publish_date]
                    );
                    $success = '週報已成功新增';
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
        $bulletin = $db->fetchOne("SELECT image_url, pdf_url FROM bulletins WHERE id = ?", [$_GET['delete']]);
        if ($bulletin) {
            // 刪除實體檔案
            if (isset($bulletin['image_url']) && $bulletin['image_url']) {
                $filePath = 'public/' . $bulletin['image_url'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            if (isset($bulletin['pdf_url']) && $bulletin['pdf_url']) {
                $filePath = 'public/' . $bulletin['pdf_url'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        $db->query("DELETE FROM bulletins WHERE id = ?", [$_GET['delete']]);
        $success = '週報已刪除';
    } catch (Exception $e) {
        $error = '刪除失敗：' . $e->getMessage();
    }
}

// 獲取週報列表
try {
    $bulletins = $db->fetchAll("SELECT * FROM bulletins ORDER BY publish_date DESC, created_at DESC");
} catch (Exception $e) {
    $bulletins = [];
    $error = '資料讀取失敗：' . $e->getMessage();
}

// 獲取編輯的週報
$editBulletin = null;
if (isset($_GET['edit'])) {
    try {
        $editBulletin = $db->fetchOne("SELECT * FROM bulletins WHERE id = ?", [$_GET['edit']]);
    } catch (Exception $e) {
        $error = '資料讀取失敗：' . $e->getMessage();
    }
}

$title = '後台管理 - 週報管理';
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
        .bulletin-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .bulletin-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
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
                    <a class="nav-link active" href="bulletins.php">
                        <i class="fas fa-file-alt me-2"></i>
                        週報管理
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
                    <h2>週報管理</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bulletinModal">
                        <i class="fas fa-plus me-2"></i>新增週報
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
                
                <!-- 週報列表 -->
                <div class="row">
                    <?php foreach ($bulletins as $bulletin): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="bulletin-card">
                            <h5><?= htmlspecialchars($bulletin['title']) ?></h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-calendar me-1"></i><?= $bulletin['publish_date'] ?>
                            </p>
                            
                            <!-- 週報圖片 -->
                            <?php if ($bulletin['image_url']): ?>
                                <img src="../public/<?= htmlspecialchars($bulletin['image_url']) ?>" 
                                     class="bulletin-image mb-3" 
                                     alt="<?= htmlspecialchars($bulletin['title']) ?>">
                            <?php else: ?>
                                <div class="bulletin-image mb-3 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-file-alt fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- PDF 下載連結 -->
                            <?php if (isset($bulletin['pdf_url']) && $bulletin['pdf_url']): ?>
                                <div class="mb-3">
                                    <a href="../public/<?= htmlspecialchars($bulletin['pdf_url']) ?>" 
                                       target="_blank" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-file-pdf me-1"></i>下載 PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <a href="?edit=<?= $bulletin['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> 編輯
                                </a>
                                <a href="?delete=<?= $bulletin['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('確定要刪除這個週報嗎？')">
                                    <i class="fas fa-trash"></i> 刪除
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($bulletins)): ?>
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-file-alt fa-3x mb-3"></i>
                            <p>還沒有週報記錄</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 週報 Modal -->
    <div class="modal fade<?= $editBulletin ? ' show' : '' ?>" id="bulletinModal" tabindex="-1"<?= $editBulletin ? ' style="display: block;"' : '' ?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editBulletin ? '編輯週報' : '新增週報' ?></h5>
                    <a href="bulletins.php" class="btn-close"></a>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editBulletin ? 'edit' : 'add' ?>">
                    <?php if ($editBulletin): ?>
                        <input type="hidden" name="id" value="<?= $editBulletin['id'] ?>">
                    <?php endif; ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">週報標題</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $editBulletin ? htmlspecialchars($editBulletin['title']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="publish_date" class="form-label">發布日期</label>
                            <input type="date" class="form-control" id="publish_date" name="publish_date" 
                                   value="<?= $editBulletin ? $editBulletin['publish_date'] : date('Y-m-d') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">週報封面圖片</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">支援格式：JPG, PNG, GIF（最大5MB）</div>
                            <?php if ($editBulletin && $editBulletin['image_url']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前圖片：</small><br>
                                    <img src="../public/<?= $editBulletin['image_url'] ?>" 
                                         style="max-width: 200px; max-height: 150px;" 
                                         class="mt-1 rounded">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="pdf" class="form-label">週報 PDF 檔案</label>
                            <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf">
                            <div class="form-text">支援格式：PDF（最大50MB）</div>
                            <?php if ($editBulletin && isset($editBulletin['pdf_url']) && $editBulletin['pdf_url']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前 PDF：</small><br>
                                    <a href="../public/<?= $editBulletin['pdf_url'] ?>" target="_blank" class="btn btn-sm btn-outline-danger mt-1">
                                        <i class="fas fa-file-pdf me-1"></i>檢視目前 PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="bulletins.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary"><?= $editBulletin ? '更新' : '新增' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($editBulletin): ?>
    <script>
        // 如果是編輯模式，顯示modal
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('bulletinModal'));
            modal.show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
