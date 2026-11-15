<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Autumn', 'category' => 'Nature', 'image_url' => 'https://www.mickeyshannon.com/wp-content/uploads/2020/02/firebolt-tree-of-life.jpg', 'image_alt' => 'Autumn Japanese maple tree'],
            ['title' => 'A Quiet Gallery', 'category' => 'Space', 'image_url' => 'https://assets-global.website-files.com/6411dbc62b0a4f380f7eb33a/64ef39bc605e8460b2659e78_2308_Noorddammerlaan_HOP_michaelcerrone_6.webp', 'image_alt' => 'Bright gallery interior with framed artwork'],
            ['title' => 'Framed Memories', 'category' => 'Art', 'image_url' => 'https://www.clave.com.ec/wp-content/uploads/2021/02/MG_0948.jpg', 'image_alt' => 'Photography gallery exhibition'],
            ['title' => 'Creative Space', 'category' => 'Interior', 'image_url' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1400&q=85', 'image_alt' => 'Creative interior workspace'],
            ['title' => 'Somewhere Far', 'category' => 'Landscape', 'image_url' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1400&q=85', 'image_alt' => 'Mountain landscape'],
            ['title' => 'Beyond', 'category' => 'Journey', 'image_url' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1400&q=85', 'image_alt' => 'Atmospheric natural landscape'],
            ['title' => 'Into the Woods', 'category' => 'Nature', 'image_url' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1400&q=85', 'image_alt' => 'Forest photography'],
            ['title' => 'The Road', 'category' => 'Travel', 'image_url' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1400&q=85', 'image_alt' => 'Open road landscape'],
        ];

        foreach ($items as $item) {
            GalleryItem::firstOrCreate(['title' => $item['title']], $item);
        }
    }
}
