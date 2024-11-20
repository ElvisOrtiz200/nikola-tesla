<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
class EstudianteController extends Controller
{
    public function index()
    {
        return view('estudiante.index');
    } 

    public function create()
    {
        $apoderado = Apoderado::all();
        return view('estudiante.crear',compact('apoderado'));
    }

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'alu_dni' => 'required',
                'alu_apellidos' => 'required',
                'alu_nombres' => 'required',
                'apo_dni' => 'required',
                'alu_direccion' => 'required',
                'alu_telefono' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $estudiante = new Estudiante;
            $estudiante->alu_dni = request()->alu_dni;
            $estudiante->alu_apellidos = request()->alu_apellidos;
            $estudiante->alu_nombres = request()->alu_nombres;
            $estudiante->apo_dni = request()->apo_dni;
            $estudiante->alu_direccion = request()->alu_direccion;
            $estudiante->alu_telefono = request()->alu_telefono;
            $estudiante->alu_estado = 'A';
            $estudiante->save();
            // Redirigir con cookie de éxito
            return redirect()->route('estudiante.create')
                ->withCookie(cookie('success', 'Estudiante registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('estudiante.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

   

    public function show(Request $request){
        $query = Estudiante::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('alu_dni', 'like', '%' . $request->search . '%');
        }

        $estudiantes = $query->paginate(4); // Cambia esto para paginación

        return view('estudiante.editar', compact('estudiantes'));
    }

    public function listadoListar()
    {
        // Obtener todos los registros de la tabla 'rol'
        $estudiantes = Estudiante::paginate(25); // O Rol::paginate(10) para paginación

        // Retornar la vista 'roles.index' y pasar los roles a la vista
        return view('estudiante.listar', compact('estudiantes'));
    }

    public function showListar(Request $request){
        $query = Estudiante::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('alu_dni', 'like', '%' . $request->search . '%');
        }

        $estudiantes = $query->paginate(4); // Cambia esto para paginación

        return view('estudiante.listar', compact('estudiantes'));
    }

    public function editando($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        return view('estudiante.editando', compact('estudiante'));
    }

    public function update(Request $request, $id) {

        
        $validator = FacadesValidator::make(request()->all(), [
            'alu_dni' => 'required',
            'alu_apellidos' => 'required',
            'alu_nombres' => 'required',
            'apo_dni' => 'required',
            'alu_direccion' => 'required',
            'alu_telefono' => 'required',
            'alu_estado' => 'required',
        ]);

        $estudiante = Estudiante::findOrFail($id); 
        $estudiante->alu_dni = $request->alu_dni;
        $estudiante->alu_apellidos = $request->alu_apellidos;
        $estudiante->alu_nombres = $request->alu_nombres;
        $estudiante->apo_dni = $request->apo_dni;
        $estudiante->alu_direccion = $request->alu_direccion;
        $estudiante->alu_telefono = $request->alu_telefono;
        $estudiante->alu_estado = $request->alu_estado;
        $estudiante->save();
    
        return redirect()->route('estudiante.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Estudiante actualizado con éxito.', 1, '/', null, false, false));
    }

    public function delete(){
        $estudiante = Estudiante::paginate(4); 
        return view('estudiante.eliminar', compact('estudiante'));
   }
    
   public function eliminando($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiante.eliminando', compact('estudiante'));
    }

    public function destroy(string $id)
    {
        $registro = Estudiante::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('estudiante.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Estudiante eliminado con éxito.', 1, '/', null, false, false));
    }

    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

}
