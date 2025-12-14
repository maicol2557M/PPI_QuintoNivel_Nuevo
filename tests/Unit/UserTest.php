<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $user = User::factory()->create([
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'rol' => 'Abogado'
        ]);

        $this->assertDatabaseHas('usuarios', [
            'email' => 'juan@example.com',
            'rol' => 'Abogado'
        ]);
    }

    public function test_user_has_expedientes_relationship()
    {
        $user = User::factory()->create(['rol' => 'Abogado']);
        
        // Verificar que el usuario tiene la relación con expedientes
        $this->assertTrue(method_exists($user, 'expedientes'), 
            'El modelo User debe tener un método expedientes()');
    }
}