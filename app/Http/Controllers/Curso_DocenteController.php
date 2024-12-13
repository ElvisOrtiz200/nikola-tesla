<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Curso_Docente;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\RecursosHumanos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\AuditoriaLog;
use App\Models\Bimestre;

class Curso_DocenteController extends Controller
{
    public function index()
    {

        return view('cursoDocente.index');
    }
 

    public function create()
    {
        // $grado = Grado::all();
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $docentes = Docente::join('rrhh_personal','docentes.per_id','=','rrhh_personal.per_id')->select('rrhh_personal.per_apellidos as apellidosDoc',
        'rrhh_personal.per_nombres as nombresDoc','rrhh_personal.per_id as per_id')->get();
        $cursos = Curso::where('estado','=',$anio);
        $grado = Grado::join('acad_nivel','acad_grado.id_nivel','=','acad_nivel.id_nivel')->select(
            'acad_grado.id_grado as id_grado',
            'acad_grado.nombre as grado',
            'acad_nivel.nombre as nivel' 
        )->where('acad_grado.estado', $anio)->get();
  
        $cursos = Curso::where('estado','=', $anio);
        return view('cursoDocente.crear', compact('docentes','cursos','grado'));
    }
 
    public function store(Request $request) {
        //
        try {
            $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            $validator = Validator::make($request->all(), [
                'acu_id' => 'required|exists:acad_cursos,acu_id',    // Valida que acu_id exista en la tabla de cursos
                'per_id' => 'required|exists:rrhh_personal,per_id',  // Valida que per_id exista en la tabla de personal (docentes)
                
               
                'acdo_fecha_ini' => 'required|date',
                'acdo_fecha_fin' => 'required|date|after_or_equal:acdo_fecha_ini',
                'id_grado' => 'required'
            ]);
            // dd($request);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            // Crear el registro en la tabla intermedia
            $cursoDocente = new Curso_Docente();
            $cursoDocente->acu_id = $request->acu_id;
            $cursoDocente->id_grado = $request->id_grado;

            $cursoDocente->per_id = $request->per_id;
            $cursoDocente->acdo_estado = 'A';
            $cursoDocente->acdo_anio = '2024';
            $cursoDocente->acdo_fecha_ini = $request->acdo_fecha_ini;
            $cursoDocente->acdo_fecha_fin = $request->acdo_fecha_fin;
            $cursoDocente->estado = $anio;

            $cursoDocente->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'CursoDocente';
            $auditoria->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('curso-docente.create')
                ->withCookie(cookie('success', 'Registro guardado correctamente', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('curso-docente.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }


    public function show()
    {
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $cargasDocentes = Curso_Docente::with(['curso', 'docente', 'grado'])->where('estado','=',$anio)->get();

        return view('cursoDocente.editar', compact('cargasDocentes'));
    }


    public function editando($id)
    {
        // Recupera el registro del curso-docente con el id proporcionado
    $cursoDocente = Curso_Docente::with(['grado', 'curso', 'docente'])->findOrFail($id);
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');

    // Recupera todos los grados, cursos y docentes
    $grados = Grado::where('estado','=',$anio)->get();
    $cursos = Curso::where('estado','=',$anio)->get();
   // En el controlador
    $docentes = Docente::with('personal')->get();


    // Pasa los datos a la vista para mostrar el formulario con los valores actuales
    return view('cursoDocente.editando', compact('cursoDocente', 'grados', 'cursos', 'docentes'));
    }


    // Controlador
public function update(Request $request, $id)
{
    // Buscar el registro por ID
    $cursoDocente = Curso_Docente::findOrFail($id);
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    // Validación de los datos
    $validated = $request->validate([
        'id_grado' => 'required|integer',
        'acu_id' => 'required|integer',
        'per_id' => 'required|integer',
        'acdo_fecha_ini' => 'required|date',
        'acdo_fecha_fin' => 'required|date',
    ]);

    // Asignar los datos a los campos correspondientes
    $cursoDocente->id_grado = $validated['id_grado'];
    $cursoDocente->acu_id = $validated['acu_id'];
    $cursoDocente->per_id = $validated['per_id'];
    $cursoDocente->acdo_fecha_ini = $validated['acdo_fecha_ini'];
    $cursoDocente->acdo_fecha_fin = $validated['acdo_fecha_fin'];

    // Asignar valores internos
    $cursoDocente->acdo_estado = 'A';  // Estado predeterminado 'A' (Activo)
    $cursoDocente->acdo_anio = date('Y');  // Año actual
    $cursoDocente->estado = $anio;  // Año actual
    // Guardar cambios
    $cursoDocente->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'CursoDocente';
            $auditoria->save();

    // Redirigir o devolver la respuesta
    return redirect()->route('curso-docente.show') // Cambia a la ruta que desees
    ->withCookie(cookie('success', 'Actualizado con éxito.', 1, '/', null, false, false));
}


public function eliminar()
{
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $cargasDocentes = Curso_Docente::with(['curso', 'docente', 'grado'])->where('estado','=',$anio)->get();

    return view('cursoDocente.eliminar', compact('cargasDocentes'));
}


public function eliminando($id)
    {
        // Recupera el registro del curso-docente con el id proporcionado
    $cursoDocente = Curso_Docente::with(['grado', 'curso', 'docente'])->findOrFail($id);

    // Recupera todos los grados, cursos y docentes
    $grados = Grado::all();
    $cursos = Curso::all();
   // En el controlador
    $docentes = Docente::with('personal')->get();


    // Pasa los datos a la vista para mostrar el formulario con los valores actuales
    return view('cursoDocente.eliminando', compact('cursoDocente', 'grados', 'cursos', 'docentes'));
    }



    public function delete($id, Request $request)
    {
        // Encuentra el curso docente por su ID y elimínalo
        $cursoDocente = Curso_Docente::find($id);

        if ($cursoDocente) {
            $cursoDocente->delete();  // Elimina el registro
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'CursoDocente';
            $auditoria->save();
        return redirect()->route('curso-docente.create') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'eliminado con éxito.', 1, '/', null, false, false));}
    }


    public function listar(Request $request)
{
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $auditoria = new AuditoriaLog();
    $auditoria->usuario = $request->cookie('user_name');
    $auditoria->operacion = 'R';
    $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
    $auditoria->entidad = 'CursoDocente';
    $auditoria->save();
    $cargasDocentes = Curso_Docente::with(['curso', 'docente', 'grado'])->where('estado','=',$anio)->get();

    return view('cursoDocente.listar', compact('cargasDocentes'));
}
}
