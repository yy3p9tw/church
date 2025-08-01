<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SermonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sermons')->insert([
            [
                'title' => '信心的力量',
                'slug' => uniqid('sermon_'),
                'speaker' => '王牧師',
                'sermon_date' => Carbon::now()->subDays(7)->toDateString(),
                'content' => '這是一篇關於信心的講道內容。',
                'video_url' => null,
                'audio_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '愛的真諦',
                'slug' => uniqid('sermon_'),
                'speaker' => '李傳道',
                'sermon_date' => Carbon::now()->subDays(14)->toDateString(),
                'content' => '這是一篇關於愛的講道內容。',
                'video_url' => null,
                'audio_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
