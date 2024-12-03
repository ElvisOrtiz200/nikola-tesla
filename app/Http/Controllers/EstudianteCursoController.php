<?php

namespace App\Http\Controllers;

use App\Models\Bimestre;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use App\Models\Curso_Docente;
use App\Models\Estudiante;
use App\Models\EstudianteCurso;
use App\Models\Grado;
use App\Models\Hora;
use Illuminate\Http\Request;

class EstudianteCursoController extends Controller
{

    public function index()
    {
        return view('asignarStuCurso.index');
    }
 
    public function create()
    {
        $grado = Grado::join('acad_nivel','acad_grado.id_nivel','=','acad_nivel.id_nivel')->select(
            'acad_grado.id_grado as id_grado',
            'acad_grado.nombre as grado',
            'acad_nivel.nombre as nivel' 
        )->get();
        //se muestra aquellos estudiantes que no pertenecen a ningun 
        $estudiantes = Estudiante::leftJoin('acad_estudiantes_cursos', 'acad_estudiantes.alu_dni', '=', 'acad_estudiantes_cursos.alu_dni')
        ->whereNull('acad_estudiantes_cursos.alu_dni')
        ->select('acad_estudiantes.alu_dni', 'acad_estudiantes.alu_apellidos', 'acad_estudiantes.alu_nombres')
        ->orderBy('acad_estudiantes.alu_apellidos', 'asc')  // Ordenar por apellidos en orden ascendente
        ->get();
        $bimestre = Bimestre::all();
        return view('asignarStuCurso.crear', compact('grado','estudiantes','bimestre'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud para asegurarse de que se pasen los datos correctos
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
                        'bim_sigla' => $request->input('bim_sigla') // Suponiendo que también necesitas la sigla del bimestre
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Revertir si ocurre un error
            DB::rollBack();
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

    public function store2(Request $request)
    {
        // Validar la solicitud para asegurarse de que se pasen los datos correctos
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
        // Buscar todos los cursos en carga docente que correspondan al grado seleccionado
        $cursosDocente2 = Curso_Docente::where('id_grado', $id_grado)->pluck('acu_id')->toArray();
        $cursos = Curso::where('id_grado', '=', $id_grado)->pluck('acu_id')->toArray();
        
        // Comparar los dos arrays
        $diff1 = array_diff($cursosDocente2, $cursos);
        $diff2 = array_diff($cursos, $cursosDocente2);
        
        // Si hay diferencias, devolver un mensaje de error
        if (!empty($diff1) || !empty($diff2)) {
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('error', 'En este grado hay cursos que no tienen un docente asignado.', 1));
        }
    //   stamos depurando ambas variables correctamente

        // dd($request, $cursos, $estudiantes);
        // Verificar si se encontraron cursos para ese grado
        if (empty($cursos)) {
            return response()->json(['error' => 'No se encontraron cursos para el grado seleccionado'], 404);
        }

        // Iniciar transacción
        DB::beginTransaction();
        try {
            // Para cada estudiante, insertar una entrada en `acad_estudiantes_cursos` por cada curso encontrado
            foreach ($estudiantes as $alu_dni) {
                foreach ($cursos as $acdo_id) {
                    EstudianteCurso::create([
                        'alu_dni' => $alu_dni,
                        'acdo_id' => $acdo_id,
                        'bim_sigla' => $request->input('bim_sigla') // Suponiendo que también necesitas la sigla del bimestre
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('success', 'Registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Revertir si ocurre un error
            DB::rollBack();
            return redirect()->route('estudiante-curso.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    } 





    public function listar()
    {
        $estudiantesCursos = DB::table('acad_estudiantes_cursos')
        ->join('acad_estudiantes', 'acad_estudiantes_cursos.alu_dni', '=', 'acad_estudiantes.alu_dni')
        ->join('acad_carga_docente', 'acad_estudiantes_cursos.acdo_id', '=', 'acad_carga_docente.acdo_id')
        ->join('bimestre', 'acad_estudiantes_cursos.bim_sigla', '=', 'bimestre.bim_sigla')
        ->join('acad_cursos', 'acad_carga_docente.acu_id', '=', 'acad_cursos.acu_id')
        ->join('rrhh_personal', 'acad_carga_docente.per_id', '=', 'rrhh_personal.per_id')
        ->select(
            'acad_estudiantes_cursos.alu_dni',
            'acad_estudiantes.alu_nombres',
            'acad_estudiantes.alu_apellidos',
            'acad_carga_docente.acdo_anio',
            'bimestre.bim_sigla',
            'acad_cursos.acu_nombre',
            'acad_estudiantes_cursos.bim_sigla',
            'rrhh_personal.per_nombres as docente_nombre'
        )
        ->paginate(10); // Paginación de 10 resultados por página
        return view('asignarStuCurso.listar', compact('estudiantesCursos'));
    }
    











}
