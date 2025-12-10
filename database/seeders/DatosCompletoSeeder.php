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

class DatosCompletoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with complete test data.
     */
    public function run(): void
    {
        // Crear usuarios de diferentes roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@asesoro.com'],
            [
                'nombre' => 'Admin Usuario',
                'identificacion' => '123456789',
                'id_cedula' => '123456789',
                'password' => Hash::make('password123'),
                'rol' => 'Administrador',
                'activo' => true,
            ]
        );

        $abogado1 = User::firstOrCreate(
            ['email' => 'juan@asesoro.com'],
            [
                'nombre' => 'Juan Pérez Martínez',
                'identificacion' => '987654321',
                'id_cedula' => '987654321',
                'password' => Hash::make('password123'),
                'rol' => 'Abogado',
                'activo' => true,
            ]
        );

        $abogado2 = User::firstOrCreate(
            ['email' => 'maria@asesoro.com'],
            [
                'nombre' => 'María García López',
                'identificacion' => '555666777',
                'id_cedula' => '555666777',
                'password' => Hash::make('password123'),
                'rol' => 'Abogado',
                'activo' => true,
            ]
        );

        $asistente = User::firstOrCreate(
            ['email' => 'carlos@asesoro.com'],
            [
                'nombre' => 'Carlos Rodríguez Silva',
                'identificacion' => '111222333',
                'id_cedula' => '111222333',
                'password' => Hash::make('password123'),
                'rol' => 'Asistente',
                'activo' => true,
            ]
        );

        // Crear personas (partes)
        $persona1 = Persona::firstOrCreate(
            ['ruc_cc' => '0920123456789'],
            [
                'nombre_razonsocial' => 'Empresa ABC S.A.',
                'email' => 'contacto@abc.com',
                'telefono' => '+593987654321',
                'tipo_persona' => 'Demandante',
            ]
        );

        $persona2 = Persona::firstOrCreate(
            ['ruc_cc' => '0980987654321'],
            [
                'nombre_razonsocial' => 'Juan Domínguez Pérez',
                'email' => 'juan.dominguez@email.com',
                'telefono' => '+593991234567',
                'tipo_persona' => 'Demandado',
            ]
        );

        $persona3 = Persona::firstOrCreate(
            ['ruc_cc' => '0950456789123'],
            [
                'nombre_razonsocial' => 'Inversiones XYZ Ltda.',
                'email' => 'legal@xyz.com',
                'telefono' => '+593961234567',
                'tipo_persona' => 'Cliente',
            ]
        );

        // Crear expedientes con estados variados para Juan
        // Expediente 1: Cerrado
        $expediente1 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-001',
            'juzgado_tribunal' => 'Juzgado Civil Primero',
            'materia' => 'Civil',
            'tipo_procedimiento' => 'Juicio Ordinario',
            'fecha_inicio' => Carbon::now()->subDays(180),
            'estado_flujo' => 'Cerrado',
            'fecha_ultima_actuacion' => Carbon::now()->subDays(30),
            'cuantia' => 50000.00,
            'resumen_asunto' => 'Demanda por incumplimiento de contrato de compraventa de bienes',
            'abogado_responsable_id' => $abogado1->usuario_id,
        ]);

        // Expediente 2: En litigio
        $expediente2 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-002',
            'juzgado_tribunal' => 'Corte Nacional de Justicia',
            'materia' => 'Administrativo',
            'tipo_procedimiento' => 'Recurso de Nulidad',
            'fecha_inicio' => Carbon::now()->subDays(120),
            'estado_flujo' => 'En Litigio',
            'cuantia' => 75000.00,
            'resumen_asunto' => 'Recurso de nulidad en contra de resolución administrativa',
            'abogado_responsable_id' => $abogado1->usuario_id,
        ]);

        // Expediente 3: Abierto
        $expediente3 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-003',
            'juzgado_tribunal' => 'Juzgado Laboral',
            'materia' => 'Laboral',
            'tipo_procedimiento' => 'Juicio de Trabajo',
            'fecha_inicio' => Carbon::now()->subDays(45),
            'estado_flujo' => 'Abierto',
            'cuantia' => 25000.00,
            'resumen_asunto' => 'Demanda por despido injustificado y pago de indemnización',
            'abogado_responsable_id' => $abogado1->usuario_id,
        ]);

        // Expediente 4: Cerrado (María)
        $expediente4 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-004',
            'juzgado_tribunal' => 'Corte Constitucional',
            'materia' => 'Constitucional',
            'tipo_procedimiento' => 'Acción de Protección',
            'fecha_inicio' => Carbon::now()->subDays(90),
            'estado_flujo' => 'Cerrado',
            'fecha_ultima_actuacion' => Carbon::now()->subDays(10),
            'cuantia' => 100000.00,
            'resumen_asunto' => 'Acción de protección para resguardo de derechos constitucionales',
            'abogado_responsable_id' => $abogado2->usuario_id,
        ]);

        // Expediente 5: En litigio (María)
        $expediente5 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-005',
            'juzgado_tribunal' => 'Juzgado de Familia',
            'materia' => 'Familia',
            'tipo_procedimiento' => 'Divorcio',
            'fecha_inicio' => Carbon::now()->subDays(60),
            'estado_flujo' => 'En Litigio',
            'cuantia' => 150000.00,
            'resumen_asunto' => 'Proceso de divorcio con regulación de bienes comunes',
            'abogado_responsable_id' => $abogado2->usuario_id,
        ]);

        // Expediente 6: Abierto (María)
        $expediente6 = Expediente::create([
            'num_expediente_interno' => 'EXP-2025-006',
            'juzgado_tribunal' => 'Juzgado de Familia',
            'materia' => 'Familia',
            'tipo_procedimiento' => 'Sucesión',
            'fecha_inicio' => Carbon::now()->subDays(20),
            'estado_flujo' => 'Abierto',
            'cuantia' => 200000.00,
            'resumen_asunto' => 'Proceso sucesorio con conflicto entre herederos',
            'abogado_responsable_id' => $abogado2->usuario_id,
        ]);

        // Vincular personas a expedientes con roles y posiciones
        $expediente1->partes()->attach([
            $persona1->persona_id => ['rol_en_caso' => 'Demandante', 'posicion_procesal' => 'Actor'],
            $persona2->persona_id => ['rol_en_caso' => 'Demandado', 'posicion_procesal' => 'Demandado']
        ]);
        $expediente2->partes()->attach($persona1->persona_id, ['rol_en_caso' => 'Cliente', 'posicion_procesal' => 'Demandante']);
        $expediente3->partes()->attach($persona2->persona_id, ['rol_en_caso' => 'Trabajador', 'posicion_procesal' => 'Demandante']);
        $expediente4->partes()->attach($persona3->persona_id, ['rol_en_caso' => 'Demandante', 'posicion_procesal' => 'Demandante']);
        $expediente5->partes()->attach([
            $persona1->persona_id => ['rol_en_caso' => 'Cónyuge', 'posicion_procesal' => 'Demandante'],
            $persona2->persona_id => ['rol_en_caso' => 'Cónyuge', 'posicion_procesal' => 'Demandado']
        ]);
        $expediente6->partes()->attach($persona3->persona_id, ['rol_en_caso' => 'Heredero', 'posicion_procesal' => 'Demandante']);

        // Crear plazos de actuación
        PlazoActuacion::create([
            'expediente_id' => $expediente1->expediente_id,
            'descripcion_actuacion' => 'Sentencia de primera instancia',
            'fecha_limite' => Carbon::now()->subDays(25),
            'responsable' => $abogado1->nombre,
            'estado' => 'Vencido',
            'notas' => 'Plazo vencido, se requiere revisión',
        ]);

        PlazoActuacion::create([
            'expediente_id' => $expediente2->expediente_id,
            'descripcion_actuacion' => 'Plazo para presentar contestación',
            'fecha_limite' => Carbon::now()->addDays(3),
            'responsable' => $abogado1->nombre,
            'estado' => 'Pendiente',
            'notas' => 'Por vencer próximamente',
        ]);

        PlazoActuacion::create([
            'expediente_id' => $expediente3->expediente_id,
            'descripcion_actuacion' => 'Primera audiencia de conciliación',
            'fecha_limite' => Carbon::now()->addDays(15),
            'responsable' => $abogado1->nombre,
            'estado' => 'Pendiente',
        ]);

        PlazoActuacion::create([
            'expediente_id' => $expediente5->expediente_id,
            'descripcion_actuacion' => 'Desahogo de pruebas',
            'fecha_limite' => Carbon::now()->addDays(8),
            'responsable' => $abogado2->nombre,
            'estado' => 'Pendiente',
        ]);

        // Crear documentos
        Documento::create([
            'expediente_id' => $expediente1->expediente_id,
            'nombre_original' => 'Demanda-Civil-001.pdf',
            'ruta_archivo' => 'expedientes/EXP-2025-001/demanda.pdf',
            'tipo_mime' => 'application/pdf',
            'tamano_bytes' => 256000,
            'uploaded_by' => $abogado1->usuario_id,
        ]);

        Documento::create([
            'expediente_id' => $expediente2->expediente_id,
            'nombre_original' => 'Resolución-Administrativa.pdf',
            'ruta_archivo' => 'expedientes/EXP-2025-002/resolucion.pdf',
            'tipo_mime' => 'application/pdf',
            'tamano_bytes' => 342000,
            'uploaded_by' => $abogado1->usuario_id,
        ]);

        Documento::create([
            'expediente_id' => $expediente3->expediente_id,
            'nombre_original' => 'Contrato-Laboral.pdf',
            'ruta_archivo' => 'expedientes/EXP-2025-003/contrato.pdf',
            'tipo_mime' => 'application/pdf',
            'tamano_bytes' => 185000,
            'uploaded_by' => $abogado1->usuario_id,
        ]);

        Documento::create([
            'expediente_id' => $expediente4->expediente_id,
            'nombre_original' => 'Constitución-Política.pdf',
            'ruta_archivo' => 'expedientes/EXP-2025-004/constitucion.pdf',
            'tipo_mime' => 'application/pdf',
            'tamano_bytes' => 512000,
            'uploaded_by' => $abogado2->usuario_id,
        ]);

        echo "✅ Seeder completado exitosamente!\n";
        echo "   - 4 usuarios creados (1 Admin, 2 Abogados, 1 Asistente)\n";
        echo "   - 3 personas (partes) creadas\n";
        echo "   - 6 expedientes creados con estados variados\n";
        echo "   - 4 plazos de actuación creados\n";
        echo "   - 4 documentos creados\n";
    }
}
