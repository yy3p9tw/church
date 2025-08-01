# 教會網站媒體/檔案管理規格書（草稿）

## 1. 媒體管理目標
- 支援圖片、音訊、影片等檔案上傳與管理
- 串聯 sermons、news、events、small_groups 等模組
- 提供 API、migration、元件範例

## 2. 資料表設計
### media_files
- id：主鍵
- filename：原檔名
- path：檔案路徑
- mime_type：MIME 類型
- size：檔案大小（bytes）
- alt_text：替代文字
- caption：圖片說明
- mediable_id：關聯項目 ID（多型）
- mediable_type：關聯項目類型（多型）
- uploaded_by：上傳者 ID
- created_at, updated_at

## 3. API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 上傳圖片     | POST   | /api/upload/image     | image, alt_text, caption | 圖片 URL、檔案資訊      |
| 批次上傳     | POST   | /api/upload/images    | images[], category       | 圖片 URL 陣列           |
| 刪除圖片     | DELETE | /api/upload/image/{id}| 無                       | 刪除確認                |
| 取得媒體     | GET    | /api/media            | ?type, ?search           | JSON，分頁              |

## 4. migration 範例
```php
Schema::create('media_files', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('filename', 255);
    $table->string('path', 500);
    $table->string('mime_type', 100);
    $table->bigInteger('size');
    $table->string('alt_text', 255)->nullable();
    $table->string('caption', 500)->nullable();
    $table->unsignedBigInteger('mediable_id')->nullable();
    $table->string('mediable_type', 255)->nullable();
    $table->unsignedBigInteger('uploaded_by')->nullable();
    $table->timestamps();
    $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
});
```

## 5. 檔案限制與安全
- 圖片：JPG, PNG, WebP，最大 5MB
- 音訊：MP3, AAC，最大 100MB
- 影片：MP4，最大 500MB（建議外部平台）
- 檔案類型驗證、檔名隨機化、防止路徑遍歷
- 病毒掃描、縮圖自動產生

## 6. 串聯規範
- media_files 可關聯 sermons、news、events、small_groups
- API、migration、元件命名與資料表一致
- 支援多型關聯、批次上傳、CDN 整合

## 7. 驗收標準
- migration 可直接執行，欄位、外鍵正確
- API 路由、元件可串聯各模組
- 檔案安全、格式限制、縮圖功能正常

---

# 媒體與檔案管理規格書

## 1. 圖片上傳
- 儲存位置：storage/app/public/images/
- 格式：JPG, PNG, WebP（<5MB）
- Laravel Intervention Image 處理
- 縮圖、壓縮、Alt/caption、批次/拖拽
- 類型驗證、病毒掃描、檔名隨機化

## 2. 影音檔案管理
- 儲存位置：storage/app/public/media/
- 外部連結：YouTube/Vimeo
- 音訊格式：MP3, AAC（<100MB）
- 音訊播放器、下載權限、CDN整合

## 3. API設計與 migration 範例

### 3.1. 媒體 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 上傳圖片     | POST   | /api/upload/image     | image, alt_text, category| JSON，檔案資訊         |
| 批次上傳     | POST   | /api/upload/images    | images[], category       | JSON，陣列             |
| 刪除圖片     | DELETE | /api/upload/image/{id}| 無                      | JSON，刪除確認         |
| 上傳影音     | POST   | /api/upload/media     | file, type, caption      | JSON，檔案資訊         |

### 3.2. API回應格式
```json
{
  "success": true,
  "data": {
    "id": 101,
    "url": "https://.../images/xxx.jpg",
    "alt_text": "活動照片",
    "caption": "2025年暑期營會"
  },
  "message": "檔案上傳成功"
}
```

### 3.3. Migration範例（media_files表）
```php
Schema::create('media_files', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('filename');
    $table->string('path', 500);
    $table->string('mime_type', 100);
    $table->bigInteger('size');
    $table->string('alt_text', 255)->nullable();
    $table->string('caption', 500)->nullable();
    $table->unsignedBigInteger('uploaded_by');
    $table->timestamps();
    $table->foreign('uploaded_by')->references('id')->on('users');
});
```
