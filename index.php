<?php
$title = '首頁 - 基督教會';
require_once 'config/database.php';

// 獲取最新消息
$news = $db->fetchAll("SELECT * FROM news WHERE status = 'published' ORDER BY news_date DESC, created_at DESC LIMIT 3");

// 獲取最新講道
$sermons = $db->fetchAll("SELECT * FROM sermons WHERE status = 'published' ORDER BY sermon_date DESC, created_at DESC LIMIT 3");

// 獲取近期活動
$events = $db->fetchAll("SELECT * FROM events WHERE status = 'published' AND start_time >= " . $db->now() . " ORDER BY start_time ASC LIMIT 3");

// 獲取輪播圖（如果有）
$sliders = $db->fetchAll("SELECT * FROM sliders ORDER BY sort_order ASC");

include 'includes/header.php';
?>

<!-- 主要橫幅 -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">歡迎來到基督教會</h1>
                <p class="lead mb-4">我們是一個以基督為中心的教會，致力於傳播神的愛與真理，建立一個充滿愛的信仰共同體。</p>
                <div>
                    <a href="about.php" class="btn btn-primary btn-lg me-3">認識我們</a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg">聯絡我們</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 服務項目 -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-12">
                <h2 class="fw-bold">我們的服務</h2>
                <p class="text-muted">透過多元的聚會與活動，我們致力於建立一個溫暖的信仰家園</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm card-hover">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-pray fa-3x"></i>
                        </div>
                        <h5 class="card-title">主日崇拜</h5>
                        <p class="card-text">每週日上午10點的主日崇拜，透過敬拜、禱告與證道，一同親近神。</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm card-hover">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-book-open fa-3x"></i>
                        </div>
                        <h5 class="card-title">查經班</h5>
                        <p class="card-text">週五晚上的查經班，深入研讀聖經，建立穩固的信仰根基。</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center border-0 shadow-sm card-hover">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-hands fa-3x"></i>
                        </div>
                        <h5 class="card-title">禱告會</h5>
                        <p class="card-text">週三晚上的禱告會，為個人、家庭、教會與社會的需要代禱。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 最新消息 -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-12 text-center">
                <h2 class="fw-bold">最新消息</h2>
                <p class="text-muted">掌握教會最新動態與活動資訊</p>
            </div>
        </div>
        <div class="row g-4">
            <?php if (!empty($news)): ?>
                <?php foreach ($news as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm card-hover">
                        <?php if ($item['image_url']): ?>
                            <img src="public/<?= $item['image_url'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1544207240-1f1000e8bf32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?= $item['news_date'] ?: date('Y/m/d', strtotime($item['created_at'])) ?>
                            </h6>
                            <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($item['content'], 0, 80)) ?>...</p>
                            <a href="news.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm">閱讀更多</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">目前沒有最新消息</p>
                </div>
            <?php endif; ?>
                        <p class="card-text">參與社區清潔活動，實踐愛鄰舍的聖經教導。</p>
                        <a href="news.php" class="btn btn-outline-primary btn-sm">閱讀更多</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="news.php" class="btn btn-primary">查看所有消息</a>
        </div>
    </div>
</section>

<!-- 行動呼籲 -->
<section class="py-5" style="background-color: var(--secondary-color);">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-lg-12">
                <h2 class="fw-bold mb-4">加入我們的大家庭</h2>
                <p class="lead mb-4">無論您是初次造訪或是尋找教會家園，我們都歡迎您的到來</p>
                <a href="contact.php" class="btn btn-light btn-lg">立即聯絡</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
