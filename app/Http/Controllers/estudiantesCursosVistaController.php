<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Grado;
use App\Models\Horario;
use App\Models\RecursoAcademico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class estudiantesCursosVistaController extends Controller
{
    public function obtenerCursos(Request $request)
    {
        // Recuperar el usuario desde la cookie
        $usuarioDni = $request->cookie('user_name');

        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Consulta utilizando Eloquent y Builder
        $cursos = DB::table('auth_usuario as au')
            ->join('acad_estudiantes as ae', 'au.alu_dni', '=', 'ae.alu_dni')
            ->join('acad_estudiantes_cursos as aec', 'ae.alu_dni', '=', 'aec.alu_dni')
            ->join('acad_carga_docente as acd', 'aec.acdo_id', '=', 'acd.acdo_id')
            ->join('acad_grado as ag', 'acd.id_grado', '=', 'ag.id_grado')
            ->join('acad_cursos as ac', 'ag.id_grado', '=', 'ac.id_grado')
            ->select('ac.acu_nombre', 'ac.acu_id')
            ->distinct()
            ->where('au.alu_dni', $usuarioDni)
            ->get();

        // Retornar los resultados como JSON
        return view('vistaEstudiante.cursosxestudiante', compact('cursos'));
    }





    public function show(Request $request)
    {
        // Recuperar el usuario desde la cookie
        $usuarioDni = $request->cookie('user_name');

        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Obtener el grado del alumno
        $gradoAlumno = DB::table('auth_usuario as au')
            ->join('acad_estudiantes as ae', 'au.alu_dni', '=', 'ae.alu_dni')
            ->join('acad_estudiantes_cursos as aec', 'ae.alu_dni', '=', 'aec.alu_dni')
            ->join('acad_carga_docente as acd', 'aec.acdo_id', '=', 'acd.acdo_id')
            ->join('acad_grado as ag', 'acd.id_grado', '=', 'ag.id_grado')
            ->join('acad_nivel as an', 'ag.id_nivel', '=', 'an.id_nivel')
            ->select('ag.id_grado', 'ag.nombre as grado', 'an.nombre as nivelNombre')
            ->where('au.alu_dni', $usuarioDni)
            ->first();
        // dd($gradoAlumno);
        if (!$gradoAlumno) {
            dd("hola1");
            $gradoAlumno = 'vacio';
            
            // return response()->json(['error' => 'No se encontró el grado del alumno.'], 404);
        } else {
            // dd("Hola33");
            // Obtener los cursos del usuario para el grado
            $cursos = DB::table('auth_usuario as au')
                ->join('acad_estudiantes as ae', 'au.alu_dni', '=', 'ae.alu_dni')
                ->join('acad_estudiantes_cursos as aec', 'ae.alu_dni', '=', 'aec.alu_dni')
                ->join('acad_carga_docente as acd', 'aec.acdo_id', '=', 'acd.acdo_id')
                ->join('acad_grado as ag', 'acd.id_grado', '=', 'ag.id_grado')
                ->join('acad_cursos as ac', 'ag.id_grado', '=', 'ac.id_grado')
                ->select('ac.acu_nombre')
                ->distinct()
                ->where('au.alu_dni', $usuarioDni)
                ->where('ag.id_grado', $gradoAlumno->id_grado) // Filtrar por el grado del alumno
                ->get();
           
            // Obtener los horarios filtrados por el grado del alumno
            $horarios = Horario::with(['curso', 'hora', 'diaSemana'])
                ->whereHas('curso', function ($query) use ($gradoAlumno) {
                    $query->where('id_grado', $gradoAlumno->id_grado); // Filtrar horarios por el grado
                })
                ->get();
           
            // Obtener grados y niveles para paginación (si es necesario)
            $grado = Grado::join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
                ->select('acad_grado.id_grado as id_grado', 'acad_grado.nombre as Ngrado', 'acad_nivel.nombre as nivel')->get();
            
        }

        // dd($cursos, $horarios, $grado, $gradoAlumno);

        // Retornar vista con los datos
        return view('vistaEstudiante.horarioxestudiante', compact('cursos', 'horarios', 'grado', 'gradoAlumno'));
    }


    public function showCursoDetalle(Request $request, $id)
    {
        $curso = Curso::findOrFail($id); // O usar la relación con el estudiante si es necesario
        $usuarioDni = $request->cookie('user_name');

        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Consulta utilizando Eloquent y Builder
        $cursos = DB::table('auth_usuario as au')
            ->join('acad_estudiantes as ae', 'au.alu_dni', '=', 'ae.alu_dni')
            ->join('acad_estudiantes_cursos as aec', 'ae.alu_dni', '=', 'aec.alu_dni')
            ->join('acad_carga_docente as acd', 'aec.acdo_id', '=', 'acd.acdo_id')
            ->join('acad_grado as ag', 'acd.id_grado', '=', 'ag.id_grado')
            ->join('acad_cursos as ac', 'ag.id_grado', '=', 'ac.id_grado')
            ->select('ac.acu_nombre', 'ac.acu_id')
            ->distinct()
            ->where('au.alu_dni', $usuarioDni)
            ->get();



        // Filtrar los anuncios activos por curso
        $anuncios = Anuncio::where('estado', '=', 'A')
            ->where('id_curso', '=', $id)  // Relacionamos el anuncio con el curso
            ->get();
        // Formatear las fechas de los anuncios con Carbon
        foreach ($anuncios as $anuncio) {
            $anuncio->fecha_publicacion = Carbon::parse($anuncio->fecha_publicacion)->format('Y-m-d');
        }


        $recursos = RecursoAcademico::where('estado', '=', 'A')
            ->where('id_curso', '=', $id) // Filtrar por el curso
            ->get();

        // Formatear la fecha de subida con Carbon
        foreach ($recursos as $recurso) {
            $recurso->fecha_subida = Carbon::parse($recurso->fecha_subida)->format('Y-m-d');
        }

        $notas = DB::table('acad_estudiantes as ae')
            ->join('acad_notas as an', 'ae.alu_dni', '=', 'an.alu_dni')
            ->join('acad_carga_docente as acd', 'an.acdo_id', '=', 'acd.acdo_id')
            ->join('acad_cursos as ac', 'ac.acu_id', '=', 'acd.acu_id')
            ->select('an.nota', 'an.comentarios')
            ->where('ae.alu_dni', $usuarioDni)
            ->where('acd.acu_id', $id)
            ->get();



            $asistencias = DB::table('asistencia')
            ->join('acad_carga_docente', 'asistencia.acdo_id', '=', 'acad_carga_docente.acdo_id')
            ->join('acad_estudiantes', 'asistencia.alu_dni', '=', 'acad_estudiantes.alu_dni')
            ->where('acad_carga_docente.acu_id', $id)
            ->where('asistencia.alu_dni', $usuarioDni)
            ->select(
                'asistencia.fecha',
                'asistencia.alu_dni',
                'acad_estudiantes.alu_apellidos',
                'acad_estudiantes.alu_nombres',
                'asistencia.asistencia',
                'acad_carga_docente.acu_id'
            )
            ->orderBy('asistencia.fecha', 'desc')
            ->get()
            ->groupBy('fecha');
            // dd($asistencias);


        return view('vistaEstudiante.cursoDetalleIndex', compact('curso', 'cursos', 'anuncios', 'recursos', 'notas', 'asistencias')); // Mostrar una vista de detalles
    }





}
