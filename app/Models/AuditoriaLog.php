<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaLog extends Model
{
    use HasFactory;
    protected $table = 'auditorialog';  // Especificamos el nombre de la tabla
    protected $primaryKey = 'id';  // Definimos la clave primaria
    public $timestamps = false;  // Deshabilitar los timestamps (created_at, updated_at)

    protected $fillable = [
        'usuario', 'operacion', 'fecha', 'entidad'
    ];
}
