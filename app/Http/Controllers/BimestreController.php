<?php

namespace App\Http\Controllers;

use App\Models\Bimestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

 
class BimestreController extends Controller
{
    public function index()
    {
        return view('bimestre.index');
    }
 
    public function create()
    {
        return view('bimestre.crear');
    }

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'bim_sigla' => 'required',
                'bim_descripcion' => 'required',
                
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            // dd($request);
            $bimestre = new Bimestre();
            $bimestre->bim_sigla = request()->bim_sigla;
           
            $bimestre->bim_descripcion = request()->bim_descripcion;
           
            $bimestre->save();
            //dd($bimestre);
            // Redirigir con cookie de éxito
            return redirect()->route('bimestre.create')
                ->withCookie(cookie('success', 'bimestre registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            // dd("hola");
            return redirect()->route('bimestre.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
 
    public function show(Request $request){
        $query = Bimestre::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('bim_descripcion', 'like', '%' . $request->search . '%');
        }

        $bimestres = $query->paginate(4); // Cambia esto para paginación

        return view('bimestre.editar', compact('bimestres'));
    }

    public function editando($id)
    {
        $bimestre = Bimestre::findOrFail($id);

        return view('bimestre.editando', compact('bimestre'));
    }


    public function update(Request $request, $id) {

        
        $validator = FacadesValidator::make(request()->all(), [
                'apo_dni' => 'required',
                'apo_apellidos' => 'required',
                'apo_nombres' => 'required',
                'apo_direccion' => 'required',
                'apo_telefono' => 'required',
        ]);

        $apoderado = Bimestre::findOrFail($id); 
        $apoderado->apo_dni = $request->apo_dni;
        $apoderado->apo_apellidos = $request->apo_apellidos;
        $apoderado->apo_nombres = $request->apo_nombres;
        $apoderado->apo_direccion = $request->apo_direccion;
        $apoderado->apo_telefono = $request->apo_telefono;
        $apoderado->save();
    
        return redirect()->route('apoderado.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Apoderado actualizado con éxito.', 1, '/', null, false, false));
    }

    public function delete(Request $request){
        $query = Bimestre::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('apo_dni', 'like', '%' . $request->search . '%');
        }

        $apoderado = $query->paginate(4); // Cambia esto para paginación

        return view('apoderado.eliminar', compact('apoderado'));
   }

   public function eliminando($id)
    {
        $apoderado = Bimestre::findOrFail($id);
        return view('apoderado.eliminando', compact('apoderado'));
    }

    public function destroy(string $id){
        $registro = Bimestre::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('apoderado.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Apoderado eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

}
