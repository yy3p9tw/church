# 教會網站系統 (Church Website System)

## 📋 專案概述

這是一個使用原生 PHP 開發的教會網站管理系統，包含前台展示和後台管理功能。

## 🚀 功能特色

### 前台功能
- 🏠 首頁展示（教會介紹、服務項目）
- 📰 最新消息列表和詳細頁面
- 🎤 講道音頻播放和管理
- 👥 關於我們（同工團隊介紹）

### 後台管理
- 🔐 管理員登入系統
- 📊 管理儀表板
- 📝 最新消息管理（新增、編輯、刪除、圖片上傳）
- 🎵 講道管理（音頻上傳、講道資訊）
- 📅 活動管理
- 👨‍💼 同工管理（頭像上傳、個人資料）
- ⚙️ 系統設定

## 📁 目錄結構

```
church/
├── admin/                    # 後台管理系統
│   ├── auth.php             # 認證功能
│   ├── login.php            # 登入頁面
│   ├── index.php            # 管理儀表板
│   ├── news.php             # 消息管理
│   ├── sermons.php          # 講道管理
│   ├── events.php           # 活動管理
│   ├── staff.php            # 同工管理
│   └── settings.php         # 系統設定
├── config/                  # 配置檔案
│   ├── database.php         # 資料庫連接
│   └── upload.php           # 檔案上傳處理
├── includes/                # 公共頁面組件
│   ├── header.php           # 頁首
│   └── footer.php           # 頁尾
├── public/                  # 靜態資源和上傳檔案
│   ├── css/                 # 樣式檔案
│   ├── js/                  # JavaScript 檔案
│   ├── images/              # 圖片資源
│   ├── uploads/             # 上傳檔案目錄
│   │   ├── news/            # 消息圖片
│   │   ├── sermons/         # 講道音頻
│   │   ├── staff/           # 同工頭像
│   │   └── events/          # 活動圖片
│   └── storage/             # 其他儲存檔案
├── database/                # 資料庫檔案
├── index.php                # 前台首頁
├── about.php                # 關於我們頁面
├── news.php                 # 消息列表頁面
├── sermons.php              # 講道列表頁面
├── church_db.sql            # 資料庫結構檔案
└── README.md                # 專案說明
```

## 🛠️ 安裝與設定

### 系統需求
- PHP 8.0+
- MySQL 5.7+ 或 SQLite 3.0+
- Web 伺服器（Apache/Nginx）或 PHP 內建伺服器

### 本地開發環境設定

1. **克隆專案**
   ```bash
   git clone https://github.com/yy3p9tw/church.git
   cd church
   ```

2. **設定資料庫**
   
   **方案A：使用 MySQL**
   - 建立資料庫 `church_db`
   - 匯入 `church_db.sql` 檔案
   - 修改 `config/database.php` 中的連接設定

   **方案B：使用 SQLite（推薦）**
   - 系統會自動在 `database/` 目錄建立 SQLite 檔案
   - 無需額外設定

3. **設定環境變數（可選）**
   ```php
   // 在 config/database.php 中設定
   $_ENV['DB_HOST'] = 'localhost';
   $_ENV['DB_NAME'] = 'church_db';
   $_ENV['DB_USER'] = 'your_username';
   $_ENV['DB_PASS'] = 'your_password';
   ```

4. **啟動開發伺服器**
   ```bash
   php -S localhost:8000
   ```

5. **存取網站**
   - 前台：http://localhost:8000
   - 後台：http://localhost:8000/admin/login.php

### 預設管理員帳號
- **Email**: admin@church.com
- **密碼**: admin123

## 🔧 配置說明

### 檔案上傳設定
- 圖片檔案：最大 5MB，支援 JPG, PNG, GIF, WebP
- 音頻檔案：最大 50MB，支援 MP3, WAV, M4A
- 上傳目錄：`public/uploads/`

### 資料庫配置
系統支援 MySQL 和 SQLite 兩種資料庫：
- 優先嘗試連接 MySQL
- 如果 MySQL 連接失敗，自動使用 SQLite
- SQLite 檔案位置：`database/church.sqlite`

## 🌐 部署到生產環境

### 免費主機部署選項

1. **InfinityFree**
   - 支援 PHP 和 MySQL
   - 無廣告
   - 上傳所有檔案到 `htdocs` 目錄

2. **000webhost**
   - 支援 PHP 和 MySQL
   - 免費 SSL
   - 上傳到 `public_html` 目錄

3. **Koyeb（推薦）**
   - 支援 Docker 部署
   - 全球 CDN
   - 自動 HTTPS

### 部署步驟

1. **準備檔案**
   ```bash
   # 壓縮專案檔案（排除不必要的檔案）
   zip -r church-website.zip . -x "*.git*" "*.md" "database/*.sqlite"
   ```

2. **上傳到主機**
   - 將所有檔案上傳到主機的網站根目錄
   - 確保 `public/uploads/` 目錄有寫入權限

3. **設定資料庫**
   - 建立 MySQL 資料庫
   - 匯入 `church_db.sql`
   - 更新 `config/database.php` 中的連接資訊

4. **設定權限**
   ```bash
   chmod 755 public/uploads/
   chmod 755 database/
   ```

## 🔐 安全性注意事項

1. **更改預設密碼**
   - 登入後台後立即更改管理員密碼

2. **檔案權限**
   - 確保上傳目錄有適當的權限設定
   - 禁止執行上傳檔案中的腳本

3. **資料庫安全**
   - 使用強密碼
   - 限制資料庫存取權限

## 🎨 自訂化

### 修改樣式
- 主要樣式檔案：`public/css/`
- 使用 Bootstrap 5 框架
- 可以在各頁面的 `<style>` 區塊中添加自訂樣式

### 新增功能
- 後台管理頁面位於 `admin/` 目錄
- 前台頁面直接在根目錄
- 資料庫操作使用 `config/database.php` 中的方法

## 🐛 故障排除

### 常見問題

1. **資料庫連接失敗**
   - 檢查 `config/database.php` 中的設定
   - 確認資料庫服務是否啟動
   - 檢查使用者權限

2. **檔案上傳失敗**
   - 檢查 `public/uploads/` 目錄權限
   - 確認 PHP 上傳設定（upload_max_filesize, post_max_size）
   - 檢查磁碟空間

3. **頁面顯示錯誤**
   - 檢查 PHP 錯誤日誌
   - 確認所有必要的檔案都已上傳
   - 檢查檔案路徑設定

## 📞 技術支援

如有問題或建議，請聯絡：
- GitHub Issues: https://github.com/yy3p9tw/church/issues
- Email: support@church.com

## 📄 授權

此專案採用 MIT 授權條款。

---

© 2024 Church Website System. Made with ❤️ for churches.
