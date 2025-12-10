<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RolesYUsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insertar el Usuario Administrador/Socio
        DB::table('usuarios')->insert([
            'nombre' => 'Admin Socio Principal',
            'email' => 'admin@oficina.com',
            'password' => Hash::make('password'), // Contraseña: 'password'
            'rol' => 'Administrador', // Rol clave para el middleware
            'activo' => true,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('Usuario Administrador Creado: admin@oficina.com / password');

        // 2. Insertar un Abogado (para pruebas de permisos intermedios)
        DB::table('usuarios')->insert([
            'nombre' => 'Abogado Prueba',
            'email' => 'abogado@oficina.com',
            'password' => Hash::make('password'),
            'rol' => 'Abogado',
            'activo' => true,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 3. Insertar un Asistente (para pruebas de solo consulta)
        DB::table('usuarios')->insert([
            'nombre' => 'Asistente Prueba',
            'email' => 'asistente@oficina.com',
            'password' => Hash::make('password'),
            'rol' => 'Asistente',
            'activo' => true,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
