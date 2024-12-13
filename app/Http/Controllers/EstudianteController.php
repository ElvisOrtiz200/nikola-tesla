<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\AuditoriaLog;
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
                'alu_dni' => 'required|unique:acad_estudiantes,alu_dni',
                'alu_apellidos' => 'required',
                'alu_nombres' => 'required',
                'apo_dni' => 'required',
                'alu_direccion' => 'required',
                'alu_telefono' => 'required',
            ]);
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('estudiante.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
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



            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Estudiante';
            $auditoria->save();

            // Redirigir con cookie de éxito
            return redirect()->route('estudiante.create')
                ->withCookie(cookie('success', 'Estudiante registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('estudiante.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada', 1));
        }
    }

   

    public function show(Request $request)
    {
        $query = Estudiante::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('alu_dni', 'like', '%' . $request->search . '%');
        }
    
        $estudiantes = $query->paginate(4); // Cambia esto para paginación
        $apoderados = Apoderado::all(); // Obtener todos los apoderados
    
        return view('estudiante.editar', compact('estudiantes', 'apoderados'));
    }
    

    public function listadoListar(Request $request)
    {

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Estudiante';
            $auditoria->save();

        // Crear la consulta base 
        $query = Estudiante::with('apoderado');

        // Si se pasa un término de búsqueda, se agrega el filtro
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('alu_dni', 'like', '%' . $request->search . '%')
                  ->orWhere('alu_apellidos', 'like', '%' . $request->search . '%')
                  ->orWhere('alu_nombres', 'like', '%' . $request->search . '%');
                  
            });
        }

        // Obtener los estudiantes paginados
        $estudiantes = $query->paginate(10);


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
    $apoderados = Apoderado::all(); // Obtener todos los apoderados
    $estudiantes = Estudiante::all(); // Obtener todos los estudiantes

    return view('estudiante.editando', compact('estudiante', 'apoderados', 'estudiantes'));
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

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Estudiante';
            $auditoria->save();
    
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

    public function destroy(string $id, Request $request)
    {
        $registro = Estudiante::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Estudiante';
            $auditoria->save();
        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('estudiante.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Estudiante eliminado con éxito.', 1, '/', null, false, false));
    }

    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

}
