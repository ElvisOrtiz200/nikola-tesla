<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';
    protected $primaryKey = 'idrol';

    protected $fillable = [
        'nombre_rol'
    ];

    public $timestamps = false;

    public function usuario(){
        return $this->hasMany(Usuario::class, 'idrol');
    }
}
