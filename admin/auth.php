<?php
session_start();
require_once dirname(__DIR__) . '/config/database.php';

function requireLogin() {
    if (!isset($_SESSION['admin_user'])) {
        header('Location: login.php');
        exit;
    }
}

function checkLogin($email, $password) {
    global $db;
    
    try {
        $user = $db->fetchOne(
            "SELECT * FROM users WHERE email = ? AND role = 'admin'", 
            [$email]
        );
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_user'] = $user['name'];
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_email'] = $user['email'];
            
            // 更新最後登入時間（如果支援）
            try {
                $db->query(
                    "UPDATE users SET last_login_at = " . $db->now() . " WHERE id = ?", 
                    [$user['id']]
                );
            } catch (Exception $e) {
                // 忽略更新錯誤
            }
            
            return true;
        }
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
    }
    
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}

function getCurrentUser() {
    global $db;
    
    if (!isset($_SESSION['admin_id'])) {
        return null;
    }
    
    try {
        return $db->fetchOne(
            "SELECT * FROM users WHERE id = ?", 
            [$_SESSION['admin_id']]
        );
    } catch (Exception $e) {
        return null;
    }
}
?>
