<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_asistente_no_puede_acceder_a_ruta_admin()
    {
        $asistente = User::factory()->create(['rol' => 'Asistente']);
        
        $response = $this->actingAs($asistente)
                        ->get('/ruta-solo-admin');
        
        $response->assertStatus(403);
    }

    public function test_admin_puede_acceder_a_todas_las_rutas()
    {
        $admin = User::factory()->create(['rol' => 'Administrador']);
        
        $response = $this->actingAs($admin)
                        ->get('/cualquier-ruta');
        
        // Ajusta según tu lógica de rutas
        $response->assertStatus(200);
    }
}