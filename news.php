<?php
require_once 'config/database.php';

// 如果有指定ID，顯示單篇新聞
if (isset($_GET['id'])) {
    $newsItem = $db->fetchOne("SELECT * FROM news WHERE id = ? AND status = 'published'", [$_GET['id']]);
    if (!$newsItem) {
        header('HTTP/1.0 404 Not Found');
        $title = '新聞不存在 - 基督教會';
    } else {
        $title = htmlspecialchars($newsItem['title']) . ' - 基督教會';
    }
} else {
    $title = '最新消息 - 基督教會';
    // 獲取所有新聞，分頁
    $page = (int)($_GET['page'] ?? 1);
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    $news = $db->fetchAll("SELECT * FROM news WHERE status = 'published' ORDER BY news_date DESC, created_at DESC LIMIT $limit OFFSET $offset");
    $totalNews = $db->fetchOne("SELECT COUNT(*) as count FROM news WHERE status = 'published'")['count'];
    $totalPages = ceil($totalNews / $limit);
}

include 'includes/header.php';
?>

<div class="container py-5">
    <?php if (isset($_GET['id'])): ?>
        <!-- 單篇新聞詳情 -->
        <?php if ($newsItem): ?>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="news.php">最新消息</a></li>
                            <li class="breadcrumb-item active"><?= htmlspecialchars($newsItem['title']) ?></li>
                        </ol>
                    </nav>
                    
                    <article class="mb-5">
                        <h1 class="mb-3"><?= htmlspecialchars($newsItem['title']) ?></h1>
                        
                        <div class="text-muted mb-4">
                            <i class="fas fa-calendar me-2"></i>
                            <?= $newsItem['news_date'] ?: date('Y年m月d日', strtotime($newsItem['created_at'])) ?>
                        </div>
                        
                        <?php if ($newsItem['image_url']): ?>
                            <img src="public/<?= $newsItem['image_url'] ?>" 
                                 class="img-fluid rounded mb-4" 
                                 alt="<?= htmlspecialchars($newsItem['title']) ?>">
                        <?php endif; ?>
                        
                        <div class="news-content">
                            <?= nl2br(htmlspecialchars($newsItem['content'])) ?>
                        </div>
                    </article>
                    
                    <div class="text-center">
                        <a href="news.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>返回消息列表
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1>找不到此新聞</h1>
                    <p class="text-muted mb-4">您訪問的新聞可能已被移除或不存在。</p>
                    <a href="news.php" class="btn btn-primary">返回消息列表</a>
                </div>
            </div>
        <?php endif; ?>
    
    <?php else: ?>
        <!-- 新聞列表 -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                        <li class="breadcrumb-item active">最新消息</li>
                    </ol>
                </nav>
                
                <h1 class="text-center mb-5">最新消息</h1>
                
                <?php if (!empty($news)): ?>
                    <div class="row g-4">
                        <?php foreach ($news as $item): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if ($item['image_url']): ?>
                                    <img src="public/<?= $item['image_url'] ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($item['title']) ?>"
                                         style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                                    <p class="card-text flex-grow-1">
                                        <?= htmlspecialchars(substr($item['content'], 0, 150)) ?>...
                                    </p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= $item['news_date'] ?: date('Y/m/d', strtotime($item['created_at'])) ?>
                                            </small>
                                            <a href="news.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm">
                                                閱讀更多
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- 分頁 -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="新聞分頁" class="mt-5">
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
                            <i class="fas fa-newspaper fa-3x"></i>
                        </div>
                        <h4>目前沒有消息</h4>
                        <p class="text-muted">請稍後再回來查看最新消息。</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
