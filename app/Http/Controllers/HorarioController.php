<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\DiaSemana;
use App\Models\Grado;
use App\Models\Hora;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;


class HorarioController extends Controller
{
    public function index()
    {
        return view('horario.index');
    }

    public function getCursosByGrado($gradoId)
{
    try {
        $cursos = Curso::where('id_grado', $gradoId)->get();

        // Verifica que la consulta devuelve datos
        if ($cursos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron cursos para este grado'], 404);
        }

        return response()->json($cursos);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error: ' . $e->getMessage()], 500);
    }
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
    
        // Validar los horarios en base a los datos enviados
        foreach ($horarios as $horarioData) {
            // Crear el validador para verificar la existencia de horarios duplicados
            $validator = FacadesValidator::make($horarioData, [
                'id_grado' => 'required|exists:acad_grado,id_grado',
                'idDiaSemana' => 'required|exists:diassemana,idDiaSemana',
                'idHora' => 'required|exists:hora,idHora',
            ]);
    
            // Si la validación falla, redirige con el mensaje de error
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('horario.create')
                                 ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
    
            // Verificar si ya existe un horario con el mismo grado, día y hora
            $existeHorario = Horario::where('id_grado', $horarioData['id_grado'])
                                    ->where('idDiaSemana', $horarioData['idDiaSemana'])
                                    ->where('idHora', $horarioData['idHora'])
                                    ->exists();
    
            // Si ya existe un horario, devolver un error
            if ($existeHorario) {
                return redirect()->route('horario.create')
                                 ->withCookie(cookie('error', 'Ya existe un horario registrado para este grado.', 1, '/', null, false, false));
            }
    
            // Si no existe, guardar el horario
            Horario::create([
                'acu_id' => $horarioData['acu_id'],
                'idDiaSemana' => $horarioData['idDiaSemana'],
                'idHora' => $horarioData['idHora'],
                'id_grado' => $horarioData['id_grado'],
            ]);
        }
    
        // Si todo sale bien, redirigir con mensaje de éxito
        return redirect()->route('horario.create')
                         ->withCookie(cookie('success', 'Horario registrado con éxito.', 1, '/', null, false, false));
    }
    

 
    public function show(Request $request){
        $query = Grado::join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
                  ->select('acad_grado.id_grado as id_grado', 'acad_grado.nombre as grado', 'acad_nivel.nombre as nivel');

    // Condición para filtrar grados que tengan al menos un horario asociado
    $query->whereHas('horario', function ($query) {
        $query->whereNotNull('id_grado');
    });

    $grado = $query->paginate(10); // Pagina los resultados
    return view('horario.editar', compact('grado'));
    }

