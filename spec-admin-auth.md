# 後台認證與權限規格書

## 1. 認證機制
- Laravel Breeze 基礎認證
- 登入/登出流程、表單驗證、錯誤提示
- 登入失敗鎖定（5次錯誤鎖定30分鐘）
- Session 時效（2小時無操作自動登出）
- 2FA 多重要素認證（選用）

## 2. 權限分級
- Spatie Laravel Permission 套件
- 角色：超級管理員、內容管理員、編輯者
- 權限：CRUD、敏感資料刪除、批次操作

## 3. 安全機制
- 重要操作二次確認
- 操作記錄審計日誌
- 密碼政策（長度、複雜度、歷史、定期更新）

## 4. API設計與 migration 範例

### 4.1. 認證/權限 API 路由
| 功能         | Method | 路徑                  | 參數/Body                | 回應格式/備註           |
|--------------|--------|-----------------------|--------------------------|-------------------------|
| 登入         | POST   | /admin/login          | email, password          | JSON，失敗有錯誤訊息    |
| 登出         | POST   | /admin/logout         | 無                      | JSON，登出成功          |
| 取得用戶     | GET    | /admin/users          | ?search, ?role           | JSON，分頁              |
| 角色分配     | POST   | /admin/users/{id}/role| role                     | JSON，權限驗證          |
| 權限查詢     | GET    | /admin/permissions    | 無                      | JSON，權限列表          |

### 4.2. API回應格式
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "王小明",
    "role": "admin"
  },
  "message": "登入成功"
}
```

### 4.3. Migration範例（roles/permissions）
```php
Schema::create('roles', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name')->unique();
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('permissions', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name')->unique();
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('model_has_roles', function (Blueprint $table) {
    $table->unsignedBigInteger('role_id');
    $table->unsignedBigInteger('model_id');
    $table->string('model_type');
    $table->index(['role_id', 'model_id', 'model_type']);
});

Schema::create('model_has_permissions', function (Blueprint $table) {
    $table->unsignedBigInteger('permission_id');
    $table->unsignedBigInteger('model_id');
    $table->string('model_type');
    $table->index(['permission_id', 'model_id', 'model_type']);
});
```

## 5. 驗收標準
- 權限控制準確、無越權存取、流程順暢
