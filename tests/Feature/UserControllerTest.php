<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Administrador']);
        $this->asistente = User::factory()->create(['rol' => 'Asistente']);
        $this->abogado = User::factory()->create(['rol' => 'Abogado']);
    }

    public function test_asistente_puede_ver_lista_usuarios()
    {
        $response = $this->actingAs($this->asistente)
                        ->get('/usuarios');
        
        $response->assertStatus(200)
                ->assertViewIs('usuarios.index');
    }

    public function test_asistente_no_puede_crear_administradores()
    {
        $response = $this->actingAs($this->asistente)
                        ->post('/usuarios', [
                            'nombre' => 'Nuevo Usuario',
                            'email' => 'nuevo@example.com',
                            'rol' => 'Administrador',
                            'password' => 'password',
                            'password_confirmation' => 'password'
                        ]);
        
        $this->assertDatabaseMissing('usuarios', [
            'email' => 'nuevo@example.com',
            'rol' => 'Administrador'
        ]);
    }

    public function test_asistente_puede_crear_abogados()
    {
        $response = $this->actingAs($this->asistente)
                        ->post('/usuarios', [
                            'nombre' => 'Nuevo Abogado',
                            'email' => 'abogado@example.com',
                            'rol' => 'Abogado',
                            'password' => 'password',
                            'password_confirmation' => 'password'
                        ]);
        
        $this->assertDatabaseHas('usuarios', [
            'email' => 'abogado@example.com',
            'rol' => 'Abogado'
        ]);
    }
}