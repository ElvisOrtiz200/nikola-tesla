<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Curso_Docente;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\RecursosHumanos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Curso_DocenteController extends Controller
{
    public function index()
    {

        return view('cursoDocente.index');
    }
 

    public function create()
    {
        // $grado = Grado::all();
        $docentes = Docente::join('rrhh_personal','docentes.per_id','=','rrhh_personal.per_id')->select('rrhh_personal.per_apellidos as apellidosDoc',
        'rrhh_personal.per_nombres as nombresDoc','rrhh_personal.per_id as per_id')->get();
        $cursos = Curso::all();
        return view('cursoDocente.crear', compact('docentes','cursos'));
    }
 
    public function store(Request $request) {
        //
        try {
            $validator = Validator::make($request->all(), [
                'acu_id' => 'required|exists:acad_cursos,acu_id',    // Valida que acu_id exista en la tabla de cursos
                'per_id' => 'required|exists:rrhh_personal,per_id',  // Valida que per_id exista en la tabla de personal (docentes)
                'acdo_estado' => 'required|boolean',
                'acdo_anio' => 'required|integer',
                'acdo_fecha_ini' => 'required|date',
                'acdo_fecha_fin' => 'required|date|after_or_equal:acdo_fecha_ini',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            // Crear el registro en la tabla intermedia
            $cursoDocente = new Curso_Docente();
            $cursoDocente->acu_id = $request->acu_id;
            $cursoDocente->per_id = $request->per_id;
            $cursoDocente->acdo_estado = $request->acdo_estado;
            $cursoDocente->acdo_anio = $request->acdo_anio;
            $cursoDocente->acdo_fecha_ini = $request->acdo_fecha_ini;
            $cursoDocente->acdo_fecha_fin = $request->acdo_fecha_fin;
            $cursoDocente->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('curso-docente.create')
                ->withCookie(cookie('success', 'Registro guardado correctamente', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('curso-docente.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
}
