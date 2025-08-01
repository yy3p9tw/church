<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'start_time', 'end_time', 'location', 'content', 'image_url', 'status', 'created_by',
    ];
}
