<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Nivel;
use App\Models\Grado;



class GradoController extends Controller
{
    public function index()
    {
        return view('grado.index');
    }

    public function create()
    {
        $nivel = Nivel::all();
        return view('grado.crear',compact('nivel'));
    }


    public function store(Request $request) {
        //
        try {
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
            $grado->save();
            // Redirigir con cookie de éxito
            return redirect()->route('grado.create')
                ->withCookie(cookie('success', 'Grado registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('grado.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

    public function show(Request $request){
        $query =Grado::with('nivel'); 
    
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('nivel', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%');
            });
        }
    
        $grado = $query->paginate(4); // Cambia esto para paginación
    
        return view('grado.editar', compact('grado'));
        }

public function editando($id,Request $request)
    {
        // Cargar todos los recursos humanos para el dropdown
    $niveles = Nivel::all();

    // Obtener el docente con la relación cargada
    $grados = Grado::with('nivel')->findOrFail($id);

    return view('grado.editando', compact('grados', 'niveles'));
    }

    public function update(Request $request, $id) {
        try {
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
            // Guardar los cambios
            $grados->save();
    
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
        $query =Grado::with('nivel'); 
    
        // if ($request->has('search') && $request->search != '') {
        //     $query->whereHas('nivel', function($q) use ($request) {
        //         $q->where('nombre', 'like', '%' . $request->search . '%');
        //     });
        // }

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
    
        $grado = $query->paginate(4); // Cambia esto para paginación
    
        return view('grado.eliminar', compact('grado')); 
   }
 
   public function eliminando($id)
    {
        $niveles = Nivel::all();

        // Obtener el docente con la relación cargada
        $grados = Grado::with('nivel')->findOrFail($id);
    
        return view('grado.eliminando', compact('grados', 'niveles'));
    }

    public function destroy(string $id){
        $registro = Grado::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('grado.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Grado eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }
}
 