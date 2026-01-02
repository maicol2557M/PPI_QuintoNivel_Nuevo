<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $asistente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Administrador']);
        $this->asistente = User::factory()->create(['rol' => 'Asistente']);
    }

    public function test_asistente_no_puede_acceder_a_ruta_admin()
    {
        $response = $this->actingAs($this->asistente)
                        ->get('/ruta-solo-admin');

        $response->assertStatus(403);
    }

    public function test_admin_puede_acceder_a_todas_las_rutas()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/cualquier-ruta');

        // Ajusta según tu lógica de rutas
        $response->assertStatus(200);
    }

    public function test_asistente_puede_ver_lista_de_usuarios()
    {
        $response = $this->actingAs($this->asistente)
                        ->get(route('usuarios.index'));

        $response->assertSuccessful();
    }

    public function test_admin_puede_ver_todos_los_usuarios()
    {
        $response = $this->actingAs($this->admin)
                        ->get(route('usuarios.index'));

        $response->assertSuccessful();
    }

    public function test_asistente_no_puede_reactivar_usuarios()
    {
        // Crear un usuario inactivo
        $usuario = User::factory()->create(['activo' => false]);

        // Verificar que el usuario se creó correctamente como inactivo
        $this->assertFalse((bool)$usuario->activo);

        // Intentar reactivar el usuario como asistente
        $response = $this->actingAs($this->asistente)
                        ->post(route('usuarios.reactivate', $usuario));

        // Verificar que se redirija (302)
        $response->assertStatus(302);

        // Verificar que el usuario siga inactivo
        $usuario->refresh();
        $this->assertFalse((bool)$usuario->activo, 'El usuario no debería haberse reactivado');
    }
}
