# 教會網站專案規格書 (v5.0)

## 1. 專案概述

### 1.1. 使用者故事 (User Stories)

*   **作為一名首次到訪的慕道友：** 我希望網站能給我一個溫暖且清晰的第一印象，讓我在幾分鐘內就能了解教會的風格、核心信念以及最重要的聚會時間，並感受到自己是受歡迎的。
*   **作為一名教會會友：** 我希望能方便地找到本週的講道影片進行回顧，查詢小組的聚會資訊，並透過活動月曆了解教會接下來的動態。
*   **作為一名網站內容管理員：** 我希望能有一個簡單直觀的後台，讓我可以快速發布最新的消息、上傳講道影片連結、以及新增教會的活動，而不需要複雜的操作。

### 1.2. 專案目標 (Project Goals)

本專案旨在為教會建立一個**以人為本、引人入勝**的現代化官方網站。它不僅是一個資訊發布平台，更是一個傳達教會異象、連結會友、並歡迎新朋友的數位門戶。

### 1.3. 設計哲學 (Design Philosophy) - Inspired by im-church.org

- **現代簡約風格:** 介面將採用大面積留白、清晰的區塊劃分和簡潔的排版，創造專業、乾淨的視覺感受。
- **高對比度與品牌色:** 將以深色或淺色為基底，搭配教會的品牌色（例如：亮黃、溫暖的藍色），創造強烈視覺對比，讓資訊和行動呼籲 (Call to Action) 更突出。
- **專業視覺元素:** 強調使用高品質、真實的教會生活照片與影片，傳達溫暖與活力。
- **友善的互動與動畫:** 加入細緻、不干擾的過場動畫與互動效果，提升網站的精緻感與使用者體驗。

### 1.4. 技術選型 (Technical Specifications)

#### 1.4.1. 後端 (Backend)

- **框架:** PHP Laravel
  - **選擇理由:** Laravel 是一個表達力強、語法優雅的 PHP Web 應用程式框架。它提供了豐富的功能，如 ORM (Eloquent)、路由、認證、隊列、排程等，能大幅加速開發流程。其 MVC (Model-View-Controller) 架構有助於代碼組織，並提供強大的社群支持和完善的文件，適合構建穩健且可擴展的 Web 應用程式。
- **語言:** PHP
  - **選擇理由:** PHP 是一種廣泛用於 Web 開發的伺服器端腳本語言，擁有龐大的生態系統和成熟的部署環境。與 Laravel 結合，能高效地處理業務邏輯和資料庫互動。

#### 1.4.2. 前端 (Frontend)

- **CSS 框架:** Bootstrap
  - **選擇理由:** Bootstrap 是最流行的前端開源工具包之一，提供了大量預先設計好的 HTML、CSS 和 JavaScript 組件，能快速構建響應式、行動優先的網站。它能確保網站介面在不同裝置上的一致性，並加速 UI 開發。
- **JavaScript 函式庫:** jQuery
  - **選擇理由:** jQuery 是一個快速、小型且功能豐富的 JavaScript 函式庫。它簡化了 HTML 文件遍歷、事件處理、動畫和 Ajax 互動等操作，能有效提升前端開發效率，特別是在處理 DOM 操作和簡單互動時。
- **原生 JavaScript (JS):**
  - **選擇理由:** 對於更複雜或客製化的前端邏輯，將直接使用原生 JavaScript 進行開發，以確保最佳效能和靈活性。

#### 1.4.3. 資料庫 (Database)

- **類型:** MySQL / MariaDB
  - **選擇理由:** MySQL 和 MariaDB 是成熟、穩定且廣泛使用的關聯式資料庫管理系統。它們擁有強大的資料完整性、可靠性和豐富的功能集，適合儲存結構化資料。對於教會網站的內容管理需求（如講道、消息、活動等），關聯式資料庫能提供良好的支援和查詢效能。

#### 1.4.4. 其他工具與策略

- **版本控制 (Version Control):** Git
  - **策略:** 使用 Git 進行版本控制，並配合 GitHub/GitLab 等平台進行協同開發。採用 Feature Branch Workflow，確保開發流程清晰、可追溯。
- **部署策略 (Deployment Strategy):**
  - **Laravel 應用:** 考慮使用 Nginx/Apache 配合 PHP-FPM 部署在 VPS (Virtual Private Server) 上。確保伺服器環境滿足 Laravel 的運行要求。
- **測試策略 (Testing Strategy):}
  - **Laravel:** 利用 Laravel 內建的測試工具 (PHPUnit) 進行單元測試和功能測試，確保後端邏輯的正確性。
  - **前端:** 針對關鍵的 JavaScript 互動功能進行手動測試，確保使用者介面行為符合預期。


