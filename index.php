<?php
$title = '首頁 - 基督教會';
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
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm card-hover">
                    <img src="https://images.unsplash.com/photo-1544207240-1f1000e8bf32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="復活節慶典">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">2024/03/31</h6>
                        <h5 class="card-title">復活節慶典</h5>
                        <p class="card-text">歡迎參與我們的復活節慶典，一同慶祝主耶穌的復活。</p>
                        <a href="news.php" class="btn btn-outline-primary btn-sm">閱讀更多</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm card-hover">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="青年營會">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">2024/04/15</h6>
                        <h5 class="card-title">青年營會</h5>
                        <p class="card-text">為期三天的青年營會，透過遊戲與分享建立深厚友誼。</p>
                        <a href="news.php" class="btn btn-outline-primary btn-sm">閱讀更多</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm card-hover">
                    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="社區服務">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">2024/04/20</h6>
                        <h5 class="card-title">社區服務</h5>
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
