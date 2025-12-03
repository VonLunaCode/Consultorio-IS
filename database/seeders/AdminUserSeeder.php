<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'], // Busca si ya existe este email
            [
                'name' => 'Administrador',      // Si no existe, crea esto
                'password' => Hash::make('pass123'), // Contraseña encriptada
                'email_verified_at' => now(),
            ]
        );
    }
}