<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        Staff::truncate();
        Staff::create([
            'name' => '王大衛',
            'title' => '主任牧師',
            'photo' => null,
            'bio' => '負責教會異象、講道與牧養。',
            'sort_order' => 1,
            'status' => 1,
        ]);
        Staff::create([
            'name' => '李以諾',
            'title' => '行政同工',
            'photo' => null,
            'bio' => '協助行政、活動與關懷事工。',
            'sort_order' => 2,
            'status' => 1,
        ]);
        Staff::create([
            'name' => '張恩慈',
            'title' => '敬拜主領',
            'photo' => null,
            'bio' => '帶領敬拜團隊，服事主日聚會。',
            'sort_order' => 3,
            'status' => 1,
        ]);
    }
}
