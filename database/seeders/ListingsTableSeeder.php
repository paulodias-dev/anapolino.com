<?php

namespace Database\Seeders;

use App\Models\Core\Listing;
use App\Models\Core\Image;
use App\Models\User;
use App\Models\Core\Category;
use Illuminate\Database\Seeder;

class ListingsTableSeeder extends Seeder
{
    public function run()
    {
        // Verifica se existem usuários e categorias
        $users = User::all();
        $categories = Category::with('subcategories')->get();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Users or categories table is empty. Please seed those tables first.');
            return;
        }

        $listings = [
            [
                'title' => 'Restaurante Sabor Caseiro',
                'description' => 'Comida caseira com os melhores ingredientes da região',
                'phone' => '(62) 3333-3333',
                'whatsapp' => true,
                'address' => 'Rua das Flores, 123 - Centro',
                'city' => 'Anápolis',
                'state' => 'GO',
                'zip_code' => '75000-000',
                'latitude' => -16.3287,
                'longitude' => -48.9534,
                'delivery_available' => true,
                'website' => 'http://saborcaseiro.com.br',
                'active' => true,
                'featured' => true,
                'featured_until' => now()->addDays(30),
            ],
            [
                'title' => 'Auto Mecânica Rapidão',
                'description' => 'Serviços rápidos e com garantia para seu veículo',
                'phone' => '(62) 4444-4444',
                'whatsapp' => false,
                'address' => 'Av. Brasil, 456 - Jardim América',
                'city' => 'Anápolis',
                'state' => 'GO',
                'zip_code' => '75000-100',
                'latitude' => -16.3321,
                'longitude' => -48.9482,
                'delivery_available' => false,
                'website' => null,
                'active' => true,
                'featured' => false,
            ],
        ];

        foreach ($listings as $index => $listingData) {
            $user = $users->random();
            $category = $categories->random();

            // Cria o anúncio
            $listing = Listing::create(array_merge($listingData, [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'subcategory_id' => $category->subcategories->isNotEmpty()
                    ? $category->subcategories->random()->id
                    : null,
            ]));

            // Adiciona imagem principal
            $listing->images()->create([
                'path' => $index === 0
                    ? 'listings/restaurante-exemplo.jpg'
                    : 'listings/mecanica-exemplo.jpg',
                'is_main' => true,
            ]);
        }

        // Cria mais anúncios aleatórios se a factory existir
        // if (class_exists(\Database\Factories\ListingFactory::class)) {
        //     Listing::factory()
        //         ->count(5)
        //         ->create()
        //         ->each(function ($listing) {
        //             $listing->images()->create([
        //                 'path' => 'listings/default-image.jpg',
        //                 'is_main' => true,
        //             ]);
        //         });
        // }
    }
}
