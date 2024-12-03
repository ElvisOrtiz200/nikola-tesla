<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    use HasFactory;

    protected $table = 'acad_apoderado';
    protected $primaryKey = 'apo_dni';
    protected $fillable = [
        'apo_apellidos',
        'apo_nombres',
        'apo_direccion',
        'apo_telefono',
    ];
    public $timestamps = false;

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'apo_dni', 'apo_dni');
    }
}
