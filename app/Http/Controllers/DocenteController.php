<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\RecursosHumanos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class DocenteController extends Controller
{
    public function index()
    {
        return view('docente.index');
    }

    public function create()
    {
        $rrhh = RecursosHumanos::all();
        return view('docente.crear', compact('rrhh'));
    }

    public function store(Request $request) {
        //
        
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'per_id' => 'required',
                'doc_especialidad' => 'required',
                'doc_nivel_educativo' => 'required',
                'doc_fecha_nac' => 'required',
                 
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            $docente = new Docente();
            $docente->per_id = request()->per_id;
            $docente->doc_especialidad = request()->doc_especialidad;
            $docente->doc_nivel_educativo = request()->doc_nivel_educativo;
            $docente->doc_fecha_nac = Carbon::parse(request()->doc_fecha_nac)->format('Y-m-d');
            $docente->doc_estado = 'A';
 
            $docente->save();
            // Redirigir con cookie de éxito
            return redirect()->route('docente.create')
                ->withCookie(cookie('success', 'Docente registradoasdasdas con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('docente.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }



    public function show(Request $request){
    $query = Docente::with('recursoshh'); 

    if ($request->has('search') && $request->search != '') {
        $query->whereHas('recursoshh', function($q) use ($request) {
            $q->where('per_dni', 'like', '%' . $request->search . '%');
        });
    }

    $docente = $query->paginate(4); // Cambia esto para paginación

    return view('docente.editar', compact('docente'));
    }

    public function editando($id,Request $request)
    {
        // Cargar todos los recursos humanos para el dropdown
    $rrhh = RecursosHumanos::all();

    // Obtener el docente con la relación cargada
    $docente = Docente::with('recursoshh')->findOrFail($id);

    return view('docente.editando', compact('docente', 'rrhh'));
    }

    public function update(Request $request, $id) {
        try {
            // Validar los datos
            $validator = FacadesValidator::make($request->all(), [
                'per_id' => 'required',
                'doc_especialidad' => 'required',
                'doc_nivel_educativo' => 'required',
                'doc_fecha_nac' => 'required|date_format:Y-m-d',
                'doc_estado' => 'required',
            ]);
    
            // Si la validación falla
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
    
            // Buscar el recurso humano por ID
            $docente = Docente::findOrFail($id); 
    
            // Actualizar los campos
            $docente->per_id = $request->per_id;
            $docente->doc_especialidad = $request->doc_especialidad;
            $docente->doc_nivel_educativo = $request->doc_nivel_educativo;
            $docente->doc_estado = $request->doc_estado;
            
    
            $docente->doc_fecha_nac = Carbon::parse($request->doc_fecha_nac)->format('Y-m-d');
    
            // Guardar los cambios
            $docente->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('docente.show') // Cambia a la ruta que desees
                ->withCookie(cookie('success', 'Docente actualizado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Log del error y redirigir con mensaje de error
    
            return redirect()->route('docente.show', $id)
                ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1));
        }
    }



    public function delete(Request $request){
        $query = Docente::with('recursoshh'); 

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('recursoshh', function($q) use ($request) {
                $q->where('per_dni', 'like', '%' . $request->search . '%');
            });
        }
    
        $docente = $query->paginate(4); // Cambia esto para paginación
    
        return view('docente.eliminar', compact('docente'));
   }
 
   public function eliminando($id)
    {
        $rrhh = RecursosHumanos::all();

    // Obtener el docente con la relación cargada
    $docente = Docente::with('recursoshh')->findOrFail($id);

    return view('docente.eliminando', compact('docente', 'rrhh'));
    }

    public function destroy(string $id){
        $registro = Docente::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('docente.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Docente eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }


}