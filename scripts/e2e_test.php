<?php

// Script simple para ejecutar comprobaciones E2E controladas en el entorno local.
// Ejecutar: php scripts/e2e_test.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "Iniciando E2E rápida (operaciones en transacción, no persistentes)\n";

DB::beginTransaction();
try {
    // 1) Validar credenciales del admin
    $admin = App\Models\User::where('email', 'admin@test.com')->first();
    if (! $admin) {
        throw new Exception('Usuario admin@test.com no encontrado. Ejecuta TestDataSeeder.');
    }

    $passOk = Hash::check('password123', $admin->password);
    echo "- Autenticación admin@test.com: " . ($passOk ? "OK" : "FALLA") . "\n";

    // 2) Crear expediente de prueba
    $exp = App\Models\Expediente::create([
        'num_expediente_interno' => 'E2E-' . uniqid(),
        'juzgado_tribunal' => 'Juzgado E2E',
        'materia' => 'E2E Test',
        'tipo_procedimiento' => 'Procedimiento Test',
        'fecha_inicio' => now()->toDateString(),
        'estado_flujo' => 'Abierto',
        'cuantia' => 1000.00,
        'resumen_asunto' => 'Prueba E2E automatizada',
        'abogado_responsable_id' => $admin->usuario_id,
    ]);

    echo "- Expediente creado: id={$exp->expediente_id}, num={$exp->num_expediente_interno}\n";

    // 3) Vincular persona (si existe) o crearla
    $persona = App\Models\Persona::first();
    if (! $persona) {
        $persona = App\Models\Persona::create([
            'ruc_cc' => 'E2E0001',
            'nombre_razonsocial' => 'Persona E2E',
            'email' => 'e2e-persona@test.com',
            'telefono' => '+59300000000',
            'tipo_persona' => 'Demandante',
        ]);
        echo "- Persona creada id={$persona->persona_id}\n";
    } else {
        echo "- Persona existente usada id={$persona->persona_id}\n";
    }

    $exp->partes()->attach([
        $persona->persona_id => ['rol_en_caso' => 'Demandante', 'posicion_procesal' => 'Actor']
    ]);
    echo "- Persona vinculada al expediente\n";

    // 4) Crear documento (metadatos)
    $doc = App\Models\Documento::create([
        'expediente_id' => $exp->expediente_id,
        'nombre_original' => 'e2e-fake.pdf',
        'ruta_archivo' => 'expedientes/' . $exp->num_expediente_interno . '/e2e-fake.pdf',
        'tipo_mime' => 'application/pdf',
        'tamano_bytes' => 12345,
        'uploaded_by' => $admin->usuario_id,
    ]);
    echo "- Documento creado id={$doc->documento_id}\n";

    // 5) Actualizar expediente
    $exp->update(['estado_flujo' => 'En Litigio', 'resumen_asunto' => 'Actualizado por E2E']);
    echo "- Expediente actualizado estado={$exp->estado_flujo}\n";

    // 6) Borrar expediente (prueba delete)
    $expId = $exp->expediente_id;
    $exp->delete();
    echo "- Expediente eliminado (ID: {$expId})\n";

    DB::rollBack();
    echo "\nE2E completado. Cambios revertidos (transacción rollback).\n";
    exit(0);
} catch (Throwable $e) {
    DB::rollBack();
    echo "\nERROR durante E2E: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
