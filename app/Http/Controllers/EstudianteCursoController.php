<?php

namespace App\Http\Controllers;

use App\Models\AcadNota;
use App\Models\Asistencia;
use App\Models\Bimestre;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use App\Models\Curso_Docente;
use App\Models\Estudiante;
use App\Models\EstudianteCurso;
use App\Models\Grado;
use App\Models\Hora;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AuditoriaLog;

class EstudianteCursoController extends Controller
{ 

    public function index()
    {
        return view('asignarStuCurso.index');
    }
 
    public function create()
    {
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $grado = Grado::join('acad_nivel','acad_grado.id_nivel','=','acad_nivel.id_nivel')->select(
            'acad_grado.id_grado as id_grado',
            'acad_grado.nombre as grado',
            'acad_nivel.nombre as nivel' 
        )->where('acad_grado.estado','=',$anioActual)->get();
        //se muestra aquellos estudiantes que no pertenecen a ningun 
        $estudiantes = Estudiante::leftJoin('acad_estudiantes_cursos', function ($join) use ($anioActual) {
            $join->on('acad_estudiantes.alu_dni', '=', 'acad_estudiantes_cursos.alu_dni')
                 ->where('acad_estudiantes_cursos.estado', '=', $anioActual);
        })
        ->whereNull('acad_estudiantes_cursos.alu_dni') // Solo estudiantes sin registro para el año actual.
        ->select('acad_estudiantes.alu_dni', 'acad_estudiantes.alu_apellidos', 'acad_estudiantes.alu_nombres')
        ->orderBy('acad_estudiantes.alu_apellidos', 'asc') // Ordenar por apellidos en orden ascendente.
        ->get();
        $bimestre = Bimestre::where('estadoBIMESTRE','=','1')->get();
        return view('asignarStuCurso.crear', compact('grado','estudiantes','bimestre'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud para asegurarse de que se pasen los datos correctos
        $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $request->validate([
            'id_grado' => 'required|integer',
            'estudiantes' => 'required|array',
            'estudiantes.*' => 'required|string|max:8',
        ]);
        // dd($request);
        // Obtener el grado y los estudiantes del request
        $id_grado = $request->input('id_grado');
        $estudiantes = $request->input('estudiantes');

        // Buscar todos los cursos en carga docente que correspondan al grado seleccionado
        $cursosDocente2 = Curso::where('id_grado', '=', $id_grado)->pluck('acu_id')->toArray();
        $cursos2 = Curso_Docente::where('id_grado', $id_grado)->pluck('acu_id')->toArray();

        $cursos = Curso_Docente::where('id_grado', $id_grado)->pluck('acdo_id')->toArray();
       
        
        $diff1 = array_diff($cursosDocente2, $cursos2);
        // dd( $diff1 );
        // Si hay diferencias, devolver un mensaje de error
        if (!empty($diff1) ) {
            // dd('novacio');
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('error', 'En este grado hay cursos que no tienen un docente asignado.', 1));
        }
        // dd('vacio');
        // dd($request, $cursos, $estudiantes);
        // Verificar si se encontraron cursos para ese grado
        if (empty($cursos)) {
            return response()->json(['error' => 'No se encontraron cursos para el grado seleccionado'], 404);
        }
        
        // Iniciar transacción
        DB::beginTransaction();
        try {
            // Para cada estudiante, insertar una entrada en acad_estudiantes_cursos por cada curso encontrado
            foreach ($estudiantes as $alu_dni) {
                foreach ($cursos as $acdo_id) {
                    EstudianteCurso::create([
                        'alu_dni' => $alu_dni,
                        'acdo_id' => $acdo_id,
                        'bim_sigla' => $request->input('bim_sigla'), // Suponiendo que también necesitas la sigla del bimestre
                        'estado' => $anio

                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'EstudianteCurso';
            $auditoria->save();

            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Revertir si ocurre un error
            DB::rollBack();
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

    

    public function show(Request $request){
        $search = $request->input('search'); // Recoge el término de búsqueda
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $estudiantesGrados = DB::table('acad_estudiantes as e')
            ->join('acad_estudiantes_cursos as ec', 'e.alu_dni', '=', 'ec.alu_dni')
            ->join('acad_carga_docente as cd', 'ec.acdo_id', '=', 'cd.acdo_id')
            ->join('acad_grado as g', 'cd.id_grado', '=', 'g.id_grado')
            ->join('acad_nivel as n', 'g.id_nivel', '=', 'n.id_nivel') // Join con acad_nivel
          
            ->select(
                'e.alu_dni',
                'e.alu_nombres',
                'e.alu_apellidos',
                'g.id_grado',
                'g.nombre as grado_nombre',
                'n.nombre as nivel_nombre' // Selecciona el nombre del nivel
            )  ->where('ec.estado','=',$anio)
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('e.alu_dni', 'like', "%{$search}%")
                        ->orWhere('e.alu_nombres', 'like', "%{$search}%")
                        ->orWhere('e.alu_apellidos', 'like', "%{$search}%");
                });
            })
            ->groupBy('e.alu_dni', 'e.alu_nombres', 'e.alu_apellidos', 'g.id_grado', 'grado_nombre', 'nivel_nombre')
            ->paginate(10);
    
        return view('asignarStuCurso.editar', compact('estudiantesGrados', 'search'));
    }

    public function listar(Request $request)
    {
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $search = $request->input('search'); // Recoge el término de búsqueda
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'EstudianteCurso';
            $auditoria->save();
        $estudiantesGrados = DB::table('acad_estudiantes as e')
            ->join('acad_estudiantes_cursos as ec', 'e.alu_dni', '=', 'ec.alu_dni')
            ->join('acad_carga_docente as cd', 'ec.acdo_id', '=', 'cd.acdo_id')
            ->join('acad_grado as g', 'cd.id_grado', '=', 'g.id_grado')
            ->join('acad_nivel as n', 'g.id_nivel', '=', 'n.id_nivel') // Join con acad_nivel
            ->select(
                'e.alu_dni',
                'e.alu_nombres',
                'e.alu_apellidos',
                'g.id_grado',
                'g.nombre as grado_nombre',
                'n.nombre as nivel_nombre' // Selecciona el nombre del nivel
            )->where('ec.estado','=',$anio)
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('e.alu_dni', 'like', "%{$search}%")
                        ->orWhere('e.alu_nombres', 'like', "%{$search}%")
                        ->orWhere('e.alu_apellidos', 'like', "%{$search}%");
                });
            })
            ->groupBy('e.alu_dni', 'e.alu_nombres', 'e.alu_apellidos', 'g.id_grado', 'grado_nombre', 'nivel_nombre')
            ->paginate(10);
    