## 2. 功能需求詳述（細緻化）

### 2.0. 版面配置與共用元件 (Layout & Components)

#### L-1: 主版型 (Master Layout)
**目標：** 提供一致的頁面結構與導覽體驗。
**細節：**
- Header：Logo、主導覽選單（首頁、關於我們、講道、消息、活動、小組、聯絡）、登入按鈕
- Footer：版權資訊、快速連結、社群媒體連結、聯絡資訊
- RWD 斷點：手機 (<768px)、平板 (768-1024px)、桌機 (>1024px)
- 導覽選單：桌機水平選單、手機漢堡選單
**驗收標準：**
- 各裝置導覽功能正常，視覺一致
- Logo 點擊回首頁，選單項目正確導向

#### L-2: 前台版型 (Front Layout)
**目標：** 前台頁面專用版型，強調視覺美感。
**細節：**
- 繼承主版型，額外載入前台專用 CSS/JS
- 支援 Hero 區塊、Banner 區塊
- 麵包屑導覽（除首頁外）
**驗收標準：**
- 前台頁面風格一致，載入速度佳

#### L-3: 後台版型 (Admin Layout)  
**目標：** 後台管理專用版型，強調功能性。
**細節：**
- 側邊選單：講道管理、消息管理、活動管理、小組管理、系統設定
- 頂部工具列：用戶名稱、登出按鈕
- 麵包屑與頁面標題
**驗收標準：**
- 管理功能易於找到，操作流程順暢

#### F-1: 首頁 (Homepage)
**目標：** 讓新朋友快速認識教會、會友能即時掌握最新資訊。
**技術實作：**
- Controller: FrontHomeController
- 資料來源：Sermon::latest()->first(), Event::upcoming()->limit(3)->get()
- 最新講道：顯示最新一筆講道（講題、講員、日期、影片縮圖），點擊進入單篇。
- 聚會資訊：卡片式列出主日崇拜、禱告會、兒童主日學（含時間、地點、簡介、icon）。
- 近期活動：橫向滑動卡片，顯示 2-3 個即將到來活動（標題、時間、地點、報名連結）。
**使用者互動：**
- 關鍵 CSS 內聯
**驗收標準：**
- 路由: Route::view('/newcomers', 'front.newcomers')
- FAQ 使用 Bootstrap Accordion 組件
**細節：**
- 所有互動元件支援觸控操作

#### F-8: 聯絡我們 (Contact Us)
- 表單處理：Laravel Form Request 驗證
- Email 發送：Laravel Mail + Queue
- 防機器人：Google reCAPTCHA v3
**細節：**
- Google Map 嵌入，支援自訂 marker 與資訊視窗。
**資料處理：**
- 表單資料儲存至 contacts 資料表
- 敏感資料加密儲存
- Email 發送失敗時記錄並重試
**驗收標準：**
- 表單送出有成功訊息，資料驗證正確。
### 2.1.1. 檔案上傳與媒體管理 (File Upload & Media)
#### FM-1: 圖片上傳系統
**目標：** 支援教會活動照片、團隊照片、文章圖片上傳。
**技術實作：**
- 儲存位置：storage/app/public/images/
- 支援格式：JPG, PNG, WebP (< 5MB)
- 圖片處理：Laravel Intervention Image
**功能細節：**
- 自動產生縮圖 (thumbnail: 300x200, medium: 800x600)
- 圖片壓縮與最佳化
- Alt text 與 caption 支援
- 批次上傳與拖拽功能
**安全考量：**
- 檔案類型驗證
- 病毒掃描整合
- 檔名隨機化防止路徑遍歷

#### FM-2: 影音檔案管理
**目標：** 管理講道錄音檔與宣傳影片。
**技術實作：**
- 本地檔案：storage/app/public/media/
- 外部連結：YouTube, Vimeo 嵌入
- 音訊格式：MP3, AAC (< 100MB)
**功能細節：**
- 音訊播放器 (HTML5 Audio)
- 播放進度記憶
- 下載權限控制
- CDN 整合 (選用)

### 2.1.2. 搜尋與篩選系統 (Search & Filter)

#### SF-1: 全站搜尋
**目標：** 提供跨內容類型的統一搜尋體驗。
**技術實作：**
- Laravel Scout + Algolia (或 MySQL 全文搜尋)
- 搜尋範圍：講道標題/內容、消息、活動、小組
**功能細節：**
- 自動完成建議
- 搜尋結果高亮
- 搜尋歷史記錄
- 熱門搜尋關鍵字
**效能優化：**
- 搜尋結果快取 (5分鐘)
- 分頁載入 (每頁 10 筆)
- 非同步搜尋 API

