<?php
include 'auth.php';

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (checkLogin($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = '帳號或密碼錯誤';
    }
}

$title = '後台登入';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">後台管理</h3>
                        <p class="text-muted">請輸入您的帳號密碼</p>
                    </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">電子郵件</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">密碼</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">登入</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <small class="text-muted">測試帳號：admin@church.com / admin123</small>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <a href="../index.php" class="btn btn-outline-secondary btn-sm">回到前台</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
