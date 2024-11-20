<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    use HasFactory;
    protected $table = 'diassemana';
    protected $primaryKey = 'idDiaSemana';
    protected $fillable = ['nombreDia'];
    public $timestamps = false;
    public function Horario()
    {
        return $this->hasMany(Horario::class,'idDiaSemana');
    }
}
