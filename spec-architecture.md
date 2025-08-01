
# 教會網站架構總覽（最終版）

## 1. 技術選型
- 後端：PHP 8.2（Laravel 12）
- 前端：Bootstrap 5、Blade、jQuery、RWD、SEO
- 資料庫：MySQL（XAMPP 開發環境）
- API：RESTful，支援 JWT 驗證、分頁、搜尋、排序
- 工具：Composer、Artisan、VS Code、PowerShell、Git
- 部署：XAMPP（開發）、Nginx/Apache（正式）

## 2. 目錄結構
```
church/
  src/
    app/
      Http/Controllers/Front/    # 前台 Controller
      Http/Controllers/Admin/    # 後台 Controller
      Http/Controllers/Api/      # API Controller
      Models/                    # Eloquent 模型
    database/
      migrations/                # migration
      seeders/                   # Seeder
    resources/
      views/front/               # 前台分頁
      views/admin/               # 後台分頁
      views/layouts/             # 主版型
      views/components/          # 共用元件
    routes/
      web.php                    # 前台/後台路由
      api.php                    # API 路由
      api_auth.php               # API 驗證路由
    public/
      images/ media/ css/ js/    # 靜態資源
    config/                      # 系統設定
    storage/                     # 檔案、快取、log
    tests/                       # 測試
    spec-*.md                    # 規格書分冊
    README.md                    # 專案說明
```

## 3. 開發流程與分工
1. 依 `spec-architecture-order.md` 規格書順序建立 migration、Seeder、Model、Controller、View
2. 先完成資料庫結構與資料填充（見 spec-database.md）
3. 前台分頁、API、後台 CRUD 依序開發，API 支援查詢參數、JWT 驗證、權限分級
4. 每步驟於 `spec-architecture-order.md` 詳細紀錄，並同步補充各分冊規格書
5. 分工原則：
   - 架構/資料庫/主流程：主程式設計師
   - 前台/後台分頁、UI/UX：前端工程師
   - API、權限、驗證、資料填充：後端工程師
   - 文件、測試、優化：全體協作

## 4. 命名與串聯規範
- 資料夾、檔案、API、migration、元件命名皆與規格書一致
- 前台：front/，後台：admin/，共用：components/
- migration/seeder：database/migrations, database/seeders
- 各分冊規格書獨立、可串聯，內容相互參照，完成即回填至 README 串聯
- 完整原始規格書（church-website-spec.md）僅供全域參考

## 5. 驗收標準
- 目錄結構清晰、分工明確、易於擴充
- 各分冊規格書內容完整、可獨立開發/測試
- 專案命名、API、migration、元件皆與規格書一致

## 6. 版面配置與共用元件
- 主版型（Header、Footer、RWD、導覽選單）
- 前台/後台版型繼承、麵包屑、專用 CSS/JS
- 共用元件：components/card、search、pagination 等

## 7. 行動裝置與無障礙設計
- 響應式設計（Bootstrap 5）
- PWA 支援（可擴充）
- WCAG 2.1 合規、輔助技術

## 8. 第三方整合
- Google Analytics、Maps、reCAPTCHA
- Facebook/YouTube/Instagram 整合
- Email/Newsletter 系統

## 9. 開發時程規劃
- 依週次分工，明確產出物與驗收重點
- 每階段完成即於 `spec-architecture-order.md` 詳細紀錄

## 10. CRUD 操作細緻化規範
- 表單驗證（前後端皆需）
- API 標準格式（狀態碼、訊息、資料）
- 權限認證（middleware、JWT、角色分級）
- 刪除安全（軟刪除、權限驗證）
- 錯誤處理（例外、回應格式統一）
- 資料庫約束（唯一、外鍵、not null）
- 防呆（輸入檢查、XSS/SQLi 防護）
- API/功能自動化測試

---

本文件將隨專案進度同步補充，確保架構、命名、流程與規格書一致。
