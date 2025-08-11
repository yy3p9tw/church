<?php
include 'auth.php';

// 免登入：直接導向儀表板
header('Location: index.php');
exit;

$title = '後台登入';
?>
<!-- login 已停用，這個檔僅保留為相容性入口。 -->
