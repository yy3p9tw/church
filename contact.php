<?php
$title = '聯絡我們 - 基督教會';
require_once 'config/database.php';

// 處理表單提交
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $content = trim($_POST['message'] ?? '');
    
    // 基本驗證
    if (empty($name) || empty($email) || empty($subject) || empty($content)) {
        $message = '請填寫所有必填欄位';
        $messageType = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '請輸入有效的電子郵件地址';
        $messageType = 'danger';
    } else {
        // 儲存聯絡訊息到資料庫
        try {
            $db->query(
                "INSERT INTO contact_messages (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, " . $db->now() . ")",
                [$name, $email, $phone, $subject, $content]
            );
            $message = '感謝您的聯絡！我們會盡快回覆您。';
            $messageType = 'success';
            
            // 清空表單
            $_POST = [];
        } catch (Exception $e) {
            $message = '送出失敗，請稍後再試或直接致電聯絡我們。';
            $messageType = 'warning';
        }
    }
}

include 'includes/header.php';
?>

<!-- 頁面標題 -->
<div class="page-header py-5 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-0">聯絡我們</h1>
                <p class="lead mb-0">歡迎與我們聯繫，我們樂意為您服務</p>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-envelope fa-5x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- 聯絡表單 -->
        <div class="col-lg-8 mb-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-paper-plane me-2"></i>發送訊息</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">姓名 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">電子郵件 <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">聯絡電話</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">主旨 <span class="text-danger">*</span></label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="">請選擇主旨</option>
                                    <option value="一般詢問" <?= ($_POST['subject'] ?? '') === '一般詢問' ? 'selected' : '' ?>>一般詢問</option>
                                    <option value="聚會相關" <?= ($_POST['subject'] ?? '') === '聚會相關' ? 'selected' : '' ?>>聚會相關</option>
                                    <option value="活動報名" <?= ($_POST['subject'] ?? '') === '活動報名' ? 'selected' : '' ?>>活動報名</option>
                                    <option value="志工服務" <?= ($_POST['subject'] ?? '') === '志工服務' ? 'selected' : '' ?>>志工服務</option>
                                    <option value="禱告代求" <?= ($_POST['subject'] ?? '') === '禱告代求' ? 'selected' : '' ?>>禱告代求</option>
                                    <option value="奉獻相關" <?= ($_POST['subject'] ?? '') === '奉獻相關' ? 'selected' : '' ?>>奉獻相關</option>
                                    <option value="其他" <?= ($_POST['subject'] ?? '') === '其他' ? 'selected' : '' ?>>其他</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">訊息內容 <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="6" 
                                      placeholder="請輸入您的訊息..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>發送訊息
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- 聯絡資訊 -->
        <div class="col-lg-4">
            <!-- 聯絡方式 -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>聯絡資訊</h5>
                </div>
                <div class="card-body">
                    <div class="contact-item mb-3">
                        <i class="fas fa-map-marker-alt text-danger me-3"></i>
                        <div>
                            <strong>教會地址</strong><br>
                            <small class="text-muted">台北市中正區信義路一段100號</small>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-3">
                        <i class="fas fa-phone text-success me-3"></i>
                        <div>
                            <strong>聯絡電話</strong><br>
                            <small class="text-muted">(02) 2345-6789</small>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-3">
                        <i class="fas fa-envelope text-primary me-3"></i>
                        <div>
                            <strong>電子郵件</strong><br>
                            <small class="text-muted">info@gracechurch.com</small>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-globe text-info me-3"></i>
                        <div>
                            <strong>官方網站</strong><br>
                            <small class="text-muted">www.gracechurch.com</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 聚會時間 -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>聚會時間</h5>
                </div>
                <div class="card-body">
                    <div class="schedule-item mb-3">
                        <strong>主日崇拜</strong><br>
                        <small class="text-muted">每週日 上午 10:00 - 12:00</small>
                    </div>
                    
                    <div class="schedule-item mb-3">
                        <strong>禱告會</strong><br>
                        <small class="text-muted">每週三 晚上 19:30 - 21:00</small>
                    </div>
                    
                    <div class="schedule-item mb-3">
                        <strong>青年團契</strong><br>
                        <small class="text-muted">每週五 晚上 19:00 - 21:30</small>
                    </div>
                    
                    <div class="schedule-item">
                        <strong>兒童主日學</strong><br>
                        <small class="text-muted">每週日 上午 09:00 - 10:00</small>
                    </div>
                </div>
            </div>
            
            <!-- 交通資訊 -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-car me-2"></i>交通資訊</h5>
                </div>
                <div class="card-body">
                    <div class="transport-item mb-3">
                        <i class="fas fa-subway text-primary me-2"></i>
                        <strong>捷運</strong><br>
                        <small class="text-muted">善導寺站 1號出口步行3分鐘</small>
                    </div>
                    
                    <div class="transport-item mb-3">
                        <i class="fas fa-bus text-success me-2"></i>
                        <strong>公車</strong><br>
                        <small class="text-muted">信義路口站：202、208、212</small>
                    </div>
                    
                    <div class="transport-item">
                        <i class="fas fa-parking text-warning me-2"></i>
                        <strong>停車</strong><br>
                        <small class="text-muted">教會地下停車場（免費）</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 地圖區域 -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-map me-2"></i>教會位置</h5>
                </div>
                <div class="card-body p-0">
                    <div class="map-container" style="height: 400px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center text-muted">
                            <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                            <p>地圖載入中...</p>
                            <small>台北市中正區信義路一段100號</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 自定義樣式 -->
<style>
.contact-item, .schedule-item, .transport-item {
    display: flex;
    align-items: flex-start;
}

.contact-item i, .schedule-item i, .transport-item i {
    margin-top: 2px;
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

.map-container {
    border-radius: 0 0 0.375rem 0.375rem;
}
</style>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 表單驗證
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !subject || !message) {
                e.preventDefault();
                alert('請填寫所有必填欄位');
                return false;
            }
            
            // 簡單的郵件格式驗證
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('請輸入有效的電子郵件地址');
                return false;
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
