<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Horario;
use App\Models\promediofinal;
use App\Models\RecursoAcademico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AuditoriaLog;
use App\Models\Bimestre;

class estudiantesCursosVistaController extends Controller
{
    public function obtenerCursos(Request $request)
    {
        // Recuperar el usuario desde la cookie
        $usuarioDni = $request->cookie('user_name');

        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }
        $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
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
            ->where('acd.estado',$anio)
            ->get();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'CursoEstudiante';
            $auditoria->save();

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
        $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        // Obtener el grado del alumno
        $gradoAlumno = DB::table('auth_usuario as au')
            ->join('acad_estudiantes as ae', 'au.alu_dni', '=', 'ae.alu_dni')
            ->join('acad_estudiantes_cursos as aec', 'ae.alu_dni', '=', 'aec.alu_dni')
            ->join('acad_carga_docente as acd', 'aec.acdo_id', '=', 'acd.acdo_id')
            ->join('acad_grado as ag', 'acd.id_grado', '=', 'ag.id_grado')
            ->join('acad_nivel as an', 'ag.id_nivel', '=', 'an.id_nivel')
            ->select('ag.id_grado', 'ag.nombre as grado', 'an.nombre as nivelNombre')
            ->where('au.alu_dni', $usuarioDni)
            ->where('acd.estado',$anio)
            ->first();
        // dd($gradoAlumno);
        if (!$gradoAlumno) {
            
            $gradoAlumno = 'vacio';
            $horarios = 'vacio';
            $cursos = 'vacio';
            $grado = 'vacio';
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
                ->where('acd.estado',$anio)
                ->get();
           
            // Obtener los horarios filtrados por el grado del alumno
            $horarios = Horario::with(['curso', 'hora', 'diaSemana'])->where('estado',$anio)
                ->whereHas('curso', function ($query) use ($gradoAlumno) {
                    $query->where('id_grado', $gradoAlumno->id_grado); // Filtrar horarios por el grado
                })
                ->get();
           
            // Obtener grados y niveles para paginación (si es necesario)
            $grado = Grado::join('acad_nivel', 'acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')
                ->select('acad_grado.id_grado as id_grado', 'acad_grado.nombre as Ngrado', 'acad_nivel.nombre as nivel')->where('acad_grado.estado',$anio)->get();
            
        }

        // dd($cursos, $horarios, $grado, $gradoAlumno);

        // Retornar vista con los datos
        return view('vistaEstudiante.horarioxestudiante', compact('cursos', 'horarios', 'grado', 'gradoAlumno'));
    }


    public function showCursoDetalle(Request $request, $id)
    {
        $curso = Curso::findOrFail($id); // O usar la relación con el estudiante si es necesario
        $usuarioDni = $request->cookie('user_name');
        $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $auditoria = new AuditoriaLog();
        $auditoria->usuario = $request->cookie('user_name');
        $auditoria->operacion = 'R';
        $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
        $auditoria->entidad = 'CursoEstudiante';
        $auditoria->save();
        
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
            ->where('acd.estado',$anio)
            ->get();



        // Filtrar los anuncios activos por curso
        $anuncios = Anuncio::where('estado', '=', 'A')
            ->where('id_curso', '=', $id)  // Relacionamos el anuncio con el curso
            ->where('estadobim',$bimSigla)
            ->get();
        // Formatear las fechas de los anuncios con Carbon
        foreach ($anuncios as $anuncio) {
            $anuncio->fecha_publicacion = Carbon::parse($anuncio->fecha_publicacion)->format('Y-m-d');
        }


        $recursos = RecursoAcademico::where('estado', '=', 'A')
            ->where('id_curso', '=', $id) // Filtrar por el curso
            ->where('estadobim',$bimSigla)
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
            ->where('acd.estado',$anio)
            ->where('ae.alu_dni', $usuarioDni)
            ->where('acd.acu_id', $id)
            ->get();
 
        //$mipromedio = promediofinal::where('alu_dni', '=', $usuarioDni)->get();
        $promedios2 = PromedioFinal::join('acad_estudiantes', 'promediofinal.alu_dni', '=', 'acad_estudiantes.alu_dni')
        ->join('acad_carga_docente', 'promediofinal.acdo_id', '=', 'acad_carga_docente.acdo_id')
        ->join('bimestre', 'promediofinal.bim_sigla', '=', 'bimestre.bim_sigla')
        ->select(
            'promediofinal.nota',
            'acad_estudiantes.alu_nombres',
            'acad_estudiantes.alu_apellidos',
            'bimestre.bim_descripcion',
            'bimestre.bim_sigla'
        )
        ->where('acad_carga_docente.acu_id', '=', $id)
        ->where('promediofinal.alu_dni', '=', $usuarioDni)
        ->where('promediofinal.bim_sigla',$bimSigla)
        ->whereNotNull('promediofinal.nota')
        ->get()
        ->groupBy('bim_sigla');
        // dd($id, $usuarioDni);

            $asistencias = DB::table('asistencia')
            ->join('acad_carga_docente', 'asistencia.acdo_id', '=', 'acad_carga_docente.acdo_id')
            ->join('acad_estudiantes', 'asistencia.alu_dni', '=', 'acad_estudiantes.alu_dni')
            ->where('acad_carga_docente.acu_id', $id)
            ->where('asistencia.alu_dni', $usuarioDni)
            ->where('asistencia.estado',$anio)
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


        return view('vistaEstudiante.cursoDetalleIndex', compact('curso', 'cursos', 'anuncios', 'recursos', 'notas', 'asistencias','promedios2')); // Mostrar una vista de detalles
    }





}
