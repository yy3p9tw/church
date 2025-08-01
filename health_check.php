<?php
/**
 * 系統健康檢查
 * 
 * 此檔案用於檢查系統是否正常運行
 * 在部署後可以訪問此檔案確認一切正常
 */

header('Content-Type: application/json; charset=utf-8');

$checks = [];
$overall_status = 'ok';

// 檢查 PHP 版本
$php_version = phpversion();
$checks['php_version'] = [
    'status' => version_compare($php_version, '7.4', '>=') ? 'ok' : 'warning',
    'value' => $php_version,
    'message' => version_compare($php_version, '7.4', '>=') ? 'PHP 版本正常' : 'PHP 版本可能過舊'
];

// 檢查必要的 PHP 擴展
$required_extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

$checks['php_extensions'] = [
    'status' => empty($missing_extensions) ? 'ok' : 'error',
    'value' => $required_extensions,
    'missing' => $missing_extensions,
    'message' => empty($missing_extensions) ? '所有必要擴展已安裝' : '缺少必要的 PHP 擴展'
];

if (!empty($missing_extensions)) {
    $overall_status = 'error';
}

// 檢查資料庫連接
try {
    require_once __DIR__ . '/config/database.php';
    $db = new Database();
    $connection = $db->connect();
    
    $checks['database'] = [
        'status' => 'ok',
        'type' => $db->isMySQL() ? 'MySQL' : 'SQLite',
        'message' => '資料庫連接正常'
    ];
    
    // 檢查基本表格是否存在
    $tables = ['news', 'sermons', 'events', 'bulletins', 'staff'];
    $existing_tables = [];
    
    foreach ($tables as $table) {
        try {
            $stmt = $connection->prepare("SELECT 1 FROM $table LIMIT 1");
            $stmt->execute();
            $existing_tables[] = $table;
        } catch (PDOException $e) {
            // 表格不存在或有錯誤
        }
    }
    
    $checks['database_tables'] = [
        'status' => count($existing_tables) === count($tables) ? 'ok' : 'warning',
        'existing' => $existing_tables,
        'expected' => $tables,
        'message' => count($existing_tables) === count($tables) ? '所有資料表存在' : '部分資料表可能不存在'
    ];
    
} catch (Exception $e) {
    $checks['database'] = [
        'status' => 'error',
        'message' => '資料庫連接失敗: ' . $e->getMessage()
    ];
    $overall_status = 'error';
}

// 檢查檔案權限
$upload_dirs = ['public/uploads', 'public/uploads/news', 'public/uploads/events', 'public/uploads/bulletins', 'public/uploads/staff'];
$writable_dirs = [];
$non_writable_dirs = [];

foreach ($upload_dirs as $dir) {
    if (is_dir($dir) && is_writable($dir)) {
        $writable_dirs[] = $dir;
    } else {
        $non_writable_dirs[] = $dir;
    }
}

$checks['file_permissions'] = [
    'status' => empty($non_writable_dirs) ? 'ok' : 'warning',
    'writable' => $writable_dirs,
    'non_writable' => $non_writable_dirs,
    'message' => empty($non_writable_dirs) ? '檔案權限正常' : '部分目錄可能無法寫入'
];

// 檢查環境配置
$env_file_exists = file_exists(__DIR__ . '/.env');
$checks['environment'] = [
    'status' => $env_file_exists ? 'ok' : 'warning',
    'env_file' => $env_file_exists,
    'message' => $env_file_exists ? '環境配置檔案存在' : '未找到 .env 檔案'
];

// 系統資訊
$system_info = [
    'php_version' => phpversion(),
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
    'current_time' => date('Y-m-d H:i:s'),
    'timezone' => date_default_timezone_get(),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size')
];

// 輸出結果
$result = [
    'status' => $overall_status,
    'message' => $overall_status === 'ok' ? '系統運行正常' : '發現一些問題，請檢查詳細資訊',
    'timestamp' => date('Y-m-d H:i:s'),
    'checks' => $checks,
    'system_info' => $system_info
];

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
