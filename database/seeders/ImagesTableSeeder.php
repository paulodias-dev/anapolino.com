<?php

namespace Database\Seeders;

use App\Models\Core\Listing;
use App\Models\Core\Image;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    public function run()
    {
        $listings = Listing::all();

        foreach ($listings as $listing) {
            // Cria 1-4 imagens para cada anúncio
            $imagesCount = rand(1, 4);

            for ($i = 0; $i < $imagesCount; $i++) {
                $isMain = $i === 0; // A primeira imagem é a principal

                Image::create([
                    'path' => 'listings/sample-' . rand(1, 5) . '.jpg',
                    'thumbnail_path' => 'listings/thumbs/sample-' . rand(1, 5) . '.jpg',
                    'is_main' => $isMain,
                    'order' => $i,
                    'imageable_id' => $listing->id,
                    'imageable_type' => Listing::class
                ]);
            }
        }
    }
}
