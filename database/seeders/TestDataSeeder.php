<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Persona;
use App\Models\Expediente;
use App\Models\PlazoActuacion;
use App\Models\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with test data for demonstration.
     */
    public function run(): void
    {
        // Solo crear datos si no existen
        if (User::where('email', 'admin@test.com')->exists()) {
            echo "✓ Datos de prueba ya existen, omitiendo seeder.\n";
            return;
        }

        // Crear usuarios
        $admin = User::create([
            'nombre' => 'Administrador Sistema',
            'email' => 'admin@test.com',
            'identificacion' => '111111111',
            'id_cedula' => '111111111',
            'password' => Hash::make('password123'),
            'rol' => 'Administrador',
            'activo' => true,
        ]);

        $lawyer1 = User::create([
            'nombre' => 'Dr. Carlos Sánchez',
            'email' => 'carlos@test.com',
            'identificacion' => '222222222',
            'id_cedula' => '222222222',
            'password' => Hash::make('password123'),
            'rol' => 'Abogado',
            'activo' => true,
        ]);

        $lawyer2 = User::create([
            'nombre' => 'Dra. Patricia López',
            'email' => 'patricia@test.com',
            'identificacion' => '333333333',
            'id_cedula' => '333333333',
            'password' => Hash::make('password123'),
            'rol' => 'Abogado',
            'activo' => true,
        ]);

        // Crear usuario Cliente (sin acceso al inventario)
        $cliente = User::create([
            'nombre' => 'Juan Cliente Pérez',
            'email' => 'cliente@test.com',
            'identificacion' => '444444444',
            'id_cedula' => '444444444',
            'password' => Hash::make('password123'),
            'rol' => 'Cliente',
            'activo' => true,
        ]);

        // Crear personas
        $person1 = Persona::create([
            'ruc_cc' => '1000000001',
            'nombre_razonsocial' => 'Empresa A S.A.',
            'email' => 'info@empresaa.com',
            'telefono' => '+5930000001',
            'tipo_persona' => 'Demandante',
        ]);

        $person2 = Persona::create([
            'ruc_cc' => '1000000002',
            'nombre_razonsocial' => 'Persona B',
            'email' => 'persona.b@email.com',
            'telefono' => '+5930000002',
            'tipo_persona' => 'Demandado',
        ]);

        // Crear expedientes con diversos estados
        $exp1 = Expediente::create([
            'num_expediente_interno' => 'TEST-2025-001',
            'juzgado_tribunal' => 'Juzgado Primero de lo Civil',
            'materia' => 'Civil',
            'tipo_procedimiento' => 'Juicio Ordinario',
            'fecha_inicio' => Carbon::now()->subDays(150),
            'estado_flujo' => 'Cerrado',
            'fecha_ultima_actuacion' => Carbon::now()->subDays(30),
            'cuantia' => 75000.00,
            'resumen_asunto' => 'Demanda por incumplimiento de contrato',
            'abogado_responsable_id' => $lawyer1->usuario_id,
        ]);

        $exp2 = Expediente::create([
            'num_expediente_interno' => 'TEST-2025-002',
            'juzgado_tribunal' => 'Corte de Apelaciones',
            'materia' => 'Administrativo',
            'tipo_procedimiento' => 'Recurso de Apelación',
            'fecha_inicio' => Carbon::now()->subDays(90),
            'estado_flujo' => 'En Litigio',
            'cuantia' => 120000.00,
            'resumen_asunto' => 'Apelación de sentencia de primer grado',
            'abogado_responsable_id' => $lawyer1->usuario_id,
        ]);

        $exp3 = Expediente::create([
            'num_expediente_interno' => 'TEST-2025-003',
            'juzgado_tribunal' => 'Juzgado Laboral',
            'materia' => 'Laboral',
            'tipo_procedimiento' => 'Juicio de Trabajo',
            'fecha_inicio' => Carbon::now()->subDays(60),
            'estado_flujo' => 'Abierto',
            'cuantia' => 45000.00,
            'resumen_asunto' => 'Reclamación de prestaciones laborales',
            'abogado_responsable_id' => $lawyer2->usuario_id,
        ]);

        $exp4 = Expediente::create([
            'num_expediente_interno' => 'TEST-2025-004',
            'juzgado_tribunal' => 'Juzgado de Familia',
            'materia' => 'Familia',
            'tipo_procedimiento' => 'Divorcio',
            'fecha_inicio' => Carbon::now()->subDays(45),
            'estado_flujo' => 'En Litigio',
            'cuantia' => 80000.00,
            'resumen_asunto' => 'Proceso de divorcio con bienes en común',
            'abogado_responsable_id' => $lawyer2->usuario_id,
        ]);

        // Vincular personas a expedientes
        $exp1->partes()->attach([$person1->persona_id => ['rol_en_caso' => 'Demandante', 'posicion_procesal' => 'Actor']]);
        $exp2->partes()->attach([$person2->persona_id => ['rol_en_caso' => 'Demandado', 'posicion_procesal' => 'Demandado']]);
        $exp3->partes()->attach([$person1->persona_id => ['rol_en_caso' => 'Trabajador', 'posicion_procesal' => 'Demandante']]);
        $exp4->partes()->attach([$person2->persona_id => ['rol_en_caso' => 'Cónyuge', 'posicion_procesal' => 'Demandante']]);

        // Crear plazos de actuación
        PlazoActuacion::create([
            'expediente_id' => $exp2->expediente_id,
            'descripcion_actuacion' => 'Presentación de apelación',
            'fecha_limite' => Carbon::now()->addDays(5),
            'responsable' => $lawyer1->nombre,
            'estado' => 'Pendiente',
            'notas' => 'Plazo próximo a vencer',
        ]);

        PlazoActuacion::create([
            'expediente_id' => $exp3->expediente_id,
            'descripcion_actuacion' => 'Audiencia de conciliación',
            'fecha_limite' => Carbon::now()->addDays(20),
            'responsable' => $lawyer2->nombre,
            'estado' => 'Pendiente',
        ]);

        PlazoActuacion::create([
            'expediente_id' => $exp4->expediente_id,
            'descripcion_actuacion' => 'Presentación de pruebas',
            'fecha_limite' => Carbon::now()->addDays(15),
            'responsable' => $lawyer2->nombre,
            'estado' => 'Pendiente',
        ]);

        echo "✅ Datos de prueba creados exitosamente!\n";
        echo "   • 3 usuarios administrativos (1 Admin, 2 Abogados)\n";
        echo "   • 1 usuario Cliente (acceso solo página pública)\n";
        echo "   • 2 personas\n";
        echo "   • 4 expedientes con estados variados\n";
        echo "   • 4 plazos de actuación\n";
        echo "\nCredenciales de acceso:\n";
        echo "   Admin: admin@test.com / password123 (control total)\n";
        echo "   Abogado 1: carlos@test.com / password123 (acceso inventario limitado)\n";
        echo "   Abogado 2: patricia@test.com / password123 (acceso inventario limitado)\n";
        echo "   Cliente: cliente@test.com / password123 (solo página pública)\n";
    }
}
