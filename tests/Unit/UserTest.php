<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $user = User::factory()->hasExpedientes(3)->create();
        $this->assertCount(3, $user->expedientes);
    }
}