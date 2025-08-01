# 教會網站專案目錄結構規格書

## 1. 專案根目錄
```
church/
├── app/                  # Laravel 應用程式主目錄
│   ├── Http/Controllers/ # 控制器（Front, Admin, API）
│   ├── Models/           # Eloquent 資料模型
│   ├── Policies/         # 權限政策
│   └── ...
├── database/
│   ├── migrations/       # 資料表 migration 檔案
│   ├── seeders/          # 初始資料 seeder
│   └── factories/        # 測試資料 factory
├── resources/
│   ├── views/            # Blade 前端模板
│   │   ├── layouts/      # 主版型、前台、後台
│   │   ├── front/        # 前台分頁（首頁、講道、消息、活動、小組、聯絡）
│   │   ├── admin/        # 後台分頁（儀表板、資源管理、設定、監控）
│   │   └── components/   # 共用元件（卡片、表單、搜尋、SEO）
│   └── lang/             # 語系檔
├── public/
│   ├── images/           # 上傳圖片
│   ├── media/            # 上傳影音
│   ├── css/              # 前端樣式
│   ├── js/               # 前端腳本
│   └── ...
├── routes/
│   ├── web.php           # 前後台路由
│   ├── api.php           # API 路由
│   └── ...
├── config/               # 系統設定（SEO、社群、SMTP、權限）
├── storage/              # 檔案、快取、log
├── tests/                # PHPUnit 測試
├── .env                  # 環境設定
├── composer.json         # Laravel 相依套件
├── package.json          # 前端相依套件
└── README.md             # 專案說明
```

## 2. 規格書與設計文件
```
church/
├── spec-architecture.md      # 架構總覽
├── spec-frontend.md          # 前台規格
├── spec-frontend-search.md   # 前台搜尋/篩選
├── spec-frontend-seo.md      # SEO/效能
├── spec-sermon.md            # 講道頁面
├── spec-admin.md             # 後台管理
├── spec-admin-auth.md        # 後台認證/權限
├── spec-admin-dashboard.md   # 後台儀表板
├── spec-admin-resource.md    # 後台資源管理
├── spec-admin-settings.md    # 後台系統設定
├── spec-admin-monitor.md     # 後台監控
├── spec-media.md             # 媒體/檔案管理
├── spec-database.md          # 資料庫設計
└── church-website-spec.md    # 完整規格書（原始）
```

## 3. 資料夾命名原則
- 前台：front/
- 後台：admin/
- 共用：components/
- 規格書：spec-*.md
- 上傳檔案：public/images, public/media
- migration/seeder：database/migrations, database/seeders

## 4. 建議開發流程
- 先依規格書建立目錄結構
- 各模組/分頁獨立資料夾，便於維護
- 所有 API、migration、元件對應規格書

## 5. 驗收標準
- 目錄結構清晰、分工明確、易於擴充
- 所有檔案/資料夾命名與規格書一致
