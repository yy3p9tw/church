# 教會網站前台搜尋/篩選規格書（草稿）

## 1. 搜尋功能目標
- 全站統一搜尋（講道、消息、活動、小組）
- 進階篩選（講員、日期、分類、地點等）
- 自動完成、熱門關鍵字、搜尋歷史

## 2. API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 全站搜尋     | GET    | /api/search           | q, type, date, tag       | JSON，分頁、highlight   |
| 進階篩選     | GET    | /api/search/filter    | type, speaker, date, ... | JSON，分頁              |
| 熱門關鍵字   | GET    | /api/search/hot       | 無                       | JSON，陣列              |
| 搜尋歷史     | GET    | /api/search/history   | user_id                  | JSON，分頁              |

## 3. Blade/JS 元件設計
- components/search.blade.php：搜尋框、自動完成
- components/filter.blade.php：篩選器
- js/search.js：非同步搜尋、highlight、分頁

## 4. migration 範例（搜尋紀錄）
```php
Schema::create('search_histories', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('keyword');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->timestamps();
});
```

## 5. 回應格式
```json
{
  "success": true,
  "data": [
    {
      "type": "sermon",
      "id": 101,
      "title": "信心的力量",
      "excerpt": "...內容高亮...",
      "url": "/sermons/101"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 10
  }
}
```

## 6. 串聯規範
- 搜尋/篩選 API 串聯 sermons、news、events、small_groups
- Blade/JS 元件可重複用於各分頁
- migration、API、元件命名與規格書一致

## 7. 驗收標準
- 搜尋/篩選功能正常，回應格式正確
- 自動完成、熱門關鍵字、歷史紀錄皆可用
- API、元件、migration 可直接開發/測試

---

# 前台搜尋與篩選規格書

## 1. 全站搜尋
- 跨內容類型（講道、消息、活動、小組）
- Laravel Scout + Algolia 或 MySQL 全文搜尋
- 自動完成建議、結果高亮、搜尋歷史、熱門關鍵字
- 搜尋結果快取、分頁載入、非同步 API

## 2. 進階篩選
- 講道：講員、日期範圍、經文、主題分類、媒體類型
- 活動：日期範圍、地點、活動類型、報名狀態
- 小組：類型、地區、聚會時間、年齡層、語言

## 3. API設計範例

### 3.1. 搜尋 API 路由
| 功能         | Method | 路徑                | 參數/Query                | 回應格式/備註           |
|--------------|--------|---------------------|---------------------------|-------------------------|
| 全站搜尋     | GET    | /search             | ?q=關鍵字&type=sermon/news/event/group | JSON，分頁，結果高亮 |
| 進階篩選     | GET    | /search/filter      | type, 日期、講員、地點等   | JSON，分頁             |

### 3.2. API回應格式
```json
{
  "success": true,
  "data": [
    {
      "type": "sermon",
      "id": 123,
      "title": "講道標題",
      "excerpt": "內容摘要...",
      "speaker": "王牧師",
      "sermon_date": "2025-07-20",
      "tags": ["信心", "盼望"],
      "highlight": {
        "title": "<mark>信心</mark>的力量"
      }
    },
    // ...其他結果
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 10
  }
}
```

### 3.3. Migration範例（全文索引）
```php
Schema::table('sermons', function (Blueprint $table) {
    $table->fullText(['title', 'content']);
});

Schema::table('news', function (Blueprint $table) {
    $table->fullText(['title', 'content']);
});

Schema::table('events', function (Blueprint $table) {
    $table->fullText(['title', 'description']);
});
```

## 4. 驗收標準
- 搜尋/篩選功能完整、效能佳、互動流暢
