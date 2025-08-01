<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('news')->insert([
            [
                'title' => '教會週報',
                'slug' => uniqid('news_'),
                'news_date' => Carbon::now()->toDateString(),
                'content' => '本週教會活動公告。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '下週特別聚會',
                'slug' => uniqid('news_'),
                'news_date' => Carbon::now()->addDays(7)->toDateString(),
                'content' => '下週將舉辦特別聚會，歡迎參加。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
