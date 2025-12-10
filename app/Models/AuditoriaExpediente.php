<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaExpediente extends Model
{
    protected $primaryKey = 'auditoria_id';

    protected $fillable = [
        'expediente_id',
        'usuario_id',
        'tipo_cambio',
        'descripcion',
        'fecha_cambio',
    ];

    protected $casts = [
        'fecha_cambio' => 'datetime',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id', 'expediente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
