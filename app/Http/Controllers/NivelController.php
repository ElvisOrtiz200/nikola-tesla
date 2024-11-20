<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Nivel;

class NivelController extends Controller
{
    public function index()
    {
        return view('nivel.index');
    } 

    public function create()
    {
        return view('nivel.crear');
    }

    public function store() {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'nombre' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $nivel = new Nivel();
            $nivel->nombre = request()->nombre;
            $nivel->save();
            // Redirigir con cookie de éxito
            return redirect()->route('nivel.create')
                ->withCookie(cookie('success', 'Nivel registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('nivel.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

    public function show(Request $request){
        $query = Nivel::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $niveles = $query->paginate(4); // Cambia esto para paginación

        return view('nivel.editar', compact('niveles'));
    }

    public function editando($id)
    {
        $apoderado = Nivel::findOrFail($id);

        return view('nivel.editando', compact('apoderado'));
    }

    public function update(Request $request, $id) {

        
        $validator = FacadesValidator::make(request()->all(), [
            'nombre' => 'required',
        ]);

        $nivel = Nivel::findOrFail($id); 
        $nivel->id_nivel = $request->id_nivel;
        $nivel->nombre = request()->nombre;
        $nivel->save();
    
        return redirect()->route('nivel.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Nivel actualizado con éxito.', 1, '/', null, false, false));
    }


    public function delete(Request $request){
        $query = Nivel::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('id_nivel', 'like', '%' . $request->search . '%');
        }

        $apoderado = $query->paginate(4); // Cambia esto para paginación

        return view('nivel.eliminar', compact('apoderado'));
   }

   public function eliminando($id)
    {
        $apoderado = Nivel::findOrFail($id);
        return view('nivel.eliminando', compact('apoderado'));
    }

    public function destroy(string $id){
        $registro = Nivel::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('nivel.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Nivel eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

}
