# 教會網站資料庫設計

## 資料表一覽

### 1. users
- id (bigint, PK)
- name (string)
- email (string, unique)
- password (string)
- role (string) # 權限分級
- status (string)
- phone (string, nullable)
- avatar (string, nullable)
- last_login_at (datetime, nullable)
- created_at, updated_at

### 2. sermons
- id (bigint, PK)
- title (string)
- slug (string, unique)
- speaker (string)
- date (date)
- content (text)
- image (string, nullable)
- created_at, updated_at

### 3. news
- id (bigint, PK)
- title (string)
- slug (string, unique)
- date (date)
- content (text)
- image (string, nullable)
- created_at, updated_at

### 4. events
- id (bigint, PK)
- title (string)
- slug (string, unique)
- event_time (datetime)
- location (string)
- content (text)
- image (string, nullable)
- created_at, updated_at

### 5. small_groups
- id (bigint, PK)
- title (string)
- slug (string, unique)
- type (string)
- contact (string)
- description (text)
- image (string, nullable)
- created_at, updated_at

---

## migration 範例

```php
// database/migrations/2025_07_23_002334_create_sermons_table.php
Schema::create('sermons', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('speaker');
    $table->date('date');
    $table->text('content');
    $table->string('image')->nullable();
    $table->timestamps();
});
```

---

## 資料表關聯與索引
- 目前各主表獨立，未設外鍵。
- 可依需求於 sermons、news、events、small_groups 增加 user_id（建立者）等欄位。
- 所有 slug 欄位皆設唯一索引。

---

## 資料填充（Seeder）
- 已建立 SermonSeeder、NewsSeeder、EventSeeder、SmallGroupSeeder
- 可於 `DatabaseSeeder` 註冊批次執行

---

本文件將隨 migration、資料表結構調整同步補充。
# 教會網站資料庫設計規格書（草稿）

## 1. 資料庫技術選型
- MySQL 8.0+（支援全文搜尋、JSON 欄位、外鍵約束）
- Laravel Eloquent ORM 對應 migration

## 2. 核心資料表
- users：使用者（後台管理員、編輯者、會友）
- sermons：講道影音
- news：消息公告
- events：活動行事曆
- small_groups：小組資料

## 3. 支援功能資料表
- contacts：聯絡表單
- tags：標籤
- taggables：多型關聯
- media_files：媒體/檔案管理
- settings：系統設定
- activity_logs：操作日誌

## 4. 資料表欄位設計（摘要）
### users
- id, name, email, password, role, created_at, updated_at
### sermons
- id, title, slug, speaker, sermon_date, video_url, audio_url, content, status, created_by, created_at, updated_at
### news
- id, title, slug, content, publish_date, status, created_by, created_at, updated_at
### events
- id, title, slug, start_time, end_time, location, status, created_by, created_at, updated_at
### small_groups
- id, name, type, description, meeting_time, contact_person, is_active, created_by, created_at, updated_at
### contacts
- id, name, email, phone, subject, message, status, created_at, updated_at
### tags
- id, name, slug, type, created_at, updated_at
### taggables
- id, tag_id, taggable_id, taggable_type, created_at
### media_files
- id, filename, path, mime_type, size, alt_text, caption, uploaded_by, created_at, updated_at
### settings
- id, key, value, type, group, description, created_at, updated_at
### activity_logs
- id, user_id, action, subject_type, subject_id, properties, ip_address, user_agent, created_at

## 5. 索引與外鍵策略
- 關鍵欄位加索引（如 sermon_date, status, publish_date, user_id）
- 外鍵約束（如 sermons.created_by 參照 users.id）
- 多型關聯（taggables, media_files）
- 全文搜尋索引（sermons, news, events）

## 6. migration 範例（摘要）
```php
Schema::create('sermons', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('speaker');
    $table->date('sermon_date')->index();
    $table->string('video_url')->nullable();
    $table->string('audio_url')->nullable();
    $table->text('content')->nullable();
    $table->enum('status', ['draft','published','archived'])->default('draft');
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
});
```

## 7. 串聯規範
- 各模組規格書（sermons, news, events, small_groups 等）皆對應資料表
- API 路由、migration、元件命名與資料表一致
- 資料表設計可擴充，支援多語系、標籤、媒體關聯

## 8. 驗收標準
- migration 可直接執行，欄位、索引、外鍵正確
- 各分冊規格書皆明確對應資料表
- 資料表設計支援未來擴充

---

# 資料庫設計規格書

## 1. 核心資料表
- users、sermons、news、events、small_groups
- 欄位型別、驗證、索引、外鍵

## 2. 支援功能資料表
- contacts、tags、taggables、media_files、settings、activity_logs

## 3. 索引策略
- 效能優化索引、全文搜尋索引

## 4. 資料庫約束與觸發器
- 外鍵約束、SET NULL/CASCADE
- 觸發器範例（group_members自動計數）

## 5. API設計與 migration 範例

### 5.1. 資料表 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 取得用戶     | GET    | /api/users            | ?search, ?role           | JSON，分頁              |
| 取得講道     | GET    | /api/sermons          | ?search, ?date           | JSON，分頁              |
| 取得消息     | GET    | /api/news             | ?search, ?date           | JSON，分頁              |
| 取得活動     | GET    | /api/events           | ?search, ?date           | JSON，分頁              |
| 取得小組     | GET    | /api/groups           | ?type                    | JSON，分頁              |

### 5.2. API回應格式
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "王小明",
      "email": "test@church.org",
      "role": "admin"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 10
  }
}
```

### 5.3. Migration範例（users表）
```php
Schema::create('users', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name', 255);
    $table->string('email', 255)->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password', 255);
    $table->enum('role', ['admin','editor','viewer']);
    $table->timestamp('last_login_at')->nullable();
    $table->tinyInteger('login_attempts')->default(0);
    $table->timestamp('locked_until')->nullable();
    $table->string('two_factor_secret', 255)->nullable();
    $table->string('remember_token', 100)->nullable();
    $table->timestamps();
});
```