    public function editando($id)
{
    // Consulta los horarios asociados al grado
    $horarios = Horario::with(['grado', 'diaSemana', 'hora', 'curso'])->where('id_grado', $id)->get();

    // Realiza un INNER JOIN entre cursos y grados para obtener solo los cursos que pertenecen al grado
    $cursos = DB::table('acad_cursos')
        ->join('acad_grado', 'acad_cursos.id_grado', '=', 'acad_grado.id_grado')
        ->where('acad_grado.id_grado', $id)
        ->select('acad_cursos.acu_id', 'acad_cursos.acu_nombre')
        ->get();

    // Obtener los días de la semana y las horas
    $diaSemana = DiaSemana::all();
    $horas = Hora::all();
    
    return view('horario.editando', compact('horarios', 'diaSemana', 'horas', 'cursos'));
}


public function update(Request $request, $id_grado)
{
    $horarios = $request->input('horarios'); // Datos enviados desde el formulario

    if (!$horarios) {
        return redirect()->route('horario.show')
            ->withCookie(cookie('error', 'No se recibieron datos del horario.', 1));
    }

    // Decodificar los horarios enviados
    $parsedHorarios = collect($horarios)->map(function ($horario) {
        return json_decode($horario, true);
    });

    // Lista de claves únicas para las filas actualizadas
    $actualizarClaves = [];

    foreach ($parsedHorarios as $data) {
        if (!empty($data['day']) && !empty($data['hour']) && !empty($data['course'])) {
            // Mapear los IDs
            $idDiaSemana = DiaSemana::where('nombreDia', $data['day'])->value('idDiaSemana');
            $idHora = Hora::where('nombreHora', $data['hour'])->value('idHora');
            $acu_id = Curso::where('acu_nombre', $data['course'])->value('acu_id');

            if ($idDiaSemana && $idHora && $acu_id) {
                // Actualizar o crear la fila correspondiente
                $horario = Horario::updateOrCreate(
                    [
                        'id_grado' => $id_grado,
                        'idDiaSemana' => $idDiaSemana,
                        'idHora' => $idHora,
                    ],
                    [
                        'acu_id' => $acu_id,
                    ]
                );

                // Agregar la clave única de la fila actualizada
                $actualizarClaves[] = $horario->idHorario;
            }
        }
    }

    // Actualizar a NULL las filas no incluidas en el JSON enviado
    Horario::where('id_grado', $id_grado)
        ->whereNotIn('idHorario', $actualizarClaves)
        ->update([
            'acu_id' => null,
        ]);

    return redirect()->route('horario.index')->with('success', 'Horario actualizado con éxito.');
}



public function eliminar()
    { // Obtiene todos los grados con sus horarios
        $query = Grado::join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
        ->select('acad_grado.id_grado as id_grado', 'acad_grado.nombre as grado', 'acad_nivel.nombre as nivel');

// Condición para filtrar grados que tengan al menos un horario asociado
$query->whereHas('horario', function ($query) {
$query->whereNotNull('id_grado');
});

$grado = $query->paginate(10); // Pagina los resultados
return view('horario.eliminar', compact('grado'));
    }

    public function destroyByGrado($id_grado)
    {
        try {
            // Eliminar todos los horarios asociados al id_grado
            $horariosEliminados = Horario::where('id_grado', $id_grado)->delete();
    
            if ($horariosEliminados) {
                // Redireccionar con mensaje de éxito
                return redirect()->route('horario.eliminar')->withCookie(cookie('success', 'Horarios eliminados con éxito.', 1));
            } else {
                // Si no se eliminó ningún horario
                return redirect()->route('horario.eliminar')->withCookie(cookie('error', 'No se encontraron horarios para eliminar.', 1));
            }
        } catch (\Exception $e) {
            // Redireccionar con mensaje de error
            return redirect()->route('horario.eliminar')->withCookie(cookie('error', 'Ocurrió un error al eliminar los horarios.', 1));
        }
    }





    public function listar()
    {
        $grados = DB::table('acad_grado')->get(); // Recupera todos los grados académicos
        return view('horario.listar', compact('grados'));
    }

    // Muestra el horario detallado de un grado académico
    public function showHorario($id_grado)
{
    // Obtener los días de la semana y las horas
    $dias = DB::table('diassemana')->get();
    $horas = DB::table('hora')->get();

    // Obtener los horarios específicos para el grado
    $horarios = DB::table('horario')
        ->join('hora', 'horario.idHora', '=', 'hora.idHora')
        ->join('diassemana', 'horario.idDiaSemana', '=', 'diassemana.idDiaSemana')
        ->join('acad_cursos', 'horario.acu_id', '=', 'acad_cursos.acu_id')
        ->where('horario.id_grado', $id_grado)
        ->select('hora.nombreHora', 'diassemana.nombreDia', 'acad_cursos.acu_nombre')
        ->get();

    if ($horarios->isEmpty()) {
        return view('horario.showhorario', ['mensaje' => 'No hay horario registrado para este grado.', 'dias' => $dias, 'horas' => $horas]);
    }

    return view('horario.showhorario', compact('horarios', 'dias', 'horas'));
}

    

}