        return view('asignarStuCurso.listar', compact('estudiantesGrados', 'search'));
    }
    
    
public function editando($alu_dni)
{$anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    // Obtener datos del estudiante y su grado actual
    $estudiante = DB::table('acad_estudiantes as e')
        ->join('acad_estudiantes_cursos as ec', 'e.alu_dni', '=', 'ec.alu_dni')
        ->join('acad_carga_docente as cd', 'ec.acdo_id', '=', 'cd.acdo_id')
        ->join('acad_grado as g', 'cd.id_grado', '=', 'g.id_grado')
        ->join('acad_nivel as n', 'g.id_nivel', '=', 'n.id_nivel')
        ->select(
            'e.alu_dni',
            'e.alu_nombres',
            'e.alu_apellidos',
            'g.id_grado',
            'g.nombre as grado_nombre',
            'n.id_nivel',
            'n.nombre as nivel_nombre'
        )->where('ec.estado','=',$anio)
        ->where('e.alu_dni', $alu_dni)
        ->first();

    // Obtener grados y niveles disponibles
    $grados = DB::table('acad_grado')
        ->join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
        ->select('acad_grado.id_grado', 'acad_grado.nombre as grado_nombre', 'acad_nivel.nombre as nivel_nombre')->where('acad_grado.estado','=',$anio)
        ->get();

    return view('asignarStuCurso.editando', compact('estudiante', 'grados'));
}





