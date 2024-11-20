<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\DiaSemana;
use App\Models\Grado;
use App\Models\Hora;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return view('horario.index');
    }
 
    public function create()
    {
        $grado = Grado::join('acad_nivel','acad_grado.id_nivel','=','acad_nivel.id_nivel')->select(
            'acad_grado.id_grado as id_grado',
            'acad_grado.nombre as grado',
            'acad_nivel.nombre as nivel' 
        )->get();
        $diaSemana = DiaSemana::all();
        $cursos = Curso::all();
        $horas = Hora::all();
        return view('horario.crear', compact('grado','diaSemana','horas','cursos'));
    }

 
    public function store(Request $request)
{
    
    $horarios = json_decode($request->input('horarios'), true); // Decodificas el JSON

    // Recorres cada horario y lo guardas
    foreach ($horarios as $horarioData) {
        // Aquí puedes procesar cada horarioData antes de guardarlo si es necesario
        Horario::create([
            'acu_id' => $horarioData['acu_id'], // Si es null, Laravel lo manejará
            'idDiaSemana' => $horarioData['idDiaSemana'],
            'idHora' => $horarioData['idHora'],
            'id_grado' => $horarioData['id_grado'],
        ]);
    }
    
    // Respuesta de éxito
    return response()->json(['message' => 'Horarios guardados correctamente'], 201);
    
}
 
    public function show(Request $request){
        $query = Horario::query();

        // if ($request->has('search') && $request->search != '') {
        //     $query->where('apo_dni', 'like', '%' . $request->search . '%');
        // }

        // $horarios = $query->paginate(4); // Cambia esto para paginación
        $grado = Grado::join('acad_nivel','acad_grado.id_nivel','=','acad_nivel.id_nivel')->select(
            'acad_grado.id_grado as id_grado',
            'acad_grado.nombre as grado',
            'acad_nivel.nombre as nivel' 
        )->paginate(10);
        return view('horario.editar', compact('grado'));
    }

    public function editando($id)
    {
        $horarios = Horario::with(['diaSemana','hora','curso'])->where('id_grado', $id)->get();
        return view('horario.editando', compact('horarios'));
    }

}
