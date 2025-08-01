<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmallGroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('small_groups')->insert([
            [
                'name' => '約書亞小組',
                'slug' => uniqid('group_'),
                'type' => '查經',
                'contact_person' => '陳弟兄',
                'description' => '每週五晚上查經聚會。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '以斯帖小組',
                'slug' => uniqid('group_'),
                'type' => '禱告',
                'contact_person' => '林姊妹',
                'description' => '每週三早上禱告會。',
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
