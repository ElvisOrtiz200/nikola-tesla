<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Grado;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {

        return view('curso.index');
    }
 
    public function create()
    {
        // $grado = Grado::all();
        $grados = Grado::join('acad_nivel','acad_grado.id_nivel', '=', 'acad_nivel.id_nivel')->select('acad_grado.nombre as grado_nombre', 'acad_nivel.nombre as nivel_nombre', 'acad_grado.id_grado as id_grado')->get();
        return view('curso.crear', compact('grados'));
    }

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'acu_nombre' => 'required',
                'id_grado' => 'required'
               
              
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $curso = new Curso();
            $curso->acu_nombre = request()->acu_nombre;
            $curso->id_grado = request()->id_grado;
            $curso->acu_estado = 'A';
            $curso->save();
            // Redirigir con cookie de éxito
            return redirect()->route('curso.create')
                ->withCookie(cookie('success', 'Curso registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('curso.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }
    public function show(Request $request){
        $query = Curso::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('acu_nombre', 'like', '%' . $request->search . '%');
        }

        $cursos = $query->paginate(4); // Cambia esto para paginación

        return view('curso.editar', compact('cursos'));
    }

    public function editando($id)
    {
        $curso = Curso::findOrFail($id);

        return view('curso.editando', compact('curso'));
    }


    public function update(Request $request, $id) {

        
        $validator = FacadesValidator::make(request()->all(), [
                'acu_nombre' => 'required',
                'acu_estado' => 'required',
        ]);

        $curso = Curso::findOrFail($id); 
        $curso->acu_nombre = $request->acu_nombre;
        $curso->acu_estado = $request->acu_estado;
        $curso->save();
    
        return redirect()->route('apoderado.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Apoderado actualizado con éxito.', 1, '/', null, false, false));
    }

    public function delete(Request $request){
        $query = Curso::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('acu_nombre', 'like', '%' . $request->search . '%');
        }

        $curso = $query->paginate(4); // Cambia esto para paginación

        return view('curso.eliminar', compact('curso'));
   }

   public function eliminando($id)
    {
        $curso = Curso::findOrFail($id);
        return view('curso.eliminando', compact('curso'));
    }

    public function destroy(string $id){
        $registro = Curso::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('curso.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Curso eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

}
