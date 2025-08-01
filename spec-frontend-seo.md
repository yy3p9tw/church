# 教會網站 SEO 與效能優化規格書（草稿）

## 1. SEO 規範
- 動態 Meta Tags（title、description、keywords）
- Open Graph tags（Facebook 分享）
- Twitter Card tags
- JSON-LD 結構化資料（組織、文章、活動）
- 語意化 URL（如 /sermons/2025/07/信心的力量）
- Sitemap.xml、robots.txt
- Canonical 標籤、hreflang（多語系）

## 2. 效能優化
- 圖片 lazy loading、WebP 支援
- Critical CSS、延遲 JS 載入
- 靜態資源快取（Cache-Control、ETag）
- 分頁、API 載入效能
- 伺服器壓縮（Gzip/Brotli）、CDN 整合

## 3. API 路由設計
| 功能         | Method | 路徑                | 參數/Body         | 回應格式/備註           |
|--------------|--------|---------------------|-------------------|-------------------------|
| 產生 Sitemap | GET    | /sitemap.xml        | 無                | XML                     |
| 產生 robots  | GET    | /robots.txt         | 無                | 純文字                  |
| 取得 meta    | GET    | /api/meta           | type, id          | JSON，動態 meta         |

## 4. Blade/JS 元件設計
- layouts/partials/meta.blade.php：動態 meta、OG、Twitter、JSON-LD
- layouts/partials/sitemap.blade.php：自動產生 sitemap
- js/lazyload.js：圖片延遲載入

## 5. migration 範例（SEO 設定）
```php
Schema::create('settings', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('key', 100)->unique();
    $table->text('value')->nullable();
    $table->string('group', 100)->nullable();
    $table->string('description', 255)->nullable();
    $table->timestamps();
});
```

## 6. 串聯規範
- 所有前台分頁皆須呼叫 meta API 或 Blade 元件
- Sitemap、robots 自動更新，與內容同步
- SEO 設定可由後台管理

## 7. 驗收標準
- Google Search Console、PageSpeed Insights 通過
- 分享至 Facebook/Twitter 顯示正確
- Sitemap、robots、meta 皆自動產生、可維護

---

# SEO與效能優化規格書

## 1. SEO
- 動態 title、description、keywords
- Open Graph tags（Facebook）、Twitter Card tags、JSON-LD
- 語意化 URL、301 重新導向、Sitemap.xml
- 圖片 Alt tags、標題階層、內部連結策略

## 2. 效能優化
- 前端：CSS/JS 壓縮合併、圖片 lazy loading、Critical CSS、Service Worker
- 後端：Query最佳化、Eager Loading、Redis快取、API快取
- 監控：Core Web Vitals、載入時間、Time to Interactive

## 3. API設計與 migration 範例

### 3.1. SEO 設定 API 路由
| 功能         | Method | 路徑                | 參數/Body                | 回應格式/備註           |
|--------------|--------|---------------------|--------------------------|-------------------------|
| 取得SEO設定  | GET    | /api/settings/seo   | 無                      | JSON                    |
| 更新SEO設定  | PUT    | /api/settings/seo   | meta_title, meta_desc... | JSON，權限驗證         |

### 3.2. API回應格式
```json
{
  "success": true,
  "data": {
    "meta_title": "教會首頁",
    "meta_description": "...",
    "og_image": "https://.../og.jpg"
  },
  "message": "SEO 設定已更新"
}
```

### 3.3. Migration範例（settings表）
```php
Schema::create('settings', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->enum('type', ['string','integer','boolean','json']);
    $table->string('group', 100);
    $table->string('description', 500)->nullable();
    $table->timestamps();
});
```

## 4. 驗收標準
- SEO分數高、載入快、互動佳
