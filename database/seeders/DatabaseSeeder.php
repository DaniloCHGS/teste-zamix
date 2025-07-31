<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria 10 usuários
        User::factory(1)->create();

        // Cria 10 produtos
        Product::factory(10)->create();

        // Cria 10 requisições
        Request::factory(12)->create();

        // Usuário de teste fixo
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Senha padrão para o usuário de teste
        ]);
    }
}
