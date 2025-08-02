<?php

namespace Database\Seeders;

use App\Models\Core\Category;
use App\Models\Core\Subcategory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Alimentação' => [
                'Restaurantes',
                'Bares',
                'Padarias',
                'Mercados'
            ],
            'Serviços' => [
                'Assistência Técnica',
                'Consultorias',
                'Educação',
                'Reparos'
            ],
            'Saúde' => [
                'Clínicas',
                'Farmácias',
                'Médicos',
                'Hospitais'
            ],
            'Comércio' => [
                'Vestuário',
                'Eletrônicos',
                'Móveis',
                'Presentes'
            ],
            'Automotivo' => [
                'Oficinas',
                'Lava-rápido',
                'Concessionárias',
                'Peças'
            ],
        ];

        foreach ($categories as $categoryName => $subcategories) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => \Illuminate\Support\Str::slug($categoryName),
                'icon' => 'fas fa-utensils', // Ícone genérico, ajustar conforme categoria
                'order' => array_search($categoryName, array_keys($categories)) + 1,
                'active' => true,
            ]);

            foreach ($subcategories as $subcategoryName) {
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subcategoryName,
                    'slug' => \Illuminate\Support\Str::slug($subcategoryName),
                    'order' => array_search($subcategoryName, $subcategories) + 1,
                    'active' => true,
                ]);
            }
        }
    }
}
