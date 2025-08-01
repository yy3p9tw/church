# 後台資源管理規格書

## 1. 管理資源
- 講道、消息、活動、小組 CRUD
- 欄位驗證、分頁、搜尋、批次操作
- 媒體管理、標籤系統、排程發布

## 2. 表單驗證
- 依各資源欄位設計驗證規則
- 二次確認（刪除、批次）

## 3. 媒體與標籤
- 圖片/影音上傳、標籤分類、批次匯入

## 4. 權限政策
- 編輯/刪除需檢查操作權限（Policy）

## 5. API設計與 migration 範例

### 5.1. 資源管理 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 新增講道     | POST   | /admin/sermons        | title, speaker, ...      | JSON，驗證、權限        |
| 編輯講道     | PUT    | /admin/sermons/{id}   | 各欄位                   | JSON，驗證、權限        |
| 刪除講道     | DELETE | /admin/sermons/{id}   | 無                      | JSON，二次確認          |
| 新增消息     | POST   | /admin/news           | title, content, ...      | JSON，驗證、權限        |
| 新增活動     | POST   | /admin/events         | title, start_time, ...   | JSON，驗證、權限        |
| 新增小組     | POST   | /admin/groups         | name, type, ...          | JSON，驗證、權限        |

### 5.2. API回應格式
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "2025年主日講道",
    "speaker": "王牧師"
  },
  "message": "新增成功"
}
```

### 5.3. Migration範例（sermons表）
```php
Schema::create('sermons', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('title', 255);
    $table->string('slug', 255)->unique();
    $table->string('speaker', 255);
    $table->date('sermon_date')->index();
    $table->string('scripture', 255)->nullable();
    $table->string('video_url', 255)->nullable();
    $table->string('audio_url', 255)->nullable();
    $table->text('content')->nullable();
    $table->text('excerpt')->nullable();
    $table->string('featured_image', 255)->nullable();
    $table->integer('view_count')->default(0);
    $table->integer('download_count')->default(0);
    $table->boolean('is_featured')->default(false);
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->string('meta_title', 255)->nullable();
    $table->string('meta_description', 320)->nullable();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
});
```
