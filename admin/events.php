<?php
include 'auth.php';
require_once '../config/upload.php';
requireLogin();

$error = '';
$success = '';

// 處理新增/編輯活動
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'published';
    
    if (empty($title) || empty($start_time) || empty($location)) {
        $error = '標題、開始時間和地點不能為空';
    } else {
        try {
            // 處理圖片上傳
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageUpload = new ImageUpload('public/uploads/events/');
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
                    $sql = "UPDATE events SET title = ?, start_time = ?, end_time = ?, location = ?, content = ?, status = ?";
                    $params = [$title, $start_time, $end_time, $location, $content, $status];
                    
                    if ($image_url) {
                        $sql .= ", image_url = ?";
                        $params[] = $image_url;
                    }
                    
                    $sql .= " WHERE id = ?";
                    $params[] = $id;
                    
                    $db->query($sql, $params);
                    $success = '活動已成功更新';
                } else {
                    // 新增
                    $db->query(
                        "INSERT INTO events (title, start_time, end_time, location, content, image_url, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
                        [$title, $start_time, $end_time, $location, $content, $image_url, $status]
                    );
                    $success = '活動已成功新增';
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
        $event = $db->fetchOne("SELECT image_url FROM events WHERE id = ?", [$_GET['delete']]);
        if ($event && $event['image_url']) {
            // 刪除實體檔案
            $filePath = 'public/' . $event['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $db->query("DELETE FROM events WHERE id = ?", [$_GET['delete']]);
        $success = '活動已刪除';
    } catch (Exception $e) {
        $error = '刪除失敗：' . $e->getMessage();
    }
}

// 獲取活動列表
try {
    $events = $db->fetchAll("SELECT * FROM events ORDER BY start_time DESC, created_at DESC");
} catch (Exception $e) {
    $events = [];
    $error = '資料讀取失敗：' . $e->getMessage();
}

// 獲取編輯的活動
$editEvent = null;
if (isset($_GET['edit'])) {
    try {
        $editEvent = $db->fetchOne("SELECT * FROM events WHERE id = ?", [$_GET['edit']]);
    } catch (Exception $e) {
        $error = '資料讀取失敗：' . $e->getMessage();
    }
}

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
                    <a class="nav-link" href="bulletins.php">
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
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($event['image_url'])): ?>
                                <img src="../public/<?= htmlspecialchars($event['image_url']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($event['title']) ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                     style="height: 200px;">
                                    <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                                
                                <!-- 活動時間 -->
                                <div class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <small class="text-muted">
                                        <?= date('Y年m月d日 H:i', strtotime($event['start_time'])) ?>
                                        <?php if (!empty($event['end_time'])): ?>
                                            - <?= date('H:i', strtotime($event['end_time'])) ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                
                                <!-- 活動地點 -->
                                <?php if (!empty($event['location'])): ?>
                                    <div class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <small class="text-muted"><?= htmlspecialchars($event['location']) ?></small>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- 活動內容摘要 -->
                                <?php if (!empty($event['content'])): ?>
                                    <p class="card-text flex-grow-1">
                                        <?= mb_substr(strip_tags($event['content']), 0, 100) ?>
                                        <?= mb_strlen(strip_tags($event['content'])) > 100 ? '...' : '' ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- 狀態 -->
                                <div class="mb-3">
                                    <?php if ($event['status'] === 'published'): ?>
                                        <span class="badge bg-success">已發布</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">草稿</span>
                                    <?php endif; ?>
                                    
                                    <!-- 檢查活動是否已過期 -->
                                    <?php 
                                    $eventTime = strtotime($event['start_time']);
                                    $now = time();
                                    ?>
                                    <?php if ($eventTime < $now): ?>
                                        <span class="badge bg-secondary ms-1">已結束</span>
                                    <?php elseif ($eventTime - $now < 86400): ?>
                                        <span class="badge bg-warning ms-1">即將開始</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-auto">
                                    <a href="?edit=<?= $event['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> 編輯
                                    </a>
                                    <a href="?delete=<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('確定要刪除這個活動嗎？')">
                                        <i class="fas fa-trash"></i> 刪除
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($events)): ?>
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                            <p>還沒有活動記錄</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 新增/編輯活動 Modal -->
    <div class="modal fade<?= $editEvent ? ' show' : '' ?>" id="eventModal" tabindex="-1"<?= $editEvent ? ' style="display: block;"' : '' ?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editEvent ? '編輯活動' : '新增活動' ?></h5>
                    <a href="events.php" class="btn-close"></a>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editEvent ? 'edit' : 'add' ?>">
                    <?php if ($editEvent): ?>
                        <input type="hidden" name="id" value="<?= $editEvent['id'] ?>">
                    <?php endif; ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">活動標題</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $editEvent ? htmlspecialchars($editEvent['title']) : '' ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">開始時間</label>
                                    <input type="datetime-local" class="form-control" id="start_time" name="start_time" 
                                           value="<?= $editEvent ? date('Y-m-d\TH:i', strtotime($editEvent['start_time'])) : '' ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">結束時間（選填）</label>
                                    <input type="datetime-local" class="form-control" id="end_time" name="end_time" 
                                           value="<?= $editEvent && $editEvent['end_time'] ? date('Y-m-d\TH:i', strtotime($editEvent['end_time'])) : '' ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">活動地點</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="<?= $editEvent ? htmlspecialchars($editEvent['location']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">活動圖片</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">支援格式：JPG, PNG, GIF（最大5MB）</div>
                            <?php if ($editEvent && $editEvent['image_url']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前圖片：</small><br>
                                    <img src="../public/<?= htmlspecialchars($editEvent['image_url']) ?>" 
                                         alt="活動圖片" class="img-thumbnail mt-1" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">活動內容</label>
                            <textarea class="form-control" id="content" name="content" rows="6"><?= $editEvent ? htmlspecialchars($editEvent['content']) : '' ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">狀態</label>
                            <select class="form-select" id="status" name="status">
                                <option value="published" <?= (!$editEvent || $editEvent['status'] === 'published') ? 'selected' : '' ?>>已發布</option>
                                <option value="draft" <?= ($editEvent && $editEvent['status'] === 'draft') ? 'selected' : '' ?>>草稿</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="events.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary"><?= $editEvent ? '更新' : '新增' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($editEvent): ?>
    <script>
        // 如果是編輯模式，顯示modal
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