public function update(Request $request, $id)
{
    // Obtener el grado y el alumno (alu_dni) desde el request
    $id_grado = $request->input('grado'); // El grado al que se va a cambiar el estudiante
    $alu_dni = $id; // Usamos el 'id' de la ruta, que es el 'alu_dni'
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
    // Obtener los registros actuales del estudiante en la tabla 'acad_estudiantes_cursos'
    $registros = EstudianteCurso::where('alu_dni', $alu_dni)->get();

    // Verificar si existen registros para el estudiante
    if ($registros->isEmpty()) {
        return response()->json(['error' => 'No se encontraron registros para el estudiante'], 404);
    }

    // Eliminar los registros actuales para el estudiante
    $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');

    // Eliminar de EstudianteCurso solo si la columna 'estado' es igual al $anio
    EstudianteCurso::where('alu_dni', $alu_dni)
        ->where('estado', '=', $anio)  // Condición adicional
        ->delete();

    // Eliminar de AcadNota solo si la columna 'bim_sigla' es igual al $bimSigla
    AcadNota::where('alu_dni', $alu_dni)
        ->where('bim_sigla', '=', $bimSigla)  // Condición adicional
        ->delete();

    // Eliminar de Asistencia solo si la columna 'estado' es igual al $anio
    Asistencia::where('alu_dni', $alu_dni)
        ->where('estado', '=', $anio)  // Condición adicional
        ->delete();
    $cursosDocente2 = Curso::where('id_grado', '=', $id_grado)->pluck('acu_id')->toArray();
    $cursos2 = Curso_Docente::where('id_grado', $id_grado)->pluck('acu_id')->toArray();
    $cursos = Curso_Docente::where('id_grado', $id_grado)->pluck('acdo_id')->toArray();
    $diff1 = array_diff($cursosDocente2, $cursos2);
    if (!empty($diff1) ) {
                     return redirect()->route('estudiante-curso.create')
                         ->withCookie(cookie('error', 'En este grado hay cursos que no tienen un docente asignado.', 1));
    }
    if (empty($cursos)) {
             return response()->json(['error' => 'No se encontraron cursos para el grado seleccionado'], 404);
         }
  
    foreach ($cursos as $acdo_id) {
    EstudianteCurso::create([
        'alu_dni' => $alu_dni,
        'acdo_id' => $acdo_id,
        'bim_sigla' => $bimSigla, // Suponiendo que también necesitas la sigla del bimestre
        'estado' => $anio
    ]);
    }

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'EstudianteCurso';
            $auditoria->save();

    return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));

}

public function eliminar(Request $request){
    $search = $request->input('search'); // Recoge el término de búsqueda
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $estudiantesGrados = DB::table('acad_estudiantes as e')
        ->join('acad_estudiantes_cursos as ec', 'e.alu_dni', '=', 'ec.alu_dni')
        ->join('acad_carga_docente as cd', 'ec.acdo_id', '=', 'cd.acdo_id')
        ->join('acad_grado as g', 'cd.id_grado', '=', 'g.id_grado')
        ->join('acad_nivel as n', 'g.id_nivel', '=', 'n.id_nivel') // Join con acad_nivel
        ->select(
            'e.alu_dni',
            'e.alu_nombres',
            'e.alu_apellidos',
            'g.id_grado',
            'g.nombre as grado_nombre',
            'n.nombre as nivel_nombre' // Selecciona el nombre del nivel
        )->where('ec.estado','=',$anio)
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('e.alu_dni', 'like', "%{$search}%")
                    ->orWhere('e.alu_nombres', 'like', "%{$search}%")
                    ->orWhere('e.alu_apellidos', 'like', "%{$search}%");
            });
        })
        ->groupBy('e.alu_dni', 'e.alu_nombres', 'e.alu_apellidos', 'g.id_grado', 'grado_nombre', 'nivel_nombre')
        ->paginate(10);

    return view('asignarStuCurso.eliminar', compact('estudiantesGrados', 'search'));
}


public function eliminando($alu_dni)
{
    // Obtener datos del estudiante y su grado actual
    $estudiante = DB::table('acad_estudiantes as e')
        ->join('acad_estudiantes_cursos as ec', 'e.alu_dni', '=', 'ec.alu_dni')
        ->join('acad_carga_docente as cd', 'ec.acdo_id', '=', 'cd.acdo_id')
        ->join('acad_grado as g', 'cd.id_grado', '=', 'g.id_grado')
        ->join('acad_nivel as n', 'g.id_nivel', '=', 'n.id_nivel')
        ->select(
            'e.alu_dni',
            'e.alu_nombres',
            'e.alu_apellidos',
            'g.id_grado',
            'g.nombre as grado_nombre',
            'n.id_nivel',
            'n.nombre as nivel_nombre'
        )
        ->where('e.alu_dni', $alu_dni)
        ->first();

    // Obtener grados y niveles disponibles
    $grados = DB::table('acad_grado')
        ->join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
        ->select('acad_grado.id_grado', 'acad_grado.nombre as grado_nombre', 'acad_nivel.nombre as nivel_nombre')
        ->get();

    return view('asignarStuCurso.eiminando', compact('estudiante', 'grados'));
}


