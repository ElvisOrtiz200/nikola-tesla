<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Apoderado;
use Illuminate\Support\Facades\Validator as FacadesValidator;
   
class ApoderadoController extends Controller
{
    public function index()
    {
        return view('apoderado.index');
    }
 
    public function create()
    {
        return view('apoderado.crear');
    }

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'apo_dni' => 'required',
                'apo_apellidos' => 'required',
                'apo_nombres' => 'required',
                'apo_direccion' => 'required',
                'apo_telefono' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $apoderado = new Apoderado();
            $apoderado->apo_dni = request()->apo_dni;
            $apoderado->apo_apellidos = request()->apo_apellidos;
            $apoderado->apo_nombres = request()->apo_nombres;
            $apoderado->apo_direccion = request()->apo_direccion;
            $apoderado->apo_telefono = request()->apo_telefono;
            $apoderado->save();
            // Redirigir con cookie de éxito
            return redirect()->route('apoderado.create')
                ->withCookie(cookie('success', 'Apoderado registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('apoderado.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
 
    public function show(Request $request){
        $query = Apoderado::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('apo_dni', 'like', '%' . $request->search . '%');
        }

        $apoderados = $query->paginate(4); // Cambia esto para paginación

        return view('apoderado.editar', compact('apoderados'));
    } 

    public function editando($id)
    {
        $apoderado = Apoderado::findOrFail($id);

        return view('apoderado.editando', compact('apoderado'));
    }


    public function update(Request $request, $id) {

        
        $validator = FacadesValidator::make(request()->all(), [
                'apo_dni' => 'required',
                'apo_apellidos' => 'required',
                'apo_nombres' => 'required',
                'apo_direccion' => 'required',
                'apo_telefono' => 'required',
        ]);

        $apoderado = Apoderado::findOrFail($id); 
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
        $query = Apoderado::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('apo_dni', 'like', '%' . $request->search . '%');
        }

        $apoderado = $query->paginate(4); // Cambia esto para paginación

        return view('apoderado.eliminar', compact('apoderado'));
   }

   public function eliminando($id)
    {
        $apoderado = Apoderado::findOrFail($id);
        return view('apoderado.eliminando', compact('apoderado'));
    }

    public function destroy(string $id){
        $registro = Apoderado::find($id);

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
