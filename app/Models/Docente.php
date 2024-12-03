<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';
    protected $primaryKey = 'doc_id';
    protected $fillable = [
        'per_id',
        'doc_especialidad',
        'doc_nivel_educativo',
        'doc_fecha_nac',
        'doc_estado',
    ];
    public $timestamps = false;
    public function recursoshh(){
        return $this->belongsTo(RecursosHumanos::class, 'per_id', 'per_id');
    }
    public function personal()
    {
        return $this->belongsTo(RecursosHumanos::class, 'per_id', 'per_id');
    }
}
