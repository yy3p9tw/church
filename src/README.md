# 教會網站專案

本專案為 XAMPP（PHP+MySQL）環境下的 Laravel 12 教會網站，依據規格書分工與目錄結構設計。

## 目錄結構（摘要）

- app/Http/Controllers/         # 控制器（Front, Admin, API）
- app/Models/                   # Eloquent 資料模型
- database/migrations/          # 資料表 migration 檔案
- database/seeders/             # 初始資料 seeder
- resources/views/layouts/      # 主版型、前台、後台
- resources/views/front/        # 前台分頁
- resources/views/admin/        # 後台分頁
- resources/views/components/   # 共用元件
- public/images/                # 上傳圖片
- public/media/                 # 上傳影音
- public/css/                   # 前端樣式
- public/js/                    # 前端腳本
- routes/web.php                # 前後台路由
- routes/api.php                # API 路由
- .env.example                  # 環境設定範例

## 開發環境
- PHP 8.2（XAMPP）
- MySQL 8.x（XAMPP）
- Laravel 12.x

## 安裝步驟
1. 複製 .env.example 為 .env 並設定資料庫連線
2. composer install
3. php artisan migrate
4. php artisan serve

## 參考規格書
- 規格書請見專案根目錄 spec-*.md
