<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlazoActuacion extends Model
{
    protected $table = 'plazos_actuaciones';
    protected $primaryKey = 'plazo_actuacion_id';
    
    protected $fillable = [
        'expediente_id',
        'descripcion_actuacion',
        'fecha_limite',
        'responsable',
        'estado',
        'notas'
    ];

    protected $dates = [
        'fecha_limite',
        'created_at',
        'updated_at'
    ];
    
    // Mapear fecha_vencimiento a fecha_limite
    public function setFechaVencimientoAttribute($value)
    {
        $this->attributes['fecha_limite'] = $value;
    }
    
    public function getFechaVencimientoAttribute()
    {
        return $this->attributes['fecha_limite'];
    }

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id', 'expediente_id');
    }
}