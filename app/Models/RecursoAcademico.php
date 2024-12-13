<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursoAcademico extends Model
{
    use HasFactory;
    protected $table = 'recursos_academicos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'nombre_archivo',
        'ruta_archivo',
        'id_curso',
        'fecha_subida',
        'estado',
        'estadobim'
    ];

    public $timestamps = false;

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'acu_id');
    }
}
