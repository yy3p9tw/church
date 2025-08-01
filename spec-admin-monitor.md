# 後台系統監控規格書

## 1. 系統健檢
- 資料庫連線、檔案系統權限、第三方服務連線、磁碟空間

## 2. 備份管理
- 資料庫自動備份（每日）、檔案系統備份（每週）
- 備份檔案完整性驗證、一鍵還原

## 3. 錯誤處理
- 全域錯誤捕獲與記錄、錯誤通知（Email/Slack）
- 友善錯誤頁面、調試模式

## 4. API設計與 migration 範例

### 4.1. 系統監控 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 系統健檢     | GET    | /admin/health-check   | 無                      | JSON，各項狀態          |
| 備份管理     | GET    | /admin/backups        | 無                      | JSON，備份列表          |
| 錯誤日誌     | GET    | /admin/error-logs     | ?date                   | JSON，分頁              |

### 4.2. API回應格式
```json
{
  "success": true,
  "data": {
    "db_status": "OK",
    "disk_usage": "2.3GB",
    "last_backup": "2025-07-20 23:00"
  },
  "message": "系統健檢結果"
}
```

### 4.3. Migration範例（backups表）
```php
Schema::create('backups', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('filename');
    $table->timestamp('created_at')->nullable();
    $table->boolean('is_valid')->default(true);
});
```
