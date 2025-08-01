<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => '青年團契聚會',
                'slug' => uniqid('event_'),
                'start_time' => Carbon::now()->addDays(3)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(3)->addHours(2)->toDateTimeString(),
                'location' => '教會副堂',
                'content' => '青年團契每月聚會，歡迎參加。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '聖誕晚會',
                'slug' => uniqid('event_'),
                'start_time' => Carbon::now()->addMonths(5)->toDateTimeString(),
                'end_time' => Carbon::now()->addMonths(5)->addHours(3)->toDateTimeString(),
                'location' => '大禮堂',
                'content' => '年度聖誕晚會，邀請親友共襄盛舉。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
