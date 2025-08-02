<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Usuário admin
        User::create([
            'name' => 'Admin Anapolino',
            'email' => 'admin@anapolino.com.br',
            'password' => Hash::make('senha@123'),
            'email_verified_at' => now(),
            'phone' => '(62) 99999-9999',
        ]);

        // Usuários comuns
        $users = [
            [
                'name' => 'João da Silva',
                'email' => 'joao@exemplo.com',
                'password' => Hash::make('senha@123'),
                'phone' => '(62) 98888-8888',
            ],
            [
                'name' => 'Maria Souza',
                'email' => 'maria@exemplo.com',
                'password' => Hash::make('senha@123'),
                'phone' => '(62) 97777-7777',
            ],
            [
                'name' => 'Empresa XYZ Ltda',
                'email' => 'contato@xyz.com.br',
                'password' => Hash::make('senha@123'),
                'phone' => '(62) 96666-6666',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Usuários fakes (opcional - usando factory)
        User::factory()->count(1)->create();
    }
}
