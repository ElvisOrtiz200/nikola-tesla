<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Nivel;
use App\Models\Grado;
use Carbon\Carbon;
use App\Models\AuditoriaLog;
use App\Models\Bimestre;

class GradoController extends Controller
{
    public function index()
    {
        return view('grado.index');
    }

    public function create()
    {
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $niveles = Nivel::where('estado', '=', $anio)->get();
        return view('grado.crear',compact('niveles'));
    }


    public function store(Request $request) {
        //
        try {
            $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            $validator = FacadesValidator::make(request()->all(), [
                'nombre' => 'required',
                'id_nivel' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            $grado = new Grado();
            $grado->nombre = request()->nombre;
            $grado->id_nivel = request()->id_nivel;
            $grado->estado =$anio;
            $grado->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Grado';
            $auditoria->save();


            // Redirigir con cookie de éxito
            return redirect()->route('grado.create')
                ->withCookie(cookie('success', 'Grado registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('grado.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
 
    public function show(Request $request)
{
    // Inicializa la consulta base
    $query = Grado::query();  // Usar query() en lugar de all()
    $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $query->where('estado', '=', $anioActual);
    // Agregar el filtro si el parámetro 'search' existe
    if ($request->has('search') && !empty($request->search)) {
        $query->where('nombre', 'like', '%' . $request->search . '%'); // Filtrar solo por el nombre del grado
    }

    // Paginación
    $grado = $query->paginate(4);  // Realiza la paginación

    return view('grado.editar', compact('grado')); 
}

public function editando($id,Request $request)
    {
        // Cargar todos los recursos humanos para el dropdown
    $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
    $niveles = Nivel::where('estado', '=', $anio)->get();
    // Obtener el docente con la relación cargada
    $grados = Grado::with('nivel')->findOrFail($id);

    return view('grado.editando', compact('grados', 'niveles'));
    }

    public function update(Request $request, $id) {
        try {
            $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            // Validar los datos
            $validator = FacadesValidator::make($request->all(), [
                'nombre' => 'required',
                'id_nivel' => 'required',
            ]);
    
            // Si la validación falla
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            // Buscar el recurso humano por ID
            $grados = Grado::findOrFail($id); 
    
            // Actualizar los campos
            $grados->nombre = $request->nombre;
            $grados->id_nivel = $request->id_nivel;
            $grados->estado = $anioActual; 

            // Guardar los cambios
            $grados->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Grado';
            $auditoria->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('grado.show') // Cambia a la ruta que desees
                ->withCookie(cookie('success', 'Grado actualizado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Log del error y redirigir con mensaje de error
    
            return redirect()->route('grado.show', $id)
                ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1));
        }
    }



    
    public function delete(Request $request){
        $query = Grado::query();  // Usar query() en lugar de all()
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $query->where('estado', '=', $anioActual);
    // Agregar el filtro si el parámetro 'search' existe
    if ($request->has('search') && !empty($request->search)) {
        $query->where('nombre', 'like', '%' . $request->search . '%'); // Filtrar solo por el nombre del grado
    }

    // Paginación
    $grado = $query->paginate(4);  // Realiza la paginación
    
        return view('grado.eliminar', compact('grado')); 
   }
 
   public function eliminando($id)
    {
        $niveles = Nivel::all();

        // Obtener el docente con la relación cargada
        $grados = Grado::with('nivel')->findOrFail($id);
    
        return view('grado.eliminando', compact('grados', 'niveles'));
    }

    public function destroy(string $id, Request $request){
        $registro = Grado::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();
        $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Grado';
            $auditoria->save();
        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('grado.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Grado eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }



    public function listar(Request $request)
    {
        // Crear una consulta básica
        $query = Grado::with('nivel');
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $query->where('estado', '=', $anioActual);
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Grado';
            $auditoria->save();

        // Si se ha enviado el parámetro de búsqueda, agregar el filtro
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Paginación de 10 elementos por página (ajustable según tus necesidades)
        $grados = $query->paginate(10);

        return view('grado.listar', compact('grados'));
    }
}
 