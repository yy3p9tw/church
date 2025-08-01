@echo off
echo 教會網站環境配置切換工具
echo ================================
echo.
echo 請選擇環境：
echo 1. 本地開發環境 (HTTP, localhost)
echo 2. InfinityFree 生產環境 (HTTPS, 實際資料庫)
echo.
set /p choice=請輸入選項 (1 或 2): 

if "%choice%"=="1" (
    copy .env.local .env > nul
    echo ✅ 已切換到本地開發環境
    echo 📝 資料庫: localhost/church_db  
    echo 🌐 網址: http://localhost:8000
) else if "%choice%"=="2" (
    copy .env.production .env > nul
    echo ✅ 已切換到 InfinityFree 生產環境
    echo 📝 資料庫: sql210.infinityfree.com/if0_39372471_church_db
    echo 🌐 網址: https://your-subdomain.infinityfreeapp.com
    echo ⚠️  記得更新 APP_URL 和 SITE_URL 為您的實際網域
) else (
    echo ❌ 無效選項
)

echo.
pause
