<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlEconomico extends Model
{
    protected $primaryKey = 'control_economico_id';

    protected $fillable = [
        'expediente_id',
        'descripcion_gasto',
        'monto',
        'fecha_gasto',
        'comprobante_numero',
        'estado_pago',
    ];

    protected $casts = [
        'fecha_gasto' => 'datetime',
        'monto' => 'decimal:2',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id', 'expediente_id');
    }
}
