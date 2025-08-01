<?php
require_once 'config/database.php';

// 如果有指定ID，顯示單個講道
if (isset($_GET['id'])) {
    $sermon = $db->fetchOne("SELECT * FROM sermons WHERE id = ? AND status = 'published'", [$_GET['id']]);
    if (!$sermon) {
        header('HTTP/1.0 404 Not Found');
        $title = '講道不存在 - 基督教會';
    } else {
        $title = htmlspecialchars($sermon['title']) . ' - 基督教會';
    }
} else {
    $title = '講道信息 - 基督教會';
    // 獲取所有講道，分頁
    $page = (int)($_GET['page'] ?? 1);
    $limit = 9;
    $offset = ($page - 1) * $limit;
    
    $sermons = $db->fetchAll("SELECT * FROM sermons WHERE status = 'published' ORDER BY sermon_date DESC, created_at DESC LIMIT $limit OFFSET $offset");
    $totalSermons = $db->fetchOne("SELECT COUNT(*) as count FROM sermons WHERE status = 'published'")['count'];
    $totalPages = ceil($totalSermons / $limit);
}

include 'includes/header.php';
?>

<div class="container py-5">
    <?php if (isset($_GET['id'])): ?>
        <!-- 單個講道詳情 -->
        <?php if ($sermon): ?>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="sermons.php">講道信息</a></li>
                            <li class="breadcrumb-item active"><?= htmlspecialchars($sermon['title']) ?></li>
                        </ol>
                    </nav>
                    
                    <article class="mb-5">
                        <h1 class="mb-3"><?= htmlspecialchars($sermon['title']) ?></h1>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="text-muted">
                                    <i class="fas fa-user me-2"></i>講員：<?= htmlspecialchars($sermon['speaker']) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted">
                                    <i class="fas fa-calendar me-2"></i>日期：<?= $sermon['sermon_date'] ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($sermon['audio_url']): ?>
                            <div class="mb-4">
                                <h5>音頻播放</h5>
                                <audio controls class="w-100" style="max-width: 500px;">
                                    <source src="public/<?= $sermon['audio_url'] ?>" type="audio/mpeg">
                                    您的瀏覽器不支援音頻播放
                                </audio>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($sermon['content']): ?>
                            <div class="sermon-content">
                                <h5>講道內容</h5>
                                <?= nl2br(htmlspecialchars($sermon['content'])) ?>
                            </div>
                        <?php endif; ?>
                    </article>
                    
                    <div class="text-center">
                        <a href="sermons.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>返回講道列表
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1>找不到此講道</h1>
                    <p class="text-muted mb-4">您訪問的講道可能已被移除或不存在。</p>
                    <a href="sermons.php" class="btn btn-primary">返回講道列表</a>
                </div>
            </div>
        <?php endif; ?>
    
    <?php else: ?>
        <!-- 講道列表 -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                        <li class="breadcrumb-item active">講道信息</li>
                    </ol>
                </nav>
                
                <h1 class="text-center mb-5">講道信息</h1>
                
                <?php if (!empty($sermons)): ?>
                    <div class="row g-4">
                        <?php foreach ($sermons as $sermon): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($sermon['title']) ?></h5>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($sermon['speaker']) ?>
                                        </small><br>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i><?= $sermon['sermon_date'] ?>
                                        </small>
                                    </div>
                                    
                                    <?php if ($sermon['content']): ?>
                                        <p class="card-text flex-grow-1 small">
                                            <?= htmlspecialchars(substr($sermon['content'], 0, 100)) ?>...
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if ($sermon['audio_url']): ?>
                                        <div class="mb-3">
                                            <audio controls class="w-100">
                                                <source src="public/<?= $sermon['audio_url'] ?>" type="audio/mpeg">
                                                您的瀏覽器不支援音頻播放
                                            </audio>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="mt-auto">
                                        <a href="sermons.php?id=<?= $sermon['id'] ?>" class="btn btn-outline-primary btn-sm">
                                            查看詳情
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- 分頁 -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="講道分頁" class="mt-5">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page - 1 ?>">上一頁</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page + 1 ?>">下一頁</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="text-muted mb-4">
                            <i class="fas fa-microphone fa-3x"></i>
                        </div>
                        <h4>目前沒有講道信息</h4>
                        <p class="text-muted">請稍後再回來查看最新的講道信息。</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
