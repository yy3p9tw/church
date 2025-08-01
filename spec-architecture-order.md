# 教會網站規格書製作順序與串聯規範

## 1. 規格書製作順序建議

1. 架構總覽（spec-architecture.md）
   - 明確技術選型、目錄結構、開發流程、分工原則
2. 資料庫設計（spec-database.md）
   - 定義所有資料表、索引、外鍵、migration 範例
3. 媒體/檔案管理（spec-media.md）
   - 上傳、儲存、API、migration、檔案限制
4. 前台規格（spec-frontend.md）
   - 主版型、分頁結構、互動元件、RWD、SEO
5. 前台搜尋/篩選（spec-frontend-search.md）
   - 全站搜尋、進階篩選、API、migration
6. SEO/效能（spec-frontend-seo.md）
   - Meta、OG、Sitemap、效能優化、API
7. 講道頁面（spec-sermon.md）
   - 講道列表/單篇、API、migration
8. 後台管理（spec-admin.md）
   - 儀表板、資源管理、系統設定、監控
9. 後台認證/權限（spec-admin-auth.md）
   - 登入/登出、角色分級、API、migration
10. 後台儀表板（spec-admin-dashboard.md）
    - 統計、日誌、API、migration
11. 後台資源管理（spec-admin-resource.md）
    - 講道/消息/活動/小組 CRUD、API、migration
12. 後台系統設定（spec-admin-settings.md）
    - 設定管理、API、migration
13. 後台監控（spec-admin-monitor.md）
    - 健檢、備份、錯誤日誌、API、migration
14. 完整原始規格書（church-website-spec.md）
    - 歷史紀錄、全域參考

## 2. 串聯規範
- 每份規格書皆有 API 路由、回應格式、migration 範例
- 先完成架構/資料庫，後續各模組規格書依據資料表/API設計
- 前台/後台規格書需明確對應資料庫欄位、API路由
- 所有 migration/元件/路由命名與目錄結構一致
- 每份規格書完成後，須回填至 README 或專案 Wiki 串聯

## 3. 驗收標準
- 規格書順序合理、內容完整、相互串聯
- 各模組規格書皆可獨立開發/測試
- 專案目錄、API、migration、元件命名與規格書一致

---

## 製作進度紀錄

  - 2025/07/23 已於 d:\church\src 成功建立 Laravel 12 專案骨架（composer create-project laravel/laravel src）。
  - 已自動執行 migration，預設 users、cache、jobs 資料表已建立。
  - API 已支援 ?q= 關鍵字搜尋、?page= 分頁、?sort= 排序等進階查詢參數，方便前後台串接與資料篩選。
  - 2025/07/23 開始進行 API 驗證/權限（JWT、middleware、角色分級）模組開發，將依 spec-admin-auth.md、規格書順序細緻實作，並同步紀錄每個步驟（如：middleware 建立、User migration 欄位補全、登入/登出 API、角色權限驗證等）。
  - 已補全 users 資料表 migration 欄位（role、status、phone、avatar、last_login_at），並成功執行 migrate:fresh --seed，資料表結構已支援權限分級。
  - 已建立 AuthApiController、api_auth.php 路由，安裝 tymon/jwt-auth 並完成 JWT 初始化，API 登入/登出/驗證功能骨架完成。
  - 已建立 RoleMiddleware，並於 bootstrap/app.php 註冊 'role' middleware，API 路由可進行角色權限驗證。
  - 已於 api_auth.php 路由示範角色權限驗證（role:admin），API 可針對不同角色進行存取控制。
  - 已建立 SermonAdminController，新增後台講道 CRUD 路由與 Blade 頁面骨架，完成後台講道管理基本功能。
  - 已建立 NewsAdminController，新增後台消息 CRUD 路由與 Blade 頁面骨架，完成後台消息管理基本功能。
  - 已建立 EventAdminController，新增後台活動 CRUD 路由與 Blade 頁面骨架，完成後台活動管理基本功能。
  - 已建立 SmallGroupAdminController，新增後台小組 CRUD 路由與 Blade 頁面骨架，完成後台小組管理基本功能。
  - 已建立 DashboardController 及後台儀表板頁面，顯示四大主模組統計數量。
  - 已建立 SettingsController 及後台系統設定頁面，完成系統設定管理介面骨架。
  - 已建立 MonitorController 及後台監控頁面，完成系統健檢、備份、錯誤日誌管理介面骨架。
  - 所有後台主要模組（儀表板、資源管理、系統設定、監控）已完成骨架與基本功能，API/權限/CRUD/統計/健檢等皆已串接，專案主流程全數實作。
  - 後續可進行 API/前後台整合測試、文件補全、進階權限、日誌、備份、SEO、效能優化等延伸開發。
  - 已建立 resources/views/layouts、front、admin、components 及 public/images、media、css、js 等目錄。
  - 已建立 Front/HomeController、Admin/DashboardController。
  - 已建立 Sermon、News、Event、SmallGroup 模型及對應 migration。
  - 已補全四張表 migration 欄位，並成功執行 migration，建立所有核心資料表。
  - 已補充 web.php，註冊前台首頁、講道、消息、活動、小組等分頁路由，並指向對應 Controller。
  - 已建立 Blade 主版型（layouts/front.blade.php）與共用元件（components/card、search、pagination）。
  - 已建立首頁 view（front/home.blade.php），可顯示最新講道與消息。
  - 已補充 HomeController 首頁 index 方法，會帶入最新講道與消息資料。
  - 已建立講道列表（front/sermons.blade.php）、單篇（front/sermon_show.blade.php）view 與 Controller 方法，支援分頁與搜尋。
  - 已建立消息列表（front/news.blade.php）、單篇（front/news_show.blade.php）view 與 Controller 方法，支援分頁與搜尋。
  - 已完成 news_show.blade.php 消息單篇分頁，統一顯示格式，支援標題、日期、內容、圖片、返回列表。
  - 已建立活動列表（front/events.blade.php）、單篇（front/event_show.blade.php）view 與 Controller 方法，支援分頁與搜尋。
  - 已完成 event_show.blade.php 活動單篇分頁，統一顯示格式，支援標題、時間、地點、內容、圖片、返回列表。
  - 已建立小組列表（front/groups.blade.php）、單篇（front/group_show.blade.php）view 與 Controller 方法，支援分頁與搜尋，並修正 Controller 結構。
  - 已完成 group_show.blade.php 小組單篇分頁，統一顯示格式，支援標題、類型、聯絡人、描述、圖片、返回列表。
  - 前台主要分頁骨架已完成，後續可進行資料填充、API、後台等模組。
  - 已建立 SermonSeeder、NewsSeeder、EventSeeder、SmallGroupSeeder，並註冊於 DatabaseSeeder，完成四大資料表資料填充基礎。
  - 已完成 sermons、news、events、groups 四大主模組 API 路由與 Controller 建立，支援 GET 列表/單篇查詢與標準回應格式。
  - API 已支援 ?q= 關鍵字搜尋、?page= 分頁、?sort= 排序等進階查詢參數，方便前後台串接與資料篩選。
- 後續每完成一個步驟，將於本區塊細緻紀錄（如：目錄結構建立、migration 完成、API 實作、Blade 元件產生等）。
