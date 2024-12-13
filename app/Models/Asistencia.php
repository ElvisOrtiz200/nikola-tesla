<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'asistencia';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'alu_dni',
        'acdo_id',
        'asistencia',
        'fecha',
        'estado'
    ];

    // Relación con el modelo AcadEstudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'alu_dni', 'alu_dni');
    }

    // Relación con el modelo AcadCargaDocente
    public function cargaDocente()
    {
        return $this->belongsTo(Curso_Docente::class, 'acdo_id', 'acdo_id');
    }
    public $timestamps = false;
}
