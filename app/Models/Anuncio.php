<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;
    // Tabla asociada
    protected $table = 'acad_anuncios';

    // Llave primaria
    protected $primaryKey = 'id_anuncio';

    // Campos que pueden asignarse masivamente
    protected $fillable = ['titulo', 'descripcion', 'fecha_publicacion', 'id_curso', 'estado','estadobim'];

    public $timestamps = false;

    // Relación con Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'acu_id');
    }
}