#### SF-2: 進階篩選
**目標：** 提供精確的內容篩選功能。
**講道篩選：**
- 講員、日期範圍、經文、主題分類
- 媒體類型 (影片/音訊)
**活動篩選：**
- 日期範圍、地點、活動類型
- 報名狀態 (開放/已滿/已結束)
**小組篩選：**
- 類型、地區、聚會時間
- 年齡層、語言

### 2.1.3. SEO 與效能優化 (SEO & Performance)

#### SEO-1: 搜尋引擎最佳化
**Meta Tags:**
- 動態 title、description、keywords
- Open Graph tags (Facebook)
- Twitter Card tags
- JSON-LD 結構化資料
**URL 結構:**
- 語意化 URL (/sermons/2024/01/sermon-title)
- 301 重新導向管理
- Sitemap.xml 自動生成
**內容最佳化:**
- 圖片 Alt tags
- 標題階層 (H1-H6)
- 內部連結策略

#### PERF-1: 效能最佳化
**前端效能:**
- CSS/JS 壓縮與合併
- 圖片 lazy loading
- Critical CSS 內聯
- Service Worker 快取
**後端效能:**
- Query 最佳化與 Eager Loading
- Redis 快取系統
- 資料庫索引優化
- API Response 快取
**監控指標:**
- Core Web Vitals 監控
- 載入時間 < 3 秒
- Time to Interactive < 5 秒


### 2.2. 後台管理功能 (Backend Admin)（細緻化）

#### B-0: 後台儀表板 (Dashboard)
**目標：** 提供管理員系統概覽與快速操作。
**技術實作：**
- Controller: Admin\DashboardController
- 即時統計：講道總數、本月活動、未讀聯絡表單
**功能細節：**
- 統計圖表：Chart.js 顯示月度數據
- 快速操作：新增講道、發布消息、回覆聯絡
- 系統狀態：儲存空間、資料庫大小、最新備份時間
- 近期活動日誌：管理員操作記錄
**權限控制：**
- 僅登入管理員可存取
- 依角色顯示不同功能模組

#### B-1: 安全認證與權限管理
**目標：** 確保後台僅授權人員可操作，並實現角色分級管理。
**技術實作：**
- Laravel Breeze 基礎認證
- Spatie Laravel Permission 套件
- 多重要素認證 (2FA) 選用
**角色定義：**
- 超級管理員：完整系統權限
- 內容管理員：內容 CRUD，無法刪除敏感資料
- 編輯者：僅能編輯指派的內容
**安全機制：**
- 登入失敗鎖定 (5次錯誤鎖定30分鐘)
- Session 時效控制 (2小時無操作自動登出)
- 重要操作二次確認 (刪除、批次操作)
- 操作記錄審計日誌
**密碼政策：**
- 最少8字符，包含大小寫、數字、特殊字符
- 密碼歷史檢查 (不得重複使用最近5組密碼)
- 定期強制更新密碼 (90天)
**細節：**
- 登入頁：支援 Email/密碼，表單驗證（必填、格式），登入失敗有錯誤提示。
- 登出功能：明顯按鈕，點擊後自動跳回登入頁。
- 所有 /admin 路徑皆需登入後才能存取，未登入自動導向登入頁。
**驗收標準：**
- 未登入者無法進入後台任一頁。
- 登入/登出流程順暢，錯誤訊息友善。
- 2FA 驗證流程順暢 (如啟用)
- 權限控制準確，無越權存取

#### B-2: 講道管理 (Enhanced)
**目標：** 管理所有講道影音資料，支援批次操作與進階功能。
**技術實作：**
- Controller: Admin\SermonController
- Request: SermonRequest (Form Validation)
- Policy: SermonPolicy (權限控制)
**功能增強：**
- 批次上傳：支援 Excel/CSV 匯入講道清單
- 標籤系統：自訂標籤分類 (主題系列、節期)
- 排程發布：設定未來發布時間
- 統計分析：觀看次數、下載次數追蹤
**媒體整合：**
- YouTube API 自動抓取影片資訊
- 音訊檔案波形圖產生
- 字幕檔上傳與管理 (.srt, .vtt)
**內容編輯器：**
- 富文本編輯器 (TinyMCE/CKEditor)
- 經文引用快速插入
- 圖片拖拽上傳
**細節：**
- 列表頁：分頁、可依講員/日期搜尋，顯示標題、講員、日期、操作按鈕。
- 新增/編輯頁：表單欄位（標題、講員、日期、經文、影音連結、內容），欄位驗證。
- 刪除：需二次確認。
**驗收標準：**
- 新增、編輯、刪除皆有成功/失敗提示。
- 表單驗證正確，欄位說明清楚。
- 批次操作功能正常，無資料遺失
- 媒體檔案同步正確

