<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $fillable = [
        'title', 'image_url', 'publish_date',
    ];
}
