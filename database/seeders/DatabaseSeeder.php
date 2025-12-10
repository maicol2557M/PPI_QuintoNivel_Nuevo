<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        User::create([
            'nombre' => 'Usuario de Prueba',
            'email' => 'test@example.com',
            'id_cedula' => '999999999',
            'identificacion' => '999999999',
            'password' => Hash::make('password'),
            'rol' => 'Abogado',
            'activo' => true,
        ]);
    }
}
