<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;

class RecursosHumanos extends Model
{
    use HasFactory;
    protected $table = 'rrhh_personal';
    protected $primaryKey = 'per_id';
    protected $fillable = [
        'per_apellidos',
        'per_nombres',
        'per_cargo',
        'per_fecha_inicio',
        'per_fecha_fin',
        'per_estado',
        'per_dni',
        'per_telefono',
        'per_direccion'
 
    ];
    public $timestamps = false;

    public function docente(){
        return $this->hasOne(Docente::class, 'per_id', 'per_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(
            Curso::class,               // Modelo relacionado
            'acad_carga_docente',       // Tabla intermedia
            'per_id',                   // Foreign key en la tabla intermedia para este modelo (rrhh_personal)
            'acu_id',                   // Foreign key en la tabla intermedia para el modelo Curso
            'per_id',                   // Clave primaria en este modelo (rrhh_personal)
            'acu_id'                    // Clave primaria en el modelo Curso
        )->withPivot('acdo_estado', 'acdo_anio', 'acdo_fecha_ini', 'acdo_fecha_fin');
    }
}


