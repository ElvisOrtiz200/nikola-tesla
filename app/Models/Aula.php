<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = 'acad_aula';
    protected $primaryKey = 'id_aula';
    protected $fillable = ['nombre', 'capacidad', 'id_grado','estado'];

    // Relación con Grado
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado');
    }

    public $timestamps = false;

}
