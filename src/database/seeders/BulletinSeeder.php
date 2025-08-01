<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bulletin;

class BulletinSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'https://picsum.photos/seed/bulletin1/600/800',
            'https://picsum.photos/seed/bulletin2/600/800',
            'https://picsum.photos/seed/bulletin3/600/800',
            'https://picsum.photos/seed/bulletin4/600/800',
            'https://picsum.photos/seed/bulletin5/600/800',
        ];
        for ($i = 1; $i <= 10; $i++) {
            Bulletin::create([
                'title' => '週報第' . $i . '期',
                'image_url' => $images[array_rand($images)],
                'publish_date' => now()->subWeeks($i),
            ]);
        }
    }
}
