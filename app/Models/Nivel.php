<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'acad_nivel';
    protected $primaryKey = 'id_nivel';
    protected $fillable = ['nombre'];

    // Relación con Grado
    public function grados()
    {
        return $this->hasMany(Grado::class, 'id_nivel');
    }

    public $timestamps = false;

    

}
