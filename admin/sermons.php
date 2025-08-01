<?php
include 'auth.php';
require_once '../config/upload.php';
requireLogin();

$error = '';
$success = '';

// 處理檔案上傳和新增/編輯講道
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $speaker = trim($_POST['speaker'] ?? '');
    $sermon_date = $_POST['sermon_date'] ?? date('Y-m-d');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title) || empty($speaker)) {
        $error = '標題和講員不能為空';
    } else {
        try {
            // 處理音頻檔案上傳
            $audio_url = '';
            if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
                $audioUpload = new AudioUpload('public/uploads/sermons/');
                $result = $audioUpload->upload($_FILES['audio']);
                if ($result) {
                    $audio_url = str_replace('public/', '', $result['path']);
                } else {
                    $error = '音頻檔案上傳失敗：' . $audioUpload->getLastError();
                }
            }
            
            if (!$error) {
                if ($action === 'edit' && $id) {
                    // 更新
                    $sql = "UPDATE sermons SET title = ?, speaker = ?, sermon_date = ?, content = ?";
                    $params = [$title, $speaker, $sermon_date, $content];
                    
                    if ($audio_url) {
                        $sql .= ", audio_url = ?";
                        $params[] = $audio_url;
                    }
                    
                    $sql .= " WHERE id = ?";
                    $params[] = $id;
                    
                    $db->query($sql, $params);
                    $success = '講道已成功更新';
                } else {
                    // 新增
                    $db->query(
                        "INSERT INTO sermons (title, speaker, sermon_date, audio_url, content, status) VALUES (?, ?, ?, ?, ?, 'published')",
                        [$title, $speaker, $sermon_date, $audio_url, $content]
                    );
                    $success = '講道已成功新增';
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
        $sermon = $db->fetchOne("SELECT audio_url FROM sermons WHERE id = ?", [$_GET['delete']]);
        if ($sermon && $sermon['audio_url']) {
            // 刪除實體檔案
            $filePath = 'public/' . $sermon['audio_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $db->query("DELETE FROM sermons WHERE id = ?", [$_GET['delete']]);
        $success = '講道已刪除';
    } catch (Exception $e) {
        $error = '刪除失敗：' . $e->getMessage();
    }
}

// 獲取講道列表
try {
    $sermons = $db->fetchAll("SELECT * FROM sermons ORDER BY sermon_date DESC, created_at DESC");
} catch (Exception $e) {
    $sermons = [];
    $error = '資料讀取失敗：' . $e->getMessage();
}

// 獲取編輯的講道
$editSermon = null;
if (isset($_GET['edit'])) {
    try {
        $editSermon = $db->fetchOne("SELECT * FROM sermons WHERE id = ?", [$_GET['edit']]);
    } catch (Exception $e) {
        $error = '資料讀取失敗：' . $e->getMessage();
    }
}

$title = '後台管理 - 講道管理';
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
        .sermon-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .audio-player {
            width: 100%;
            margin: 10px 0;
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
                    <a class="nav-link active" href="sermons.php">
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
                    <h2>講道管理</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sermonModal">
                        <i class="fas fa-plus me-2"></i>上傳講道
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
                
                <!-- 講道列表 -->
                <div class="row">
                    <?php foreach ($sermons as $sermon): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="sermon-card">
                            <h5><?= htmlspecialchars($sermon['title']) ?></h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($sermon['speaker']) ?>
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-calendar me-1"></i><?= $sermon['sermon_date'] ?>
                            </p>
                            
                            <?php if ($sermon['content']): ?>
                                <p class="small text-muted mb-3"><?= htmlspecialchars(substr($sermon['content'], 0, 100)) ?>...</p>
                            <?php endif; ?>
                            
                            <!-- 音頻播放器 -->
                            <?php if ($sermon['audio_url']): ?>
                                <audio class="audio-player" controls>
                                    <source src="../public/<?= $sermon['audio_url'] ?>" type="audio/mpeg">
                                    您的瀏覽器不支援音頻播放
                                </audio>
                            <?php else: ?>
                                <div class="text-muted mb-3">
                                    <i class="fas fa-music me-1"></i>無音頻檔案
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <a href="?edit=<?= $sermon['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> 編輯
                                </a>
                                <a href="?delete=<?= $sermon['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('確定要刪除這個講道嗎？')">
                                    <i class="fas fa-trash"></i> 刪除
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($sermons)): ?>
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-microphone fa-3x mb-3"></i>
                            <p>還沒有講道記錄</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 上傳講道 Modal -->
    <div class="modal fade<?= $editSermon ? ' show' : '' ?>" id="sermonModal" tabindex="-1"<?= $editSermon ? ' style="display: block;"' : '' ?>>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $editSermon ? '編輯講道' : '上傳講道' ?></h5>
                    <a href="sermons.php" class="btn-close"></a>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editSermon ? 'edit' : 'add' ?>">
                    <?php if ($editSermon): ?>
                        <input type="hidden" name="id" value="<?= $editSermon['id'] ?>">
                    <?php endif; ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">講道標題</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= $editSermon ? htmlspecialchars($editSermon['title']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="speaker" class="form-label">講員</label>
                            <input type="text" class="form-control" id="speaker" name="speaker" 
                                   value="<?= $editSermon ? htmlspecialchars($editSermon['speaker']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="sermon_date" class="form-label">講道日期</label>
                            <input type="date" class="form-control" id="sermon_date" name="sermon_date" 
                                   value="<?= $editSermon ? $editSermon['sermon_date'] : date('Y-m-d') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="audio" class="form-label">音頻檔案</label>
                            <input type="file" class="form-control" id="audio" name="audio" accept="audio/*" 
                                   <?= $editSermon ? '' : 'required' ?>>
                            <div class="form-text">支援格式：MP3, WAV, M4A（最大50MB）</div>
                            <?php if ($editSermon && $editSermon['audio_url']): ?>
                                <div class="mt-2">
                                    <small class="text-muted">目前音頻：</small><br>
                                    <audio controls class="mt-1" style="width: 100%; max-width: 300px;">
                                        <source src="../public/<?= $editSermon['audio_url'] ?>" type="audio/mpeg">
                                    </audio>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">講道內容/摘要</label>
                            <textarea class="form-control" id="content" name="content" rows="4"><?= $editSermon ? htmlspecialchars($editSermon['content']) : '' ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="sermons.php" class="btn btn-secondary">取消</a>
                        <button type="submit" class="btn btn-primary"><?= $editSermon ? '更新' : '上傳' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($editSermon): ?>
    <script>
        // 如果是編輯模式，顯示modal
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('sermonModal'));
            modal.show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
