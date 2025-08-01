<?php
/**
 * InfinityFree 資料庫設置腳本
 * 
 * 執行此腳本來創建必要的資料庫表格
 * 請在 InfinityFree 上創建資料庫後執行
 */

// 載入環境配置
if (file_exists(__DIR__ . '/.env')) {
    $envFile = __DIR__ . '/.env';
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
            (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }
        
        $_ENV[$key] = $value;
    }
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'church_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✅ 資料庫連接成功！\n\n";
    
    // 讀取並執行 SQL 文件
    $sqlFile = __DIR__ . '/church_db.sql';
    if (!file_exists($sqlFile)) {
        die("❌ 找不到 church_db.sql 文件\n");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // 分割 SQL 語句
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement) || strpos($statement, '--') === 0) continue;
        
        try {
            $pdo->exec($statement);
            $successCount++;
        } catch (PDOException $e) {
            $errorCount++;
            echo "⚠️  SQL 錯誤: " . $e->getMessage() . "\n";
            echo "語句: " . substr($statement, 0, 100) . "...\n\n";
        }
    }
    
    echo "📊 執行結果:\n";
    echo "✅ 成功執行: $successCount 個語句\n";
    echo "❌ 執行失敗: $errorCount 個語句\n\n";
    
    if ($errorCount === 0) {
        echo "🎉 資料庫設置完成！\n";
        echo "🔗 您現在可以訪問您的網站了。\n";
    } else {
        echo "⚠️  有一些錯誤，請檢查上面的錯誤訊息。\n";
    }
    
} catch (PDOException $e) {
    echo "❌ 資料庫連接失敗: " . $e->getMessage() . "\n";
    echo "\n📝 請檢查以下設定:\n";
    echo "- DB_HOST: $host\n";
    echo "- DB_NAME: $dbname\n";
    echo "- DB_USER: $username\n";
    echo "- DB_PASS: " . (empty($password) ? '(空白)' : '***') . "\n";
}
?>
