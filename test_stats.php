<?php
// 簡單的資料庫統計測試
require_once 'config/database.php';

$db = new Database();

echo "📊 資料庫統計測試\n";
echo "==================\n";

try {
    $newsCount = $db->fetchOne("SELECT COUNT(*) as count FROM news")['count'];
    echo "📰 最新消息: {$newsCount} 篇\n";
    
    $sermonsCount = $db->fetchOne("SELECT COUNT(*) as count FROM sermons")['count'];
    echo "🎤 講道: {$sermonsCount} 篇\n";
    
    $eventsCount = $db->fetchOne("SELECT COUNT(*) as count FROM events")['count'];
    echo "📅 活動: {$eventsCount} 個\n";
    
    $staffCount = $db->fetchOne("SELECT COUNT(*) as count FROM staff")['count'];
    echo "👥 同工: {$staffCount} 位\n";
    
    echo "\n✅ 統計查詢成功！\n";
} catch (Exception $e) {
    echo "❌ 錯誤: " . $e->getMessage() . "\n";
}
?>