#### B-6: 系統設定管理
**目標：** 管理網站基本設定與系統參數。
**技術實作：**
- Settings 資料表儲存 key-value 配對
- Laravel Config 動態載入
**設定類別：**
- 基本資訊：教會名稱、地址、聯絡電話、Email
- SEO 設定：預設 meta title/description、GA tracking ID
- 社群媒體：Facebook、Instagram、YouTube 連結
- 系統參數：分頁筆數、檔案上傳限制、快取時效
**進階設定：**
- SMTP 郵件設定
- 第三方 API 金鑰管理
- 備份排程設定
- 錯誤通知設定

#### B-7: 系統監控與維護
**目標：** 確保系統穩定運行，提供問題診斷工具。
**系統健檢：**
- 資料庫連線狀態
- 檔案系統讀寫權限
- 第三方服務連線測試
- 磁碟空間使用量
**備份管理：**
- 資料庫自動備份 (每日)
- 檔案系統備份 (每週)
- 備份檔案完整性驗證
- 一鍵還原功能
**錯誤處理：**
- 全域錯誤捕獲與記錄
- 錯誤通知 (Email/Slack)
- 使用者友善錯誤頁面
- 調試模式控制

### 2.3. 第三方整合 (Third-party Integrations)

#### TI-1: Google Services
**Google Analytics 4:**
- 頁面瀏覽追蹤
- 事件追蹤 (影片播放、檔案下載、表單提交)
- 轉換目標設定
**Google Maps API:**
- 教會位置標示
- 路線規劃功能
- 自訂地圖樣式
**Google reCAPTCHA v3:**
- 表單機器人防護
- 無感驗證體驗
- 風險評分調整

#### TI-2: 社群媒體整合
**Facebook 整合:**
- 粉絲專頁嵌入
- 活動同步發布
- 社群登入 (選用)
**YouTube 整合:**
- 頻道影片自動同步
- 播放清單管理
- 觀看統計
**Instagram 整合:**
- 最新貼文展示
- 照片牆功能

#### TI-3: Email 服務
**SendGrid/Mailgun 整合:**
- 大量郵件發送
- 開信率統計
- 退信處理
**Newsletter 系統:**
- 訂閱者管理
- 電子報範本
- 發送排程
- A/B 測試

### 2.4. 行動裝置最佳化 (Mobile Optimization)

#### MO-1: 響應式設計
**設計原則:**
- Mobile-First 設計方法
- 觸控友善的互動元素 (最小 44px)
- 適當的字體大小 (最小 16px)
**效能最佳化:**
- 圖片適應性載入
- 觸控延遲最小化
- 垂直滑動優化

#### MO-2: PWA 功能 (Progressive Web App)
**基礎 PWA:**
- Service Worker 離線快取
- Web App Manifest
- 安裝提示
**推播通知:**
- 最新講道發布通知
- 活動提醒
- 訂閱者同意機制

### 2.5. 無障礙設計 (Accessibility)

#### AC-1: WCAG 2.1 合規
**視覺無障礙:**
- 色彩對比度 4.5:1 (AA 級)
- 支援放大至 200% 不失功能
- 圖片替代文字
**操作無障礙:**
- 鍵盤導航支援
- 焦點指示器清晰
- 跳到主要內容連結
**聽覺無障礙:**
- 影片字幕支援
- 音訊文字轉錄

#### AC-2: 輔助技術支援
**螢幕報讀器:**
- ARIA 標籤正確使用
- 語意化 HTML 結構
- 表單標籤關聯
**語音控制:**
- 語音命令支援
- 文字轉語音整合


## 3. API 規格 (API Specification)（細緻化）

