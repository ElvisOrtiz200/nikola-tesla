<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcadNota extends Model
{
    use HasFactory;
    protected $table = 'acad_notas';

    protected $fillable = [
        'alu_dni',
        'nota',
        'acdo_id',
        'fecha',
        'estado',
        'comentarios',
    ];
    public $timestamps = false;

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'alu_dni', 'alu_dni');
    }

    /**
     * Relación con AcadCargaDocente.
     */
    public function cargaDocente()
    {
        return $this->belongsTo(Curso_Docente::class, 'acdo_id', 'acdo_id');
    }


}
