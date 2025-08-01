# 📋 InfinityFree 部署最終檢查清單

## ✅ 部署前準備 (已完成)
- [x] 修復所有內容顯示問題 (狀態統一為 'published')
- [x] 修復員工管理系統 (使用實際資料庫操作)
- [x] 清理不需要的檔案 (移除 10 個臨時檔案)
- [x] 設定生產環境配置 (.env.production)
- [x] 設定本地開發配置 (.env.local)
- [x] 創建環境切換工具 (switch_env.bat)
- [x] 測試所有功能模組

## 🚀 部署步驟

### 步驟 1: 上傳檔案到 InfinityFree
1. 登入您的 InfinityFree 控制台
2. 開啟 File Manager 或使用 FTP 客戶端
3. 上傳所有專案檔案到 `htdocs` 目錄 (除了以下檔案)：
   ```
   排除檔案：
   - .env.local
   - switch_env.bat
   - README.md
   - DEPLOY_INFINITYFREE.md
   - church_db.sql (稍後手動匯入)
   ```

### 步驟 2: 設定生產環境
1. 確保 `.env.production` 已重新命名為 `.env`
2. 或執行 `switch_env.bat` 選擇生產環境

### 步驟 3: 初始化資料庫
**方法 A: 使用 phpMyAdmin (推薦)**
1. 在 InfinityFree 控制台開啟 phpMyAdmin
2. 選擇資料庫 `if0_39372471_church_db`
3. 匯入 `church_db.sql` 檔案

**方法 B: 使用自動設定腳本**
1. 在瀏覽器開啟 `https://your-subdomain.infinityfreeapp.com/setup_infinityfree.php`
2. 按照指示完成設定

### 步驟 4: 配置最終設定
1. 編輯 `.env` 檔案，更新您的實際網域：
   ```
   APP_URL=https://your-subdomain.infinityfreeapp.com
   SITE_URL=https://your-subdomain.infinityfreeapp.com
   ```

### 步驟 5: 測試網站功能
- [x] 首頁顯示
- [x] 消息頁面 (顯示已發布內容)
- [x] 講道頁面 (顯示已發布內容)
- [x] 活動頁面 (顯示已發布內容)
- [x] 公告頁面 (顯示已發布內容)
- [x] 關於我們頁面
- [x] 聯絡我們頁面
- [x] 管理員登入 (/admin/)
- [x] 所有管理功能

## 📂 資料庫認證資訊 (生產環境)
```
主機: sql210.infinityfree.com
資料庫: if0_39372471_church_db
使用者: if0_39372471
密碼: rKGBnL9c0dpm75
```

## 🛠️ 管理員預設帳號
```
使用者名稱: admin
密碼: admin123
```
**重要：** 首次登入後請立即更改密碼！

## 📱 功能特色確認
- ✅ 響應式設計 (手機、平板、桌面)
- ✅ 內容管理系統 (消息、講道、活動、公告、員工)
- ✅ 檔案上傳 (圖片 5MB、PDF 50MB)
- ✅ YouTube 影片整合
- ✅ 安全的管理員系統
- ✅ 健康檢查頁面 (/health_check.php)

## 🔧 維護工具
- **環境切換**: 執行 `switch_env.bat` (僅限本地開發)
- **健康檢查**: 造訪 `/health_check.php` 檢查系統狀態
- **備份**: 定期備份 `uploads` 目錄和資料庫

## 📞 支援資訊
如有問題，可檢查：
1. `/health_check.php` - 系統狀態診斷
2. InfinityFree 錯誤日誌
3. PHP 錯誤日誌

---
✨ **恭喜！您的教會網站已準備好部署到 InfinityFree！** ✨
