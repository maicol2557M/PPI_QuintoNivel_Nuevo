<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $primaryKey = 'persona_id';

    protected $fillable = [
    'ruc_cc',
    'nombre_razonsocial',
    'tipo_persona',
    'telefono',
    'email',
    'domicilio_completo'
];

    public function expedientes()
    {
        return $this->belongsToMany(Expediente::class, 'expedientes_partes', 'persona_id', 'expediente_id')
            ->withPivot('rol_en_caso', 'posicion_procesal');
    }
}
