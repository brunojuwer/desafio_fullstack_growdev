<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\Mentor::factory(20)->create();
        \App\Models\Mentor::factory()->create([
            'name' => 'Super User',
            'email' => 'admin@email.com',
            'cpf' => '00.000.000-00',
            "role" => "ADMIN",
            'password' => Hash::make('password')
        ]);
    }
}
