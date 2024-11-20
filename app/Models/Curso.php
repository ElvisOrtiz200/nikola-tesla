<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'acad_cursos';
    protected $primaryKey = 'acu_id';
    protected $fillable = [
        'acu_nombre',
        'acu_estado',
        'id_grado'
    ];
    public $timestamps = false; 

    public function Horario()
    {
        return $this->hasMany(Horario::class,'acu_id');
    }

    public function docentes()
    {
        return $this->belongsToMany(
            RecursosHumanos::class,            // Modelo relacionado
            'acad_carga_docente',       // Tabla intermedia
            'acu_id',                   // Foreign key en la tabla intermedia para este modelo (acad_cursos)
            'per_id',                   // Foreign key en la tabla intermedia para el modelo Personal
            'acu_id',                   // Clave primaria en este modelo (acad_cursos)
            'per_id'                    // Clave primaria en el modelo Personal
        )->withPivot('acdo_estado', 'acdo_anio', 'acdo_fecha_ini', 'acdo_fecha_fin');
    }

    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'id_curso', 'acu_id');
    }

    public function recursosAcademicos()
    {
        return $this->hasMany(RecursoAcademico::class, 'id_curso', 'acu_id');
    }

}
