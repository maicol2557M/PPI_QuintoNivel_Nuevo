<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $primaryKey = 'expediente_id';

    protected $fillable = [
        'num_expediente_interno',
        'num_judicial',
        'juzgado_tribunal',
        'materia',
        'tipo_procedimiento',
        'fecha_inicio',
        'estado_flujo',
        'cuantia',
        'resumen_asunto',
        'fecha_ultima_actuacion',
        'ubicacion_archivo',
        'observaciones_internas',
        'abogado_responsable_id',
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'expediente_id', 'expediente_id');
    }

    public function partes()
    {
        return $this->belongsToMany(Persona::class, 'expedientes_partes', 'expediente_id', 'persona_id')
            ->withPivot('rol_en_caso', 'posicion_procesal');
    }

    public function plazosActuaciones()
    {
        return $this->hasMany(PlazoActuacion::class, 'expediente_id', 'expediente_id');
    }

    public function abogadoResponsable()
    {
        return $this->belongsTo(User::class, 'abogado_responsable_id');
    }
}
