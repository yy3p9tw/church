<?php
include 'auth.php';
require_once '../config/upload.php';
requireLogin();

$error = '';
$success = '';

// 處理新增/編輯
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $news_date = $_POST['news_date'] ?? date('Y-m-d');
    
    if (empty($title) || empty($content)) {
        $error = '標題和內容不能為空';
    } else {
        try {
            // 處理圖片上傳
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageUpload = new ImageUpload('public/uploads/news/');
                $result = $imageUpload->upload($_FILES['image']);
                if ($result) {
                    $image_url = str_replace('public/', '', $result['path']);
                } else {
                    $error = '圖片上傳失敗：' . $imageUpload->getLastError();
                }
            }
            
            if (!$error) {
                if ($action === 'edit' && $id) {
                    // 更新
                    $sql = "UPDATE news SET title = ?, content = ?, news_date = ?";
                    $params = [$title, $content, $news_date];
                    
                    if ($image_url) {
                        $sql .= ", image_url = ?";
                        $params[] = $image_url;
                    }
                    
                    $sql .= " WHERE id = ?";
                    $params[] = $id;
                    
                    $db->query($sql, $params);
                    $success = '消息已成功更新';
                } else {
                    // 新增
                    $db->query(
                        "INSERT INTO news (title, content, news_date, image_url, status) VALUES (?, ?, ?, ?, 'published')",
                        [$title, $content, $news_date, $image_url]
                    );
                    $success = '消息已成功新增';
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
        $db->query("DELETE FROM news WHERE id = ?", [$_GET['delete']]);
        $success = '消息已刪除';
    } catch (Exception $e) {
        $error = '刪除失敗：' . $e->getMessage();
    }
}

// 獲取新聞列表
try {
    $news = $db->fetchAll("SELECT * FROM news ORDER BY news_date DESC, created_at DESC");
} catch (Exception $e) {
    $news = [];
    $error = '資料讀取失敗：' . $e->getMessage();
}

// 獲取編輯的新聞
$editNews = null;
if (isset($_GET['edit'])) {
    try {
        $editNews = $db->fetchOne("SELECT * FROM news WHERE id = ?", [$_GET['edit']]);
    } catch (Exception $e) {
        $error = '資料讀取失敗：' . $e->getMessage();
    }
}

$title = '後台管理 - 最新消息';
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
                    <a class="nav-link active" href="news.php">
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
                    <h2>最新消息管理</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newsModal">
                        <i class="fas fa-plus me-2"></i>新增消息
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
                
                <!-- 消息列表 -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">消息列表</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>標題</th>
                                        <th>發布日期</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($news as $item): ?>
                                    <tr>
                                        <td><?= $item['id'] ?></td>
                                        <td>
                                            <?= htmlspecialchars($item['title']) ?>
                                            <?php if ($item['image_url']): ?>
                                                <i class="fas fa-image text-primary ms-1" title="有圖片"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $item['news_date'] ?: $item['created_at'] ?></td>
                                        <td>
                                            <a href="?edit=<?= $item['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?delete=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('確定要刪除這則消息嗎？')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 新增/編輯消息 Modal -->
    <div class="modal fade<?= $editNews ? ' show' : '' ?>" id="newsModal" tabindex="-1"<?= $editNews ? ' style="display: block;"' : '' ?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editNews ? '編輯消息' : '新增消息' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editNews ? 'edit' : 'add' ?>">
                    <?php if ($editNews): ?>
                        <input type="hidden" name="id" value="<?= $editNews['id'] ?>">
                    <?php endif; ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">標題</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $editNews ? htmlspecialchars($editNews['title']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="news_date" class="form-label">發布日期</label>
                            <input type="date" class="form-control" id="news_date" name="news_date" 
                                   value="<?= $editNews ? $editNews['news_date'] : date('Y-m-d') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">圖片</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">支援格式：JPG, PNG, GIF, WebP（最大5MB）</div>
                            <?php if ($editNews && $editNews['image_url']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前圖片：</small><br>
                                    <img src="../public/<?= $editNews['image_url'] ?>" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">內容</label>
                            <textarea class="form-control" id="content" name="content" rows="6" required><?= $editNews ? htmlspecialchars($editNews['content']) : '' ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="news.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary"><?= $editNews ? '更新' : '新增' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($editNews): ?>
    <script>
        // 如果是編輯模式，顯示modal
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('newsModal'));
            modal.show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
