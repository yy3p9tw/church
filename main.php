<?php
/**
 * InfinityFree 部署入口文件
 * 
 * 此文件會自動檢測環境並載入適當的配置
 */

// 設定時區
date_default_timezone_set('Asia/Taipei');

// 載入環境配置
if (file_exists(__DIR__ . '/.env')) {
    $envFile = __DIR__ . '/.env';
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue; // 跳過註釋
        if (strpos($line, '=') === false) continue; // 跳過無效行
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // 移除引號
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
            (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }
        
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

// 設定錯誤報告
if (isset($_ENV['DISPLAY_ERRORS']) && $_ENV['DISPLAY_ERRORS'] === 'false') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 1);
}

// 設定錯誤記錄
if (isset($_ENV['LOG_ERRORS']) && $_ENV['LOG_ERRORS'] === 'true') {
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/error.log');
}

// 設定上傳限制
if (isset($_ENV['UPLOAD_MAX_SIZE'])) {
    ini_set('upload_max_filesize', $_ENV['UPLOAD_MAX_SIZE']);
    ini_set('post_max_size', $_ENV['UPLOAD_MAX_SIZE']);
}

// 載入主要應用程式
require_once __DIR__ . '/index.php';
?>
