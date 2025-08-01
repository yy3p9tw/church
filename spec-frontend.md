# 教會網站前台規格書（草稿）

## 1. 前台主版型
- 統一 Header（Logo、主選單）、Footer（版權、社群連結）
- RWD 支援：手機、平板、桌機
- 麵包屑、Banner、Hero 區塊

## 2. 分頁結構
- 首頁（最新講道、活動、聚會資訊）
- 講道列表/單篇（sermons）
- 消息公告（news）
- 活動行事曆（events）
- 小組介紹（small_groups）
- 關於我們、聯絡我們

## 3. 互動元件
- 搜尋（全站/分頁）、進階篩選
- 表單（聯絡、報名、訂閱）
- 卡片、列表、分頁、輪播

## 4. SEO 與效能
- 動態 meta、OG、Sitemap
- 圖片 lazy loading、Critical CSS
- 友善 URL、Sitemap.xml

## 5. API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 取得首頁資料 | GET    | /api/front/home       | 無                       | JSON，最新講道/活動     |
| 取得講道     | GET    | /api/sermons          | ?search, ?date           | JSON，分頁              |
| 取得消息     | GET    | /api/news             | ?search, ?date           | JSON，分頁              |
| 取得活動     | GET    | /api/events           | ?search, ?date           | JSON，分頁              |
| 取得小組     | GET    | /api/groups           | ?type                    | JSON，分頁              |
| 聯絡表單送出 | POST   | /api/contact          | name, email, message     | JSON，驗證/成功訊息      |

## 6. Blade 元件設計
- layouts/front.blade.php：主版型
- components/card.blade.php：卡片元件
- components/search.blade.php：搜尋元件
- components/pagination.blade.php：分頁元件

## 7. migration 範例（搜尋紀錄）
```php
Schema::create('search_histories', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('keyword');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->timestamps();
});
```

## 8. 串聯規範
- API、Blade 元件、資料表命名與規格書一致
- 各分頁資料串聯 sermons、news、events、small_groups
- 搜尋、表單、卡片元件可重複使用

## 9. 驗收標準
- RWD、SEO、互動元件皆正常
- API、Blade 元件、資料表可直接開發
- 規格書內容可獨立測試/串聯

---

# 前台規格書

## 1. 首頁（Homepage）
- 最新講道區塊：標題、講員、日期、影片縮圖
- 聚會資訊卡片：主日崇拜、禱告會、兒童主日學
- 近期活動橫向滑動卡片
- FAQ（Bootstrap Accordion）
- Hero/Banner 區塊、麵包屑
- RWD、觸控支援、載入速度佳

## 2. 內容頁（講道、消息、活動、小組）
- 講道列表/單篇：分頁、搜尋、標籤、影音/音訊嵌入
- 消息列表/單則：分頁、置頂、SEO
- 活動列表/單一活動：報名、地圖、狀態
- 小組列表/單一小組：類型、地區、聚會時間

## 3. 聯絡我們
- 表單驗證、Google Map、reCAPTCHA
- 成功訊息、資料加密、Email發送

## 4. 搜尋與篩選
- 全站搜尋、進階篩選、熱門關鍵字

## 5. SEO與效能
- Meta tags、語意化URL、Sitemap、圖片Alt、Critical CSS
