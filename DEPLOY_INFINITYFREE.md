# InfinityFree 部署指南

## 📋 部署步驟

### 1. 準備 InfinityFree 帳戶
1. 註冊 [InfinityFree](https://infinityfree.net/) 帳戶
2. 創建新的網站（選擇免費子域名或使用自己的域名）
3. 記下您的子域名：`your-subdomain.infinityfreeapp.com`

### 2. 設置資料庫
1. 登入 InfinityFree 控制台
2. 點擊「MySQL Databases」
3. 創建新資料庫，記下以下資訊：
   - **Database Host**: `sqlXXX.infinityfree.com`
   - **Database Name**: `epizXXXXX_church`
   - **Username**: `epizXXXXX_user` 
   - **Password**: 您設定的密碼

### 3. 配置環境檔案
1. 將 `.env.infinityfree` 重新命名為 `.env`
2. 編輯 `.env` 檔案，填入您的資料庫資訊：
```bash
DB_HOST=sqlXXX.infinityfree.com
DB_NAME=epizXXXXX_church
DB_USER=epizXXXXX_user
DB_PASS=您的資料庫密碼
APP_URL=https://your-subdomain.infinityfreeapp.com
```

### 4. 上傳檔案
1. 使用 FTP 客戶端（如 FileZilla）或 InfinityFree 的檔案管理器
2. 將所有檔案上傳到 `htdocs` 目錄
3. 確保以下檔案結構：
```
htdocs/
├── .env
├── index.php
├── about.php
├── news.php
├── sermons.php
├── events.php
├── bulletins.php
├── contact.php
├── admin/
├── config/
├── includes/
├── public/
└── setup_infinityfree.php
```

### 5. 初始化資料庫
1. 在瀏覽器中訪問：`https://your-subdomain.infinityfreeapp.com/setup_infinityfree.php`
2. 腳本會自動創建所有必要的資料庫表格
3. 看到「🎉 資料庫設置完成！」訊息後，刪除 `setup_infinityfree.php` 檔案

### 6. 訪問網站
- **前台**: `https://your-subdomain.infinityfreeapp.com`
- **後台**: `https://your-subdomain.infinityfreeapp.com/admin`
- **預設管理員帳戶**: 
  - 用戶名: `admin`
  - 密碼: `.env` 檔案中設定的 `ADMIN_PASSWORD`

## ⚙️ InfinityFree 限制與注意事項

### 資源限制
- **磁盤空間**: 5GB
- **流量**: 無限制
- **資料庫**: 400個
- **檔案上傳**: 10MB
- **同時連線**: 25個

### 技術限制
- **PHP 版本**: 8.1+
- **MySQL**: 支援
- **HTTPS**: 免費提供
- **Cron Jobs**: 不支援

### 優化建議
1. **壓縮圖片**: 上傳前先壓縮圖片檔案
2. **快取設定**: 利用瀏覽器快取
3. **檔案大小**: 保持檔案精簡
4. **資料庫查詢**: 優化查詢效能

## 🛠️ 故障排除

### 常見問題

**1. 資料庫連接失敗**
- 檢查 `.env` 檔案中的資料庫設定
- 確認資料庫已在 InfinityFree 控制台中創建
- 檢查資料庫主機名稱是否正確

**2. 檔案上傳失敗**
- 檢查 `public/uploads/` 目錄權限
- 確認檔案大小不超過 10MB
- 檢查支援的檔案格式

**3. 頁面顯示錯誤**
- 檢查 `.env` 檔案是否存在
- 確認所有檔案都已正確上傳
- 檢查檔案權限設定

**4. 管理員登入失敗**
- 檢查 `.env` 檔案中的 `ADMIN_PASSWORD` 設定
- 確認用戶名為 `admin`
- 嘗試重新設定密碼

## 📞 支援

如果遇到問題，可以：
1. 檢查 InfinityFree 的文檔和 FAQ
2. 查看錯誤日誌檔案
3. 聯絡 InfinityFree 客服（免費用戶有基本支援）

## 🔒 安全建議

1. **修改預設密碼**: 立即更改管理員密碼
2. **定期備份**: 下載資料庫和檔案備份
3. **更新軟體**: 保持系統更新
4. **監控訪問**: 定期檢查訪問記錄
