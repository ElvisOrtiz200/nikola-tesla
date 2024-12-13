<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimestre extends Model
{
    use HasFactory;
    protected $table = 'bimestre';
    protected $primaryKey = 'bim_sigla';
    public $incrementing = false; // Indicar que la clave primaria no es autoincremental
    protected $keyType = 'string'; 
    protected $fillable = [
          'bim_descripcion', 'anio', 'fecha_inicio', 'fecha_fin', 'estadoBIMESTRE'
    ];
    public $timestamps = false;
 
    public function EstudianteCurso(){
        return $this->hasMany(EstudianteCurso::class,'bim_sigla');
    }
    public function notas()
    {
        return $this->hasMany(AcadNota::class, 'bim_sigla', 'bim_sigla');
    }

    public function proemdio()
    {
        return $this->hasMany(promediofinal::class, 'bim_sigla', 'bim_sigla');
    }
}
