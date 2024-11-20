<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'auth_usuario';
    protected $primaryKey = 'usu_id';

    protected $fillable = [
        'per_id',
        'usu_login',
        'password',
        'usu_estado',
        'correo',
        'idrol'
    ]; 

    public function rol(){
        return $this->belongsTo(Rol::class,'idrol');
    }

    protected $hidden = [
        'password', // Ocultar el campo contr al serializar el modelo
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->password; 
    }

    public $timestamps = false;
}