> Laravel 採 RESTful 路由，所有 /admin/* 皆需認證。

| 功能         | Method | 路徑                  | 參數/Body/Query                        | 回應格式/驗證/備註                   |
|--------------|--------|-----------------------|----------------------------------------|--------------------------------------|
| **認證**     |        |                       |                                        |                                      |
| 登入         | POST   | /login                | email, password                        | 302 redirect 或 JSON，失敗有錯誤訊息 |
| 登出         | POST   | /logout               | 無                                     | 302 redirect                         |
| **講道**     |        |                       |                                        |                                      |
| 取得講道列表 | GET    | /sermons              | ?search=, ?limit=, ?latest=            | JSON/Blade，支援分頁                 |
| 取得單篇講道 | GET    | /sermons/{id}         | path: id                               | JSON/Blade，404 找不到               |
| 新增講道     | POST   | /admin/sermons        | title, speaker, sermon_date, ...       | 驗證必填，成功 201/redirect           |
| 更新講道     | PUT    | /admin/sermons/{id}   | path: id, body 同上                    | 驗證必填，成功 200/redirect           |
| 刪除講道     | DELETE | /admin/sermons/{id}   | path: id                               | 成功 204/redirect                    |
| **消息**     |        |                       |                                        |                                      |
| 取得消息列表 | GET    | /news                 | ?limit=                                | JSON/Blade，支援分頁                 |
| 取得單則消息 | GET    | /news/{id}            | path: id                               | JSON/Blade，404 找不到               |
| 新增消息     | POST   | /admin/news           | title, content, publish_date           | 驗證必填，成功 201/redirect           |
| 更新消息     | PUT    | /admin/news/{id}      | path: id, body 同上                    | 驗證必填，成功 200/redirect           |
| 刪除消息     | DELETE | /admin/news/{id}      | path: id                               | 成功 204/redirect                    |
| **活動**     |        |                       |                                        |                                      |
| 取得活動列表 | GET    | /events               | ?month=, ?upcoming=                    | JSON/Blade，支援分頁                 |
| 取得單一活動 | GET    | /events/{id}          | path: id                               | JSON/Blade，404 找不到               |
| 新增活動     | POST   | /admin/events         | title, start_time, ...                 | 驗證必填，成功 201/redirect           |
| 更新活動     | PUT    | /admin/events/{id}    | path: id, body 同上                    | 驗證必填，成功 200/redirect           |
| 刪除活動     | DELETE | /admin/events/{id}    | path: id                               | 成功 204/redirect                    |
| **小組**     |        |                       |                                        |                                      |
| 取得小組列表 | GET    | /groups               | ?type=                                 | JSON/Blade，支援分頁                 |
| 取得單一小組 | GET    | /groups/{id}          | path: id                               | JSON/Blade，404 找不到               |
| 新增小組     | POST   | /admin/groups         | name, type, description, ...           | 驗證必填，成功 201/redirect           |
| 更新小組     | PUT    | /admin/groups/{id}    | path: id, body 同上                    | 驗證必填，成功 200/redirect           |
| 刪除小組     | DELETE | /admin/groups/{id}    | path: id                               | 成功 204/redirect                    |
| **聯絡**     |        |                       |                                        |                                      |
| 提交聯絡表單 | POST   | /contact              | name, email, phone, subject, message  | 驗證必填，reCAPTCHA，成功顯示訊息    |
| 訂閱電子報   | POST   | /newsletter/subscribe | email, name                            | 驗證 Email 格式，防重複訂閱          |

### 3.1. 表單驗證規則詳述

#### 講道表單驗證
```php
'title' => 'required|string|max:255',
'speaker' => 'required|string|max:255', 
'sermon_date' => 'required|date|before_or_equal:today',
'scripture' => 'nullable|string|max:500',
'video_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be|vimeo\.com)/',
'audio_url' => 'nullable|url',
'content' => 'nullable|string',
'tags' => 'nullable|array',
'tags.*' => 'string|max:50'
```

#### 活動表單驗證
```php
'title' => 'required|string|max:255',
'start_time' => 'required|date|after:now',
'end_time' => 'nullable|date|after:start_time',
'location' => 'nullable|string|max:255',
'description' => 'nullable|string',
'max_participants' => 'nullable|integer|min:1',
'registration_deadline' => 'nullable|date|before:start_time'
```

#### 聯絡表單驗證
```php
'name' => 'required|string|min:2|max:100',
'email' => 'required|email:rfc,dns',
'phone' => 'nullable|regex:/^[\+]?[\d\s\-\(\)]{10,15}$/',
'subject' => 'required|string|max:200',
'message' => 'required|string|min:10|max:2000',
'g-recaptcha-response' => 'required|recaptcha'
```

### 3.2. API 回應格式標準

#### 成功回應格式
```json
{
    "success": true,
    "data": {...},
    "message": "操作成功",
    "meta": {
        "current_page": 1,
        "total": 50,
        "per_page": 10
    }
}
```

#### 錯誤回應格式
```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "表單驗證失敗",
        "details": {
            "title": ["標題為必填欄位"],
            "email": ["Email 格式不正確"]
        }
    }
}
```

### 3.3. 檔案上傳 API

#### 圖片上傳
| 功能         | Method | 路徑                  | 參數                               | 回應                               |
|--------------|--------|-----------------------|------------------------------------|-----------------------------------|
| 上傳圖片     | POST   | /api/upload/image     | image (file), alt_text, category   | 圖片 URL、檔案資訊                 |
| 批次上傳     | POST   | /api/upload/images    | images[] (files), category         | 圖片 URL 陣列                     |
| 刪除圖片     | DELETE | /api/upload/image/{id}| 無                                | 刪除確認                          |

#### 檔案限制
- 圖片：JPG, PNG, WebP, 最大 5MB
- 音訊：MP3, AAC, 最大 100MB  
- 影片：MP4, 最大 500MB (建議使用外部平台)
- 檔案總數限制：單次批次上傳最多 10 個檔案


## 4. 資料庫設計 (Database Schema)（細緻化）

### 4.1. 核心資料表

### users
| 欄位             | 型別                | 說明/驗證/索引           |
|------------------|---------------------|--------------------------|
| id               | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| name             | VARCHAR(255)        | 必填，使用者名稱         |
| email            | VARCHAR(255) UNIQUE | 必填，唯一，登入帳號     |
| email_verified_at| TIMESTAMP NULLABLE  | Email 驗證時間           |
| password         | VARCHAR(255)        | 必填，雜湊密碼           |
| role             | ENUM('admin','editor','viewer') | 使用者角色 |
| last_login_at    | TIMESTAMP NULLABLE  | 最後登入時間             |
| login_attempts   | TINYINT DEFAULT 0   | 登入失敗次數             |
| locked_until     | TIMESTAMP NULLABLE  | 帳號鎖定到期時間          |
| two_factor_secret| VARCHAR(255) NULL   | 2FA 密鑰                |
| remember_token   | VARCHAR(100) NULL   | Breeze 用                |
| created_at       | TIMESTAMP NULL      |                          |
| updated_at       | TIMESTAMP NULL      |                          |

### sermons
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| title        | VARCHAR(255)        | 必填，講道標題           |
| slug         | VARCHAR(255) UNIQUE | SEO 友善 URL             |
| speaker      | VARCHAR(255)        | 必填，講員               |
| sermon_date  | DATE                | 必填，講道日期，加索引    |
| scripture    | VARCHAR(255) NULL   | 經文                     |
| video_url    | VARCHAR(255) NULL   | 影片連結                 |
| audio_url    | VARCHAR(255) NULL   | 音訊連結                 |
| content      | TEXT NULL           | 內容                     |
| excerpt      | TEXT NULL           | 摘要，前台列表使用        |
| featured_image| VARCHAR(255) NULL  | 特色圖片路徑             |
| view_count   | INT DEFAULT 0       | 觀看次數                 |
| download_count| INT DEFAULT 0      | 下載次數                 |
| is_featured  | BOOLEAN DEFAULT 0   | 是否精選                 |
| status       | ENUM('draft','published','archived') | 發布狀態 |
| published_at | TIMESTAMP NULL      | 發布時間                 |
| meta_title   | VARCHAR(255) NULL   | SEO 標題                |
| meta_description| VARCHAR(320) NULL | SEO 描述                |
| created_by   | BIGINT UNSIGNED     | 建立者 ID，外鍵 users.id |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### news
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| title        | VARCHAR(255)        | 必填，消息標題           |
| slug         | VARCHAR(255) UNIQUE | SEO 友善 URL             |
| content      | TEXT                | 必填，內容               |
| excerpt      | TEXT NULL           | 摘要                     |
| featured_image| VARCHAR(255) NULL  | 特色圖片路徑             |
| publish_date | DATE                | 必填，發佈日期，加索引    |
| is_pinned    | BOOLEAN DEFAULT 0   | 是否置頂                 |
| view_count   | INT DEFAULT 0       | 觀看次數                 |
| status       | ENUM('draft','published','archived') | 發布狀態 |
| meta_title   | VARCHAR(255) NULL   | SEO 標題                |
| meta_description| VARCHAR(320) NULL | SEO 描述                |
| created_by   | BIGINT UNSIGNED     | 建立者 ID，外鍵 users.id |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### events
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| title        | VARCHAR(255)        | 必填，活動標題           |
| slug         | VARCHAR(255) UNIQUE | SEO 友善 URL             |
| description  | TEXT NULL           | 活動說明                 |
| start_time   | DATETIME            | 必填，開始時間，加索引    |
| end_time     | DATETIME NULL       | 結束時間                 |
| location     | VARCHAR(255) NULL   | 地點                     |
| address      | TEXT NULL           | 詳細地址                 |
| max_participants| INT NULL         | 參與人數上限             |
| current_participants| INT DEFAULT 0 | 當前報名人數           |
| registration_deadline| DATETIME NULL | 報名截止時間           |
| featured_image| VARCHAR(255) NULL  | 特色圖片路徑             |
| is_featured  | BOOLEAN DEFAULT 0   | 是否精選                 |
| status       | ENUM('draft','published','cancelled','completed') | 活動狀態 |
| registration_required| BOOLEAN DEFAULT 0 | 是否需要報名         |
| meta_title   | VARCHAR(255) NULL   | SEO 標題                |
| meta_description| VARCHAR(320) NULL | SEO 描述                |
| created_by   | BIGINT UNSIGNED     | 建立者 ID，外鍵 users.id |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### small_groups
| 欄位           | 型別                | 說明/驗證/索引           |
|----------------|---------------------|--------------------------|
| id             | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| name           | VARCHAR(255)        | 必填，小組名稱           |
| slug           | VARCHAR(255) UNIQUE | SEO 友善 URL             |
| type           | VARCHAR(50)         | 必填，類型（社青/夫妻等），加索引|
| description    | TEXT                | 必填，簡介               |
| meeting_time   | VARCHAR(255) NULL   | 聚會時間                 |
| meeting_location| VARCHAR(255) NULL  | 聚會地點                 |
| contact_person | VARCHAR(255) NULL   | 聯絡人                   |
| contact_phone  | VARCHAR(20) NULL    | 聯絡電話                 |
| contact_email  | VARCHAR(255) NULL   | 聯絡 Email               |
| max_members    | INT NULL            | 人數上限                 |
| current_members| INT DEFAULT 0       | 當前成員數               |
| age_range      | VARCHAR(50) NULL    | 年齡層                   |
| language       | VARCHAR(50) NULL    | 使用語言                 |
| is_active      | BOOLEAN DEFAULT 1   | 是否活躍                 |
| featured_image | VARCHAR(255) NULL   | 特色圖片路徑             |
| created_by     | BIGINT UNSIGNED     | 建立者 ID，外鍵 users.id |
| created_at     | TIMESTAMP NULL      |                          |
| updated_at     | TIMESTAMP NULL      |                          |

### 4.2. 支援功能資料表

### contacts
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| name         | VARCHAR(255)        | 必填，聯絡人姓名         |
| email        | VARCHAR(255)        | 必填，Email              |
| phone        | VARCHAR(20) NULL    | 電話                     |
| subject      | VARCHAR(255)        | 必填，主旨               |
| message      | TEXT                | 必填，訊息內容           |
| ip_address   | VARCHAR(45)         | 來源 IP                  |
| user_agent   | VARCHAR(500) NULL   | 瀏覽器資訊               |
| status       | ENUM('new','read','replied','spam') | 處理狀態 |
| replied_at   | TIMESTAMP NULL      | 回覆時間                 |
| replied_by   | BIGINT UNSIGNED NULL| 回覆者 ID，外鍵 users.id |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### tags
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| name         | VARCHAR(100) UNIQUE | 標籤名稱                 |
| slug         | VARCHAR(100) UNIQUE | URL 友善格式             |
| color        | VARCHAR(7) NULL     | 顯示顏色 (HEX)           |
| description  | TEXT NULL           | 描述                     |
| type         | ENUM('sermon','news','event','general') | 標籤類型 |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### taggables (多型關聯)
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| tag_id       | BIGINT UNSIGNED     | 標籤 ID，外鍵 tags.id    |
| taggable_id  | BIGINT UNSIGNED     | 被標記項目 ID            |
| taggable_type| VARCHAR(255)        | 被標記項目類型           |
| created_at   | TIMESTAMP NULL      |                          |

### media_files
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| filename     | VARCHAR(255)        | 原檔名                   |
| path         | VARCHAR(500)        | 檔案路徑                 |
| mime_type    | VARCHAR(100)        | MIME 類型                |
| size         | BIGINT              | 檔案大小 (bytes)         |
| alt_text     | VARCHAR(255) NULL   | 替代文字                 |
| caption      | VARCHAR(500) NULL   | 圖片說明                 |
| mediable_id  | BIGINT UNSIGNED NULL| 關聯項目 ID              |
| mediable_type| VARCHAR(255) NULL   | 關聯項目類型             |
| uploaded_by  | BIGINT UNSIGNED     | 上傳者 ID，外鍵 users.id |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### settings
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| key          | VARCHAR(255) UNIQUE | 設定鍵值                 |
| value        | TEXT NULL           | 設定值                   |
| type         | ENUM('string','integer','boolean','json') | 資料類型 |
| group        | VARCHAR(100)        | 設定群組                 |
| description  | VARCHAR(500) NULL   | 描述                     |
| created_at   | TIMESTAMP NULL      |                          |
| updated_at   | TIMESTAMP NULL      |                          |

### activity_logs
| 欄位         | 型別                | 說明/驗證/索引           |
|--------------|---------------------|--------------------------|
| id           | BIGINT UNSIGNED PK  | 主鍵，自動遞增           |
| user_id      | BIGINT UNSIGNED NULL| 操作者 ID，外鍵 users.id |
| action       | VARCHAR(100)        | 操作動作                 |
| subject_type | VARCHAR(255) NULL   | 操作對象類型             |
| subject_id   | BIGINT UNSIGNED NULL| 操作對象 ID              |
| properties   | JSON NULL           | 操作詳細資料             |
| ip_address   | VARCHAR(45) NULL    | 來源 IP                  |
| user_agent   | VARCHAR(500) NULL   | 瀏覽器資訊               |
| created_at   | TIMESTAMP NULL      |                          |

### 4.3. 索引策略

```sql
-- 效能優化索引
CREATE INDEX idx_sermons_date_status ON sermons(sermon_date, status);
CREATE INDEX idx_news_publish_pinned ON news(publish_date, is_pinned);
CREATE INDEX idx_events_start_status ON events(start_time, status);
CREATE INDEX idx_contacts_status_created ON contacts(status, created_at);
CREATE INDEX idx_activity_logs_user_created ON activity_logs(user_id, created_at);

-- 全文搜尋索引 (MySQL 8.0+)
CREATE FULLTEXT INDEX ft_sermons_search ON sermons(title, content);
CREATE FULLTEXT INDEX ft_news_search ON news(title, content);
CREATE FULLTEXT INDEX ft_events_search ON events(title, description);
```

### 4.4. 資料庫約束與觸發器

```sql
-- 外鍵約束
ALTER TABLE sermons ADD CONSTRAINT fk_sermons_user 
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL;

-- 觸發器：自動更新計數
DELIMITER $$
CREATE TRIGGER update_group_member_count 
    AFTER INSERT ON group_members
    FOR EACH ROW
BEGIN
    UPDATE small_groups 
    SET current_members = (
        SELECT COUNT(*) FROM group_members 
        WHERE group_id = NEW.group_id
    ) WHERE id = NEW.group_id;
END$$
DELIMITER ;
```


## 5. 開發時程規劃 (Milestones)（細緻化）

### 第一週：Laravel 基礎與認證
- 目標：專案初始化、資料庫連線、認證 scaffold。
- 產出物：專案結構、.env 設定、users migration、Breeze 認證。
- 驗收重點：可註冊/登入/登出，資料表正確。

### 第二週：後端核心功能
- 目標：四大資源 Model、Migration、CRUD Controller、Seeder。
- 產出物：sermons/news/events/small_groups migration、model、factory、seeder、controller。
- 驗收重點：CRUD API/後台功能皆可用，資料驗證正確。

### 第三週：前端基礎與版面
- 目標：前端框架、主版型、靜態頁。
- 產出物：Bootstrap、jQuery、主視覺、header/footer、首頁/關於/聯絡頁。
- 驗收重點：RWD、UI/UX、靜態頁內容完整。

### 第四週：前端動態內容與後台介面

## 6. CRUD操作細緻化規範（必須遵守）

### 6.1. 表單驗證
- 所有欄位依規格書設計驗證規則（如 required、max、date、enum、url 格式等），不可省略。
- 例如：講道的 sermon_date 必須是今天以前，活動的 start_time 必須是未來時間。

### 6.2. API回應格式
- 成功：`{"success": true, "data": {...}, "message": "操作成功", "meta": {...}}`
- 失敗：`{"success": false, "error": {"code": "VALIDATION_ERROR", "message": "表單驗證失敗", "details": {...}}}`
- 錯誤細節需明確顯示欄位錯誤（如 Laravel validation errors）。

### 6.3. 權限與認證
- 所有 /admin/* 路徑必須登入且有權限（如 Spatie Permission）。
- 編輯、刪除時必須檢查是否有操作權限（Policy）。

### 6.4. 刪除操作安全
- 後台刪除需二次確認（前端跳出確認視窗，後端防止誤刪）。
- 建議使用 soft delete 或二次確認。

### 6.5. 錯誤處理
- 表單驗證失敗即時顯示錯誤訊息。
- 伺服器錯誤（如資料庫連線失敗）要有友善提示。
- 刪除/更新不存在的資源時，回傳 404。

### 6.6. 資料庫約束
- 外鍵、唯一值（如 slug）必須設好，避免重複或遺失資料。
- 刪除時要處理關聯（如 SET NULL 或 CASCADE）。

### 6.7. 前端表單防呆
- 必填欄位、格式提示、即時驗證。
- 送出後按鈕禁用，避免重複送出。

### 6.8. API測試
- 每個 CRUD API 都要用 Postman 或自動化測試（PHPUnit）測試各種情境（成功、失敗、權限不足、資料不存在）。

---
---