public function destroy(Request $request, $id)
{
    // Obtener el grado y el alumno (alu_dni) desde el request
    $id_grado = $request->input('grado'); // El grado al que se va a cambiar el estudiante
    $alu_dni = $id; // Usamos el 'id' de la ruta, que es el 'alu_dni'

    // Obtener los registros actuales del estudiante en la tabla 'acad_estudiantes_cursos'
    $registros = EstudianteCurso::where('alu_dni', $alu_dni)->get();

    // Verificar si existen registros para el estudiante
    if ($registros->isEmpty()) {
        return response()->json(['error' => 'No se encontraron registros para el estudiante'], 404);
    }

    // Eliminar los registros actuales para el estudiante
    $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');

    // Eliminar de EstudianteCurso solo si la columna 'estado' es igual al $anio
    EstudianteCurso::where('alu_dni', $alu_dni)
        ->where('estado', '=', $anio)  // Condición adicional
        ->delete();

    // Eliminar de AcadNota solo si la columna 'bim_sigla' es igual al $bimSigla
    AcadNota::where('alu_dni', $alu_dni)
        ->where('bim_sigla', '=', $bimSigla)  // Condición adicional
        ->delete();

    // Eliminar de Asistencia solo si la columna 'estado' es igual al $anio
    Asistencia::where('alu_dni', $alu_dni)
        ->where('estado', '=', $anio)  // Condición adicional
        ->delete();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'EstudianteCurso';
            $auditoria->save();

    return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));

}



}


// public function store(Request $request)
//     {
//         // Validar la solicitud para asegurarse de que se pasen los datos correctos
//         $request->validate([
//             'id_grado' => 'required|integer',
//             'estudiantes' => 'required|array',
//             'estudiantes.*' => 'required|string|max:8',
//         ]);
//         // dd($request);
//         // Obtener el grado y los estudiantes del request
//         $id_grado = $request->input('id_grado');
//         $estudiantes = $request->input('estudiantes');

//         // Buscar todos los cursos en carga docente que correspondan al grado seleccionado
//         $cursosDocente2 = Curso::where('id_grado', '=', $id_grado)->pluck('acu_id')->toArray();
//         $cursos2 = Curso_Docente::where('id_grado', $id_grado)->pluck('acu_id')->toArray();

//         $cursos = Curso_Docente::where('id_grado', $id_grado)->pluck('acdo_id')->toArray();
       
        
//         $diff1 = array_diff($cursosDocente2, $cursos2);
//         // dd( $diff1 );
//         // Si hay diferencias, devolver un mensaje de error
//         if (!empty($diff1) ) {
//             // dd('novacio');
//             return redirect()->route('estudiante-curso.create')
//                 ->withCookie(cookie('error', 'En este grado hay cursos que no tienen un docente asignado.', 1));
//         }
//         // dd('vacio');
//         // dd($request, $cursos, $estudiantes);
//         // Verificar si se encontraron cursos para ese grado
//         if (empty($cursos)) {
//             return response()->json(['error' => 'No se encontraron cursos para el grado seleccionado'], 404);
//         }
        
//         // Iniciar transacción
//         DB::beginTransaction();
//         try {
//             // Para cada estudiante, insertar una entrada en acad_estudiantes_cursos por cada curso encontrado
//             foreach ($estudiantes as $alu_dni) {
//                 foreach ($cursos as $acdo_id) {
//                     EstudianteCurso::create([
//                         'alu_dni' => $alu_dni,
//                         'acdo_id' => $acdo_id,
//                         'bim_sigla' => $request->input('bim_sigla') // Suponiendo que también necesitas la sigla del bimestre
//                     ]);
//                 }
//             }

//             // Confirmar la transacción
//             DB::commit();
//             return redirect()->route('estudiante-curso.create')
//                 ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));
//         } catch (\Exception $e) {
//             // Revertir si ocurre un error
//             DB::rollBack();
//             return redirect()->route('estudiante-curso.create')
//                 ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
//         }
//     }
