<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'news_date', 'publish_date', 'image_url', 'status', 'created_by',
    ];
}
