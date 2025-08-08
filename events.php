<?php
$title = '活動 - 基督教會';
require_once 'config/database.php';

// 獲取所有已發布的活動
$events = $db->fetchAll("SELECT * FROM events WHERE status = 'published' ORDER BY start_time ASC");

include 'includes/header.php';
?>

<!-- 頁面標題 -->
<div class="page-header py-5 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-0">教會活動</h1>
                <p class="lead mb-0">參與我們的活動，一起成長與服事</p>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-calendar-alt fa-5x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if (empty($events)): ?>
        <!-- 沒有活動時的顯示 -->
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">目前沒有活動</h3>
                        <p class="text-muted">敬請期待更多精彩的教會活動！</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- 活動列表 -->
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <?php if (!empty($event['image_url'])): ?>
                            <img src="public/<?= htmlspecialchars($event['image_url']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($event['title']) ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                 style="height: 200px;">
                                <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
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
                            <p class="card-text">
                                <?= mb_substr(strip_tags($event['content']), 0, 100) ?>
                                <?= mb_strlen(strip_tags($event['content'])) > 100 ? '...' : '' ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-outline-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#eventModal<?= $event['id'] ?>">
                                <i class="fas fa-info-circle me-1"></i>詳細資訊
                            </button>
                            
                            <!-- 檢查活動是否已過期 -->
                            <?php 
                            $eventTime = strtotime($event['start_time']);
                            $now = time();
                            ?>
                            <?php if ($eventTime < $now): ?>
                                <span class="badge bg-secondary ms-2">已結束</span>
                            <?php elseif ($eventTime - $now < 86400): ?>
                                <span class="badge bg-warning ms-2">即將開始</span>
                            <?php else: ?>
                                <span class="badge bg-success ms-2">報名中</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- 活動詳情模態框 -->
                <div class="modal fade" id="eventModal<?= $event['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($event['title']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($event['image_url'])): ?>
                                    <img src="public/<?= htmlspecialchars($event['image_url']) ?>" 
                                         class="img-fluid mb-3 rounded" 
                                         alt="<?= htmlspecialchars($event['title']) ?>">
                                <?php endif; ?>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>時間：</strong></div>
                                    <div class="col-sm-9">
                                        <?= date('Y年m月d日 (週'.['日','一','二','三','四','五','六'][date('w', strtotime($event['start_time']))].') H:i', strtotime($event['start_time'])) ?>
                                        <?php if (!empty($event['end_time'])): ?>
                                            - <?= date('H:i', strtotime($event['end_time'])) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if (!empty($event['location'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>地點：</strong></div>
                                        <div class="col-sm-9"><?= htmlspecialchars($event['location']) ?></div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>內容：</strong></div>
                                    <div class="col-sm-9"><?= nl2br(htmlspecialchars($event['content'])) ?></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <?php if ($eventTime >= $now): ?>
                                    <button type="button" class="btn btn-primary">我要報名</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- 自定義樣式 -->
<style>
.hover-card {
    transition: transform 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
}

.page-header {
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="20" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="5" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="15" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="20" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}
</style>

<?php include 'includes/footer.php'; ?>
