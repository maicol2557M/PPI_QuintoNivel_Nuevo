<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $primaryKey = 'documento_id';

    protected $fillable = [
        'expediente_id',
        'nombre_original',
        'ruta_archivo',
        'tipo_mime',
        'tamano_bytes',
        'descripcion',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'expediente_id', 'expediente_id');
    }
}
