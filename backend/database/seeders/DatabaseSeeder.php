<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Mentor::factory(20)->create();
        \App\Models\Mentor::factory()->create([
            'name' => 'Super User',
            'email' => 'admin@email.com',
            'cpf' => '00.999.888-77',
            "role" => "ADMIN",
            'password' => Hash::make('password')
        ]);
    }
}
