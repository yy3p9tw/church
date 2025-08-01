<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=1200&q=80',
        ];
        foreach ($images as $i => $img) {
            Slider::create([
                'title' => '輪播圖 ' . ($i+1),
                'image_url' => $img,
                'link_url' => 'https://example.com/'.($i+1),
                'sort_order' => $i,
            ]);
        }
    }
}
