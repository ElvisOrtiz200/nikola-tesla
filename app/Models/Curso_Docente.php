<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso_Docente extends Model
{
    use HasFactory;

    protected $table = 'acad_carga_docente';
    protected $primaryKey = 'acdo_id';
    protected $fillable = [
       'acu_id', 'per_id', 'acdo_estado', 'acdo_anio', 'acdo_fecha_ini', 'acdo_fecha_fin', 'id_grado'
    ];
    public $timestamps = false;


    public function Grado(){
        return $this->belongsTo(Grado::class,'id_grado');
    }

    // public function grado(): BelongsTo
    // {
    //     return $this->belongsTo(AcadGrado::class, 'id_grado', 'id_grado');
    // }

    public function EstudianteCurso(){
        return $this->hasMany(EstudianteCurso::class, 'acdo_id');
    }

    public function notas()
    {
        return $this->hasMany(AcadNota::class, 'acdo_id', 'acdo_id');
    }



}