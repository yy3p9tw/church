# 後台系統設定規格書

## 1. 設定類別
- 基本資訊（教會名稱、地址、聯絡電話、Email）
- SEO（meta title/description、GA tracking ID）
- 社群媒體（Facebook、Instagram、YouTube）
- 系統參數（分頁筆數、檔案上傳限制、快取時效）
- SMTP、API金鑰、備份排程、錯誤通知

## 2. 設定管理
- Settings 資料表 key-value 配對
- Laravel Config 動態載入

## 3. API設計與 migration 範例

### 3.1. 系統設定 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 取得設定     | GET    | /admin/settings       | ?group                   | JSON，分組              |
| 更新設定     | PUT    | /admin/settings/{id}  | key, value, ...          | JSON，權限              |

### 3.2. API回應格式
```json
{
  "success": true,
  "data": {
    "key": "site_name",
    "value": "教會網站",
    "group": "basic"
  },
  "message": "設定已更新"
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
