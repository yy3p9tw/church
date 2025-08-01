<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 預設測試帳號（避免重複建立）
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // 核心資料表 Seeder
        $this->call([
            SermonSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            SmallGroupSeeder::class,
            BulletinSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
