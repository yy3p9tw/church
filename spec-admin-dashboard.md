# 後台儀表板規格書

## 1. 功能概述
- 即時統計（講道總數、本月活動、未讀聯絡）
- 快速操作（新增講道、發布消息、回覆聯絡）
- 系統狀態顯示（儲存空間、資料庫大小、最新備份時間）
- 近期活動日誌（管理員操作記錄）

## 2. 權限控制
- 僅登入管理員可存取
- 依角色顯示不同功能模組

## 3. 視覺設計
- 圖表（Chart.js）、卡片式統計、操作按鈕

## 4. API設計與 migration 範例

### 4.1. 儀表板 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 統計數據     | GET    | /admin/dashboard      | 無                      | JSON，統計數據         |
| 活動日誌     | GET    | /admin/activity-logs  | ?date, ?user            | JSON，分頁              |
| 系統狀態     | GET    | /admin/system-status  | 無                      | JSON，空間/資料庫/備份 |

### 4.2. API回應格式
```json
{
  "success": true,
  "data": {
    "sermon_count": 120,
    "event_count": 8,
    "unread_contacts": 3,
    "storage_usage": "2.3GB",
    "db_size": "120MB",
    "last_backup": "2025-07-20 23:00"
  },
  "message": "儀表板統計資料"
}
```

### 4.3. Migration範例（activity_logs表）
```php
Schema::create('activity_logs', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('action', 100);
    $table->string('subject_type', 255)->nullable();
    $table->unsignedBigInteger('subject_id')->nullable();
    $table->json('properties')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->string('user_agent', 500)->nullable();
    $table->timestamp('created_at')->nullable();
});
```

## 5. 驗收標準
- 資料正確、操作流暢、權限分明
