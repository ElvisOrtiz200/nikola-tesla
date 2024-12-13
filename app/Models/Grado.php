<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    protected $table = 'acad_grado';
    protected $primaryKey = 'id_grado';
    protected $fillable = ['nombre', 'id_nivel','estado'];

    // Relación con Nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }

    // Relación con Aula
    public function aulas()
    {
        return $this->hasMany(Aula::class, 'id_grado');
    }

    public function CursoDocente()
    {
        return $this->hasMany(Curso_Docente::class, 'id_grado');
    }

    public function Horario()
    {
        return $this->hasMany(Horario::class,'id_grado');
    }
    public $timestamps = false;
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
