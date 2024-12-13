<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $table = 'acad_estudiantes';
    protected $primaryKey = 'alu_dni';

    protected $fillable = [ 
        'alu_apellidos',
        'alu_nombres',
        'apo_dni',
        'alu_direccion',
        'alu_telefono',
        'alu_estado'
    ];

    public $timestamps = false;

    public function EstudianteCurso(){
        return $this->hasMany(EstudianteCurso::class);
    }

    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class, 'apo_dni', 'apo_dni');
    }

    public function notas()
    {
        return $this->hasMany(AcadNota::class, 'alu_dni', 'alu_dni');
    }

    public function proemdio()
    {
        return $this->hasMany(promediofinal::class, 'alu_dni', 'alu_dni');
    }
}
