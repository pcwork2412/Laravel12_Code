<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website\Gallery;
use App\Models\Website\GalleryImage;
use Faker\Factory as Faker;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {
            // gallery create
            $gallery = Gallery::create([
                'title'       => $faker->sentence(3), // random title
                'description' => $faker->paragraph(2), // random description
            ]);

            // har gallery me 2–5 random images
            $imageCount = rand(2, 5);

            for ($j = 0; $j < $imageCount; $j++) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    // picsum ka random image url
                    'image_path' => "https://picsum.photos/seed/600/400"
                ]);
            }
        }
    }
}
