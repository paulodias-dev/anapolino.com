<?php

namespace Database\Seeders;

use App\Models\Core\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Grátis',
                'description' => 'Plano básico para pequenos negócios',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'listing_limit' => 1,
                'featured_listings' => false,
                'featured_limit' => 0,
                'order' => 1,
                'active' => true,
            ],
            [
                'name' => 'Básico',
                'description' => 'Ideal para quem está começando',
                'price_monthly' => 29.90,
                'price_yearly' => 299.00,
                'listing_limit' => 3,
                'featured_listings' => true,
                'featured_limit' => 1,
                'order' => 2,
                'active' => true,
            ],
            [
                'name' => 'Profissional',
                'description' => 'Para negócios estabelecidos',
                'price_monthly' => 79.90,
                'price_yearly' => 799.00,
                'listing_limit' => 10,
                'featured_listings' => true,
                'featured_limit' => 3,
                'order' => 3,
                'active' => true,
            ],
            [
                'name' => 'Premium',
                'description' => 'Solução completa para grandes empresas',
                'price_monthly' => 149.90,
                'price_yearly' => 1499.00,
                'listing_limit' => 999, // ilimitado
                'featured_listings' => true,
                'featured_limit' => 999, // ilimitado
                'order' => 4,
                'active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
