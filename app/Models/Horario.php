<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horario';
    protected $primaryKey = 'idHorario';
    protected $fillable = ['acu_id','idDiaSemana','idHora','id_grado','estado'];
    public $timestamps = false;


    public function Grado(){
        return $this->belongsTo(Grado::class,'id_grado');
    }

    public function Hora(){
        return $this->belongsTo(Hora::class,'idHora');
    }

    public function DiaSemana(){
        return $this->belongsTo(DiaSemana::class,'idDiaSemana');
    }

    public function Curso(){
        return $this->belongsTo(Curso::class,'acu_id');
    }
    
}
