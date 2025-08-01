<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmallGroup extends Model
{
    protected $fillable = [
        'name', 'type', 'leader', 'description', 'contact_person', 'slug', // 根據資料表欄位可再補齊
    ];
}
