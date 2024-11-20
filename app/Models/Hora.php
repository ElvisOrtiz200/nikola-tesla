<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    use HasFactory;
    protected $table = 'hora';
    protected $primaryKey = 'idHora';
    protected $fillable = ['nombreHora'];
    public $timestamps = false;
    public function Horario()
    {
        return $this->hasMany(Horario::class,'idHora');
    }
    

}
