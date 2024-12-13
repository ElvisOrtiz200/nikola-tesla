<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promediofinal extends Model
{
    use HasFactory;
    protected $table = 'promediofinal';
  
    public $incrementing = false; // Indicar que la clave primaria no es autoincremental

    protected $fillable = [
          'nota', 'alu_dni', 'acdo_id', 'bim_sigla'
    ];
    public $timestamps = false;

    public function estudiantes()
    {
        return $this->belongsTo(Estudiante::class, 'alu_dni', 'alu_dni');
    }

    public function cargaDocente()
    {
        return $this->belongsTo(Curso_Docente::class, 'acdo_id', 'acdo_id');
    }

    public function bimestre()
    {
        return $this->belongsTo(Bimestre::class, 'bim_sigla', 'bim_sigla');
    }


}
