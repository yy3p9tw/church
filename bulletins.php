<?php
$title = '教會週報 - 基督教會';
require_once 'config/database.php';

// 獲取所有週報
$bulletins = $db->fetchAll("SELECT * FROM bulletins ORDER BY publish_date DESC");

include 'includes/header.php';
?>

<!-- 頁面標題 -->
<div class="page-header py-5 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-0">教會週報</h1>
                <p class="lead mb-0">掌握教會每週最新動態與活動資訊</p>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-file-alt fa-5x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if (empty($bulletins)): ?>
        <!-- 沒有週報時的顯示 -->
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">目前沒有週報</h3>
                        <p class="text-muted">敬請期待最新的教會週報！</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- 週報列表 -->
        <div class="row">
            <?php foreach ($bulletins as $bulletin): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <?php if (!empty($bulletin['image_url'])): ?>
                            <?php 
                                $img = $bulletin['image_url'];
                                $imgSrc = (!empty($img) && (preg_match('/^https?:\\/\\//i', $img) || strpos($img, '/') === 0)) 
                                    ? $img 
                                    : ('public/' . $img);
                            ?>
                            <img src="<?= htmlspecialchars($imgSrc) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($bulletin['title']) ?>"
                                 style="height: 300px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                 style="height: 300px;">
                                <i class="fas fa-file-alt fa-5x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($bulletin['title']) ?></h5>
                            
                            <!-- 發布日期 -->
                            <div class="mb-3">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                <small class="text-muted">
                                    <?= date('Y年m月d日', strtotime($bulletin['publish_date'])) ?>
                                    (週<?= ['日','一','二','三','四','五','六'][date('w', strtotime($bulletin['publish_date']))] ?>)
                                </small>
                            </div>
                            
                            <div class="mt-auto">
                                <?php if (!empty($bulletin['pdf_url'])): ?>
                                    <?php 
                                        $pdf = $bulletin['pdf_url'];
                                        $pdfLink = (!empty($pdf) && (preg_match('/^https?:\\/\\//i', $pdf) || strpos($pdf, '/') === 0))
                                            ? $pdf
                                            : ('public/' . $pdf);
                                    ?>
                                    <a href="<?= htmlspecialchars($pdfLink) ?>" 
                                       target="_blank" 
                                       class="btn btn-primary">
                                        <i class="fas fa-file-pdf me-2"></i>下載週報 PDF
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($bulletin['image_url'])): ?>
                                    <button class="btn btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#bulletinModal<?= $bulletin['id'] ?>">
                                        <i class="fas fa-eye me-2"></i>預覽
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 週報預覽模態框 -->
                <div class="modal fade" id="bulletinModal<?= $bulletin['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($bulletin['title']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <?php if (!empty($bulletin['image_url'])): ?>
                                    <?php 
                                        $img = $bulletin['image_url'];
                                        $imgSrc = (!empty($img) && (preg_match('/^https?:\\/\\//i', $img) || strpos($img, '/') === 0)) 
                                            ? $img 
                                            : ('public/' . $img);
                                    ?>
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?= htmlspecialchars($bulletin['title']) ?>"
                                         style="max-height: 70vh;">
                                <?php endif; ?>
                                
                                <div class="mt-3">
                                    <p class="text-muted">
                                        <i class="fas fa-calendar me-2"></i>
                                        發布日期：<?= date('Y年m月d日', strtotime($bulletin['publish_date'])) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <?php if (!empty($bulletin['pdf_url'])): ?>
                                    <?php 
                                        $pdf = $bulletin['pdf_url'];
                                        $pdfLink = (!empty($pdf) && (preg_match('/^https?:\\/\\//i', $pdf) || strpos($pdf, '/') === 0))
                                            ? $pdf
                                            : ('public/' . $pdf);
                                    ?>
                                    <a href="<?= htmlspecialchars($pdfLink) ?>" 
                                       target="_blank" 
                                       class="btn btn-primary">
                                        <i class="fas fa-file-pdf me-2"></i>下載 PDF
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- 分頁功能 (如果需要的話) -->
        <?php if (count($bulletins) > 12): ?>
            <nav aria-label="週報分頁" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">上一頁</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">下一頁</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
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
