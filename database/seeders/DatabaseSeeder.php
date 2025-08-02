<?php

namespace Database\Seeders;

use App\Models\Core\Plan;
use App\Models\Core\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seeders essenciais
        $this->call([
            PlansTableSeeder::class,
            CategoriesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        // 2. Seeders que dependem dos anteriores
        $this->call([
            ListingsTableSeeder::class,
            BusinessHoursTableSeeder::class,
            ImagesTableSeeder::class,
            SubscriptionsTableSeeder::class,
        ]);

        // 3. Usuário de teste padrão (para desenvolvimento)
        // $this->createTestUser();
    }

    // protected function createTestUser()
    // {
    //     User::factory()->create([
    //         'name' => 'Admin Anapolino',
    //         'email' => 'admin@anapolino.com.br',
    //         'password' => Hash::make('senha123'),
    //         'phone' => '(62) 99999-9999',
    //         'role' => 'admin', // Adicione este campo se tiver sistema de roles
    //     ]);

    //     // Usuário comum para testes
    //     $testUser = User::factory()->create([
    //         'name' => 'Usuário Teste',
    //         'email' => 'teste@anapolino.com.br',
    //         'password' => Hash::make('senha123'),
    //         'phone' => '(62) 98888-8888',
    //     ]);

    //     // Assina o usuário teste ao plano básico (opcional)
    //     Subscription::create([
    //         'user_id' => $testUser->id,
    //         'plan_id' => Plan::where('name', 'Básico')->first()->id,
    //         'status' => 'active',
    //         'expires_at' => now()->addYear(),
    //     ]);
    // }
}
