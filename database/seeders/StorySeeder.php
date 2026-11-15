<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            ['title' => 'The City', 'body' => 'The streets were loud, but somehow she found a quiet place inside them.', 'image_url' => 'https://images.squarespace-cdn.com/content/v1/5f54cd1a740fbb7a4f4f3ecb/180eb2bb-1b2d-4a21-89b4-89c913a666b0/ULVD93ufJgAWbSSuXYFN--0--y27zy_2x-clty-upscale-qgx4r.jpg', 'image_alt' => 'Cinematic urban street portrait'],
            ['title' => 'After Rain', 'body' => 'The rain had stopped, but the city still carried its reflection.', 'image_url' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1600&q=85', 'image_alt' => 'Cinematic portrait photography'],
            ['title' => 'Somewhere Quiet', 'body' => 'Perhaps we don\'t always need to know where we are going.', 'image_url' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1600&q=85', 'image_alt' => 'Atmospheric landscape photography'],
        ];

        foreach ($stories as $story) {
            Story::firstOrCreate(['title' => $story['title']], $story);
        }
    }
}
