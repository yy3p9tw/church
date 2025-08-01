<?php
$title = '關於我們 - 基督教會';
require_once 'config/database.php';

// 獲取同工資料
$staff = $db->fetchAll("SELECT * FROM staff WHERE status = 1 ORDER BY sort_order ASC, created_at ASC");

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">關於我們</h1>
            
            <div class="row mb-5">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         class="img-fluid rounded shadow" alt="教會建築">
                </div>
                <div class="col-md-6">
                    <h3>我們的使命</h3>
                    <p>基督教會致力於傳播神的愛與真理，建立一個以基督為中心的信仰共同體。我們相信每個人都是神所愛的，並且透過耶穌基督，我們可以找到生命的意義與盼望。</p>
                    
                    <h3>我們的願景</h3>
                    <p>成為一個充滿愛、接納與關懷的教會，讓每個人都能在這裡找到屬靈的家園，經歷神的恩典與轉化。</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h3>我們的信仰</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信三位一體的神</li>
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信耶穌基督的救贖</li>
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信聖經是神的話語</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信聖靈的工作</li>
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信教會的重要性</li>
                                <li><i class="fas fa-check text-primary me-2"></i>我們相信永生的盼望</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h3>教會歷史</h3>
                    <p>基督教會成立於1985年，起初只是一個小小的家庭聚會。透過神的恩典與信徒們的同心協力，教會逐漸成長。如今，我們已成為一個擁有300多位會友的大家庭，繼續在社區中見證神的愛。</p>
                    
                    <p>多年來，教會不僅在靈性上服事會友，也積極參與社區服務，包括長者關懷、兒童教育、社會救助等各項事工，實踐基督愛人如己的教導。</p>
                </div>
            </div>
            
            <!-- 同工團隊 -->
            <?php if (!empty($staff)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center mb-4">同工團隊</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($staff as $member): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <?php if ($member['photo']): ?>
                                <img src="public/<?= $member['photo'] ?>" 
                                     alt="<?= htmlspecialchars($member['name']) ?>" 
                                     class="rounded-circle mb-3" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h5 class="card-title"><?= htmlspecialchars($member['name']) ?></h5>
                            <p class="text-primary fw-bold"><?= htmlspecialchars($member['title']) ?></p>
                            
                            <?php if ($member['bio']): ?>
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars($member['bio']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
