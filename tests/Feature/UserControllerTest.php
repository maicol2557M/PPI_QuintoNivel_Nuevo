<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $asistente;
    protected $abogado;

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
                            'nombre' => 'Nuevo Admin',
                            'email' => 'admin@example.com',
                            'id_cedula' => '0987654321',
                            'identificacion' => 'AD123456',
                            'password' => 'password',
                            'password_confirmation' => 'password',
                            'rol' => 'Administrador'
                        ]);
        
        $this->assertDatabaseMissing('usuarios', [
            'email' => 'admin@example.com',
            'rol' => 'Administrador'
        ]);
    }

    public function test_asistente_puede_crear_abogados()
{
    // Datos del nuevo usuario abogado
    $userData = [
        'nombre' => 'Nuevo Abogado',
        'email' => 'abogado@example.com',
        'id_cedula' => '1234567890',
        'identificacion' => 'AB123456',
        'password' => 'password',
        'password_confirmation' => 'password',
        'rol' => 'Abogado'
    ];

    // Enviar la petición para crear el usuario
    $response = $this->actingAs($this->asistente)
                    ->post(route('usuarios.store'), $userData);

    // Obtener el usuario recién creado
    $user = User::where('email', 'abogado@example.com')->first();
    $this->assertNotNull($user, 'El usuario no fue creado en la base de datos');
    
    // Verificar redirección a la vista de detalle del usuario
    $response->assertRedirect(route('usuarios.show', $user->usuario_id));

    // Verificar que el usuario fue creado en la base de datos
    $this->assertDatabaseHas('usuarios', [
        'email' => 'abogado@example.com',
        'rol' => 'Abogado',
        'id_cedula' => '1234567890',
        'identificacion' => 'AB123456'
    ]);

    // Verificar los datos del usuario
    $this->assertEquals('Nuevo Abogado', $user->nombre);
    $this->assertEquals('Abogado', $user->rol);
    $this->assertEquals('1234567890', $user->id_cedula);
    $this->assertEquals('AB123456', $user->identificacion);
    
    // Opcional: Verificar el campo activo si existe
    if (property_exists($user, 'activo')) {
        $this->assertTrue((bool)$user->activo);
    }
}
}