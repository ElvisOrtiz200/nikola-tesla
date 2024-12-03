<?php

namespace App\Http\Controllers;

use App\Models\AcadNota;
use App\Models\Anuncio;
use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\RecursoAcademico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class docentesCursosVistaController extends Controller
{
    public function obtenerCursos(Request $request)
    {
        // Recuperar el usuario desde la cookie
        $usuarioLogin = $request->cookie('user_name');

        if (!$usuarioLogin) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Realizar la consulta utilizando Query Builder
        $cursos = DB::table('auth_usuario as au')
            ->join('rrhh_personal as rh', 'rh.per_id', '=', 'au.per_id')
            ->join('docentes as d', 'd.per_id', '=', 'rh.per_id')
            ->join('acad_carga_docente as acd', 'acd.per_id', '=', 'd.per_id')
            ->join('acad_cursos as ac', 'acd.acu_id', '=', 'ac.acu_id')
            ->select('ac.acu_nombre', 'ac.acu_id')
            ->distinct()  // Aplicamos DISTINCT para evitar duplicados
            ->where('au.usu_login', $usuarioLogin)  // Filtramos por el login del usuario
            ->get();

        // Retornamos los resultados a la vista
        return view('vistasDocente.cursoxDocentes', compact('cursos'));
    }


    public function obtenerCursosPorId(Request $request, $id)
    {
        // Recuperar el curso por su ID
        $curso = Curso::findOrFail($id);  // Obtiene el curso por ID o lanza un error 404 si no se encuentra

        // Recuperar el usuario desde la cookie
        $usuarioDni = $request->cookie('user_name');

        if (!$usuarioDni) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        $cursos = DB::table('auth_usuario as au')
            ->join('rrhh_personal as rh', 'rh.per_id', '=', 'au.per_id')
            ->join('docentes as d', 'd.per_id', '=', 'rh.per_id')
            ->join('acad_carga_docente as acd', 'acd.per_id', '=', 'd.per_id')
            ->join('acad_cursos as ac', 'acd.acu_id', '=', 'ac.acu_id')
            ->select('ac.acu_nombre', 'ac.acu_id')
            ->distinct()  // Aplicamos DISTINCT para evitar duplicados
            ->where('au.usu_login', $usuarioDni)  // Filtramos por el login del usuario
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

        $grado_id = DB::table('acad_carga_docente as acd')
            ->select('acd.id_grado')
            ->where('acd.acu_id', '=', $id) // Suponiendo que $curso_id es el ID del curso
            ->first();

        $estudiantes = DB::table('acad_grado as ag')
            ->select('ae.alu_dni', 'ae.alu_apellidos', 'ae.alu_nombres', DB::raw('MAX(aec.acdo_id) as acdo_id')) // Usamos MAX para obtener un solo valor de acdo_id
            ->join('acad_carga_docente as acd', 'ag.id_grado', '=', 'acd.id_grado') // Relación con carga docente
            ->join('acad_estudiantes_cursos as aec', 'acd.acdo_id', '=', 'aec.acdo_id') // Relación con estudiantes cursos
            ->join('acad_estudiantes as ae', 'aec.alu_dni', '=', 'ae.alu_dni') // Relación con estudiantes
            ->where('ag.id_grado', '=', $grado_id->id_grado)
            ->groupBy('ae.alu_dni', 'ae.alu_apellidos', 'ae.alu_nombres') // Agrupar solo por el estudiante
            ->get();


        // dd($grado_id->id_grado);
        $acdo_id = DB::table('acad_grado as ag')
            ->select(DB::raw('MAX(aec.acdo_id) as acdo_id')) // Usamos MAX para obtener un solo valor de acdo_id
            ->join('acad_carga_docente as acd', 'ag.id_grado', '=', 'acd.id_grado') // Relación con carga docente
            ->join('acad_estudiantes_cursos as aec', 'acd.acdo_id', '=', 'aec.acdo_id') // Relación con estudiantes cursos
            ->join('acad_estudiantes as ae', 'aec.alu_dni', '=', 'ae.alu_dni') // Relación con estudiantes
            ->where('ag.id_grado', '=', $grado_id->id_grado)
            ->where('acd.acu_id', '=', $id)
            ->groupBy('ae.alu_dni', 'ae.alu_apellidos', 'ae.alu_nombres') // Agrupar solo por el estudiante
            ->first(); // Solo obtenemos el primer resultado

        // dd($acdo_id->acdo_id);
        // Aquí obtenemos el acdo_id del primer registro

        if (!$acdo_id) {
            $acdo_id_value = 'vacio';
            // dd('Asignado como vacío');
        } else {
            $acdo_id_value = $acdo_id->acdo_id;
            // dd($acdo_id_value);  
            // dd('Valor asignado desde $acdo_id:', $acdo_id_value);
        }


        // $acdo_id_value = $acdo_id->acdo_id; // Esto es el acdo_id que necesitas


        $notas = AcadNota::select('comentarios', 'fecha')
            ->where('acdo_id', $acdo_id_value) // Filtro por el ID del curso
            ->groupBy('comentarios', 'fecha') // Agrupamos por comentarios y fecha
            ->get();

        $notes = AcadNota::join('acad_estudiantes', 'acad_notas.alu_dni', '=', 'acad_estudiantes.alu_dni')
            ->select('acad_notas.*', 'acad_estudiantes.alu_apellidos as apellidos', 'acad_estudiantes.alu_nombres as nombres')
            ->get();

        $asistencias = Asistencia::with('estudiante')  // Relacionar con estudiantes
            ->select('fecha', 'alu_dni', 'asistencia')
            ->orderBy('fecha', 'desc')
            ->where('acdo_id', $acdo_id_value)
            ->get()
            ->groupBy('fecha');
        // dd($curso,$cursos,$anuncios,$recursos,$estudiantes,$notas,$acdo_id_value);
        return view('vistasDocente.cursoDetalleDocente', compact('curso', 'cursos', 'anuncios', 'recursos', 'estudiantes', 'notas', 'notes', 'acdo_id_value', 'asistencias'));
    }

    public function storeAnuncios(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'id_curso' => 'required|exists:acad_cursos,acu_id', // Verifica que el curso exista
        ]);

        $anuncio = new Anuncio();
        $anuncio->titulo = $request->input('titulo');
        $anuncio->descripcion = $request->input('descripcion');
        $anuncio->fecha_publicacion = now();
        $anuncio->id_curso = $request->input('id_curso');
        $anuncio->estado = 'A';

        $anuncio->save();

        return redirect()->route('docentescursodetalle.show', ['id' => $anuncio->id_curso]);
    }


    public function updateAnuncio(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'id_curso' => 'required|exists:acad_cursos,acu_id',
        ]);

        // Buscar el anuncio por su ID
        $anuncio = Anuncio::findOrFail($id);

        // Actualizar los campos del anuncio
        $anuncio->titulo = $request->input('titulo');
        $anuncio->descripcion = $request->input('descripcion');
        $anuncio->id_curso = $request->input('id_curso');
        $anuncio->estado = $request->input('estado', 'A'); // Si el estado no es enviado, se deja 'A' por defecto

        // Guardar los cambios
        $anuncio->save();

        // Redirigir de vuelta a la página de detalle del curso
        return redirect()->route('docentescursodetalle.show', ['id' => $anuncio->id_curso])
            ->with('success', 'Anuncio actualizado exitosamente');
    }



    public function destroyAnuncio($id)
    {
        // Buscar el anuncio por su ID
        $anuncio = Anuncio::findOrFail($id);

        // Eliminar el anuncio
        $anuncio->delete();

        // Redirigir a la página de detalle del curso después de eliminar el anuncio
        return redirect()->route('docentescursodetalle.show', ['id' => $anuncio->id_curso])
            ->with('success', 'Anuncio eliminado exitosamente');
    }



    public function storeRecursoAcademico(Request $request)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ruta_archivo' => 'required|url', // Validar que sea un enlace válido
            'id_curso' => 'required|exists:acad_cursos,acu_id', // Validar que el curso exista
        ]);
    // dd($request);
        // Obtener los datos del formulario
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $id_curso = $request->input('id_curso');
        $ruta_archivo = $request->input('ruta_archivo'); // El enlace de Google Drive u otro
    
        // Crear el recurso académico con el enlace proporcionado
        RecursoAcademico::create([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'nombre_archivo' => pathinfo($ruta_archivo, PATHINFO_BASENAME), // Extraer el nombre del archivo del enlace (solo para tener el nombre)
            'ruta_archivo' => $ruta_archivo, // Guardar el enlace completo
            'id_curso' => $id_curso,
            'fecha_subida' => now(), // Fecha de subida actual
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Recurso agregado correctamente.');
    }
    
    public function storeNota(Request $request)
    {

        // Validaciones
        $request->validate([
            'comentarios' => 'required|string|max:255',
            'alu_dnis' => 'required|array',
            'alu_dnis.*' => 'exists:acad_estudiantes,alu_dni',
            'acdo_id' => 'required|exists:acad_carga_docente,acdo_id',
        ]);
        // Obtener los datos
        $titulo = $request->input('comentarios');
        $alu_dnis = $request->input('alu_dnis');
        $acdo_id = $request->input('acdo_id');
        $acdo_id = $acdo_id[0];  // Toma el primer valor del array

        // Verifica que $comentarios sea una cadena
        if (!is_string($titulo)) {
            dd('Error: $titulo no es una cadena');
        }

        $fechaActual = now();
        // Concatenar título y fecha
        $tituloFinal = $titulo . '_' . $fechaActual->format('Ymd_His');

        // Verifica que $tituloFinal sea una cadena antes de insertar
        if (!is_string($tituloFinal)) {
            dd('Error: $tituloFinal no es una cadena.');
        }
        // dd($tituloFinal);
        // Insertar las notas
        foreach ($alu_dnis as $alu_dni) {
            AcadNota::create([
                'alu_dni' => $alu_dni,
                'nota' => null,
                'acdo_id' => $acdo_id,
                'fecha' => $fechaActual,
                'estado' => 'Sin calificar',
                'comentarios' => $tituloFinal, // Asegúrate que aquí sea una cadena
            ]);
        }

        return redirect()->back()->with('success', 'Notas creadas correctamente.');
    }

    public function storeCalificaciones(Request $request)
    {
        // Validación de datos recibidos
        $request->validate([
            'notas' => 'required|array', // Validamos que haya un array de notas
            'notas.*' => 'numeric|min:0|max:20', // Validamos que las notas sean números entre 0 y 20
            'acdo_id' => 'required|exists:acad_carga_docente,acdo_id', // Validamos que el acdo_id exista en la tabla acad_carga_docente
        ]);

        // Recuperar las notas y el acdo_id
        $notas = $request->input('notas');
        $acdo_id = $request->input('acdo_id');
        $fechaActual = now(); // Recuperar la fecha actual

        foreach ($notas as $alu_dni => $nota) {
            // Verificar si ya existe una calificación para este estudiante y curso
            $notaExistente = AcadNota::where('alu_dni', $alu_dni)
                ->where('acdo_id', $acdo_id)
                ->first();

            // Si la calificación ya existe, actualizarla
            if ($notaExistente) {
                $notaExistente->nota = $nota; // Actualizar la nota
                $notaExistente->estado = 'Calificado'; // Cambiar el estado
                $notaExistente->save(); // Guardar los cambios en la base de datos
            } else {
                // Si no existe, crear una nueva entrada
                AcadNota::create([
                    'alu_dni' => $alu_dni,   // DNI del estudiante
                    'nota' => $nota,         // Nota calificada
                    'acdo_id' => $acdo_id,   // ID del curso
                    'fecha' => $fechaActual, // Fecha actual
                    'estado' => 'Calificado', // Estado de la calificación
                    'comentarios' => 'Calificación final', // Comentario predeterminado
                ]);
            }
        }

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Calificaciones guardadas correctamente.');
    }




    public function guardarCalificaciones(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'alu_dni' => 'required|integer',
            'comentarios' => 'required|string',
            'nota' => 'required',
        ]);
        // dd($request);

        // Buscar el registro en la tabla AcadNota por alu_dni y comentarios
        $nota = AcadNota::where('alu_dni', $validated['alu_dni'])
            ->where('comentarios', $validated['comentarios'])
            ->first();

        if ($nota) {
            // Si ya existe un registro, actualizar la nota si es null o modificarla
            $nota->nota = $validated['nota'] ?? $nota->nota; // Si no se pasa una nota, no la cambia
            $nota->save();
        }

        // Redirigir o devolver una respuesta
        return redirect()->back()->with('success', 'Notas guardadas correctamente.');
    }


    public function storeAsistencia(Request $request)
    {
        // Validar los datos
        $request->validate([
            'fecha' => 'required|date',
            'asistencias' => 'required|array',
        ]);

        foreach ($request->asistencias as $alu_dni => $data) {
            // Verificar si la clave 'asistencia' está presente
            $asistencia = isset($data['asistencia']) ? $data['asistencia'] : 'F'; // Si no se selecciona, por defecto 'F'

            // Guardar o actualizar la asistencia
            Asistencia::updateOrCreate(
                [
                    'alu_dni' => $alu_dni,
                    'fecha' => $request->fecha,
                ],
                [
                    'acdo_id' => $data['acdo_id'],
                    'asistencia' => $asistencia,
                ]
            );
        }



        return redirect()->back()->with('success', 'Asistencia registrada correctamente.');
    }


    public function edit($id)
    {
        // Buscar el anuncio
        $anuncio = Anuncio::find($id);
    
        if (!$anuncio) {
            return response()->json(['error' => 'Anuncio no encontrado'], 404);
        }
        
        // Devolver los datos del anuncio como JSON
        return response()->json($anuncio);
        
    }
    // Asegúrate de incluir Carbon para manejar fechas

    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::find($id);
    
        if (!$anuncio) {
            return response()->json(['error' => 'Anuncio no encontrado'], 404);
        }
    
        // Validación de los datos
        $request->validate([
            'titulo' => 'required|max:150',
            'descripcion' => 'required',
        ]);
    
        // Asignar la hora de Perú (Lima) a la fecha de publicación
        $fechaActual = Carbon::now('America/Lima');  // Carbon se encarga de manejar la zona horaria
    
        // Actualización del anuncio
        $anuncio->titulo = $request->titulo;
        $anuncio->descripcion = $request->descripcion;
        $anuncio->fecha_publicacion = $fechaActual;  // Asignar la fecha actual con la zona horaria de Lima
        $anuncio->save();
    
        // Redirigir a la página de detalle del curso (o a donde necesites)
        return redirect()->route('docentescursodetalle.show', ['id' => $anuncio->id_curso]);
    }
    


    public function updateRECURSO(Request $request, $id)
{
    $recurso = RecursoAcademico::find($id);

    if (!$recurso) {
        return response()->json(['error' => 'Recurso no encontrado'], 404);
    }

    // Validación de los datos
    $request->validate([
        'titulo' => 'required|max:255',
        'descripcion' => 'nullable|string',
        'ruta_archivo' => 'required|url',  // Aseguramos que sea un enlace válido
    ]);

    // Actualización del recurso
    $recurso->titulo = $request->titulo;
    $recurso->descripcion = $request->descripcion;
    $recurso->ruta_archivo = $request->ruta_archivo;
    $recurso->save();

    // Redirigir a la lista de recursos
    return redirect()->route('docentescursodetalle.show', ['id' => $recurso->id_curso]);
}





public function editarAsistencia(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'fecha' => 'required|date',
        'alu_dni' => 'required|exists:acad_estudiantes,alu_dni',
        'asistencia' => 'required|in:P,F',
        'cursoid' => 'required' 
    ]);
    
    // Buscar la asistencia correspondiente
    $asistencia = Asistencia::where('fecha', $request->fecha)
                            ->where('alu_dni', $request->alu_dni)
                            ->first();

    // Si no se encuentra la asistencia, mostrar un error
    if (!$asistencia) {
        return redirect()->back()->withErrors(['error' => 'Asistencia no encontrada.']);
    }

    // Actualizar el estado de la asistencia
    $asistencia->asistencia = $request->asistencia;
    $asistencia->save();
    
    // Redirigir con un mensaje de éxito
    return redirect()->route('docentescursodetalle.show', ['id' => $request->cursoid]);

}






}
