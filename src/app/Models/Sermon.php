<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    protected $fillable = [
        'title', 'speaker', 'sermon_date', 'content', 'slug', 'video_url',
    ];
}
