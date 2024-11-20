<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Aula;
use App\Models\Nivel;

use App\Models\Grado;

class AulaController extends Controller
{
    public function index()
    {
        return view('aula.index');
    }

    public function create()
    {
        // Cargar niveles junto con sus grados
        $niveles = Nivel::with('grados')->get(); 
        return view('aula.crear', compact('niveles'));
    }
    

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'nombre' => 'required',
                'capacidad' => 'required',
                'id_grado' => 'required',


            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            $grado = new Aula();
            $grado->nombre = request()->nombre;
            $grado->capacidad = request()->capacidad;
            $grado->id_grado = request()->id_grado;
            $grado->save();
            // Redirigir con cookie de éxito
            return redirect()->route('aula.create')
                ->withCookie(cookie('success', 'Aula registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('aula.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
 
    
    public function show(Request $request){
        $query =Aula::with('grado'); 
    
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('grado', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%');
            });
        }
    
        $aula = $query->paginate(20); // Cambia esto para paginación
    
        return view('aula.editar', compact('aula'));
        }




       public function editando($id, Request $request)
{
    // Cargar todos los grados para el dropdown
    $grados = Grado::all();
    
    // Obtener el aula con el grado relacionado
    $aulas = Aula::with('grado')->findOrFail($id);

    return view('aula.editando', compact('aulas', 'grados'));
}


    public function update(Request $request, $id) {
        try {
            // Validar los datos
            $validator = FacadesValidator::make($request->all(), [
                'nombre' => 'required',
                'capacidad' => 'required',
                'id_grado' => 'required',

            ]);
    
            // Si la validación falla
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            // Buscar el recurso humano por ID
            $aulas = Aula::findOrFail($id); 
    
            // Actualizar los campos
            $aulas->nombre = request()->nombre;
            $aulas->capacidad = request()->capacidad;
            $aulas->id_grado = request()->id_grado;
            // Guardar los cambios
            $aulas->save();
            
            // Redirigir con cookie de éxito
            return redirect()->route('aula.show') // Cambia a la ruta que desees
                ->withCookie(cookie('success', 'Aula actualizado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Log del error y redirigir con mensaje de error
    
            return redirect()->route('aula.show', $id)
                ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1));
        }
    }



    
    public function delete(Request $request){
        $query =Aula::with('grado'); 
    
        // if ($request->has('search') && $request->search != '') {
        //     $query->whereHas('nivel', function($q) use ($request) {
        //         $q->where('nombre', 'like', '%' . $request->search . '%');
        //     });
        // }

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
    
        $aula = $query->paginate(4); // Cambia esto para paginación
    
        return view('aula.eliminar', compact('aula')); 
   }
 
   public function eliminando($id){
        $grados = Grado::all();

        // Obtener el docente con la relación cargada
        $aulas = Aula::with('grado')->findOrFail($id);
    
        return view('aula.eliminando', compact('grados', 'aulas'));
    }

    public function destroy(string $id){
        $registro = Aula::find($id);
        if ($registro) {
            // Elimina el registro
            $registro->delete();

            // Retorna una respuesta, redirige o envía un mensaje
            return redirect()->route('aula.eliminar') // Cambia a la ruta que desees
            ->withCookie(cookie('success', 'Aula eliminado con éxito.', 1, '/', null, false, false));
        }
        return redirect()->back()->with('error', 'Registro no encontrado.');
    }
}
