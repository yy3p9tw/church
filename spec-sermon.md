# 講道頁面規格書（草稿）

## 1. 講道列表頁
- 分頁、搜尋、標籤、講員/日期篩選
- 顯示：標題、講員、日期、摘要、精選狀態
- 影音/音訊嵌入、觀看/下載次數
- SEO友善URL、Meta tags

## 2. 單篇講道頁
- 標題、講員、日期、經文、內容
- 影片/音訊播放器、特色圖片
- 標籤、分享按鈕、相關講道推薦
- 字幕檔上傳與管理

## 3. 後台講道管理
- 新增/編輯/刪除/批次匯入
- 欄位驗證、權限控制、二次確認
- 媒體整合（YouTube API、音訊波形、字幕）
- 富文本編輯器、圖片拖拽
- 統計分析（觀看/下載次數）

## 4. API規格
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 取得講道列表 | GET    | /api/sermons          | ?search, ?speaker, ?date | JSON，分頁              |
| 取得單篇講道 | GET    | /api/sermons/{id}     | path: id                 | JSON，404 找不到        |
| 新增講道     | POST   | /api/sermons          | title, speaker, ...      | 驗證必填，成功 201      |
| 更新講道     | PUT    | /api/sermons/{id}     | path: id, body           | 驗證必填，成功 200      |
| 刪除講道     | DELETE | /api/sermons/{id}     | path: id                 | 成功 204                |
| 批次匯入     | POST   | /api/sermons/import   | file (Excel/CSV)         | 匯入結果                |

## 5. migration 範例
```php
Schema::create('sermons', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('speaker');
    $table->date('sermon_date')->index();
    $table->string('scripture')->nullable();
    $table->string('video_url')->nullable();
    $table->string('audio_url')->nullable();
    $table->text('content')->nullable();
    $table->text('excerpt')->nullable();
    $table->string('featured_image')->nullable();
    $table->integer('view_count')->default(0);
    $table->integer('download_count')->default(0);
    $table->boolean('is_featured')->default(0);
    $table->enum('status', ['draft','published','archived'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->string('meta_title')->nullable();
    $table->string('meta_description', 320)->nullable();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
});
```

## 6. Blade 元件設計
- components/sermon-card.blade.php：講道卡片
- components/sermon-player.blade.php：影音/音訊播放器
- components/sermon-tags.blade.php：標籤
- components/sermon-import.blade.php：批次匯入

## 7. 串聯規範
- sermons 資料表串聯 media_files、tags、users
- API、migration、元件命名與規格書一致
- 可與搜尋、媒體、標籤、後台管理等模組串聯

## 8. 驗收標準
- 講道列表/單篇、後台管理、API、migration、元件皆可直接開發/測試
- 欄位驗證、權限、媒體整合、批次匯入功能完整

---

# 講道頁面規格書

## 1. 講道列表頁
- 分頁、搜尋、標籤、講員/日期篩選
- 顯示：標題、講員、日期、摘要、精選狀態
- 影音/音訊嵌入、觀看/下載次數
- SEO友善URL、Meta tags

## 2. 單篇講道頁
- 標題、講員、日期、經文、內容
- 影片/音訊播放器、特色圖片
- 標籤、分享按鈕、相關講道推薦
- 字幕檔上傳與管理

## 3. 後台講道管理
- 新增/編輯/刪除/批次匯入
- 欄位驗證、權限控制、二次確認
- 媒體整合（YouTube API、音訊波形、字幕）
- 富文本編輯器、圖片拖拽
- 統計分析（觀看/下載次數）

## 4. API規格
- RESTful CRUD、分頁、搜尋、標籤
- 驗證規則、回應格式
