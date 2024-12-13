<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteCurso extends Model
{
    use HasFactory;
    
    protected $table = 'acad_estudiantes_cursos';
    protected $fillable = [
        'acdo_id',
        'alu_dni',
        'bim_sigla',
        'estado',
     
    ];
    public $timestamps = false;

    public function Curso_Docente(){
        return $this->belongsTo(Curso_Docente::class,'acdo_id');
    }

    public function Bimestre(){
        return $this->belongsTo(Bimestre::class,'bim_sigla');
    }

    public function Estudiante(){
        return $this->belongsTo(Estudiante::class,'alu_dni');
    }
}
