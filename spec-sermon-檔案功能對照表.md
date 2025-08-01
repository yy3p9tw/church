# 講道系統檔案功能對照表（詳細說明）

---

## 1. 路由與 API
| 檔案/資料夾 | 功能說明 |
|---|---|
| `routes/web.php` | 定義前台講道頁面（列表、單篇、搜尋、標籤、講員/日期篩選等）所有網址路由。 |
| `routes/api.php` | 定義 RESTful API 路由（/api/sermons），支援列表、單篇、CRUD、批次匯入等。 |

## 2. Model 與 Migration
| 檔案/資料夾 | 功能說明 |
|---|---|
| `app/Models/Sermon.php` | 講道主資料表 Model，定義欄位、關聯（如 media_files, tags, users）、scope（搜尋、篩選）等。 |
| `database/migrations/xxxx_xx_xx_create_sermons.php` | 建立 sermons 資料表，欄位包含標題、講員、日期、經文、影音、摘要、精選、狀態、SEO、統計等。 |
| `database/seeders/SermonSeeder.php` | 產生假資料，方便開發測試。 |

## 3. 控制器
| 檔案/資料夾 | 功能說明 |
|---|---|
| `app/Http/Controllers/Front/SermonController.php` | 前台講道頁面控制器，負責：
- 講道列表（分頁、搜尋、標籤、講員/日期篩選）
- 單篇講道顯示
- SEO meta tag 設定
- 相關講道推薦
- 播放器/媒體整合
|
| `app/Http/Controllers/Admin/SermonController.php` | 後台講道管理控制器，負責：
- 新增/編輯/刪除/批次匯入
- 欄位驗證、權限檢查、二次確認
- 媒體整合（YouTube、音訊、字幕）
- 統計分析（觀看/下載次數）
|

## 4. Blade 視圖與元件
| 檔案/資料夾 | 功能說明 |
|---|---|
| `resources/views/front/sermons.blade.php` | 前台講道列表頁，顯示分頁、搜尋、標籤、講員/日期篩選、摘要、精選、觀看/下載次數。 |
| `resources/views/front/sermon_show.blade.php` | 前台單篇講道頁，顯示標題、講員、日期、經文、內容、影音/音訊播放器、標籤、分享、相關推薦、字幕。 |
| `resources/views/admin/sermons/index.blade.php` | 後台講道管理列表，支援搜尋、分頁、批次匯入、狀態切換、統計。 |
| `resources/views/admin/sermons/edit.blade.php` | 後台講道編輯頁，支援欄位驗證、媒體上傳、富文本、圖片拖拽、字幕管理。 |
| `resources/views/components/sermon-card.blade.php` | 講道卡片元件，顯示標題、講員、日期、摘要、精選狀態、觀看/下載次數。 |
| `resources/views/components/sermon-player.blade.php` | 影音/音訊播放器元件，支援 YouTube、MP3、字幕檔。 |
| `resources/views/components/sermon-tags.blade.php` | 標籤顯示元件，支援多標籤、點擊搜尋。 |
| `resources/views/components/sermon-import.blade.php` | 批次匯入上傳元件，支援 Excel/CSV 檔案上傳、匯入結果顯示。 |

## 5. 前端互動
| 檔案/資料夾 | 功能說明 |
|---|---|
| `resources/js/sermon.js` | 前端互動腳本，負責播放器控制、標籤點擊、匯入進度、字幕顯示等。 |

## 6. 測試
| 檔案/資料夾 | 功能說明 |
|---|---|
| `tests/navigation.spec.ts` | 前台講道頁面與導航自動化測試，驗證列表、單篇、導航連結、SEO。 |
| `tests/forms.spec.ts` | 表單驗證、搜尋、匯入等自動化測試。 |
| `tests/admin.spec.ts` | 後台講道管理功能自動化測試，驗證 CRUD、權限、驗證、媒體整合。 |
| `tests/performance.spec.ts` | 效能、SEO、資源載入等自動化測試。 |

---

如需補充其他檔案或細節，請再告知！
