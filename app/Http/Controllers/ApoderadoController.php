<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Apoderado;
use App\Models\AuditoriaLog;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Carbon\Carbon;
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
                'apo_dni' => 'required|unique:acad_apoderado,apo_dni',
                'apo_apellidos' => 'required',
                'apo_nombres' => 'required',
                'apo_direccion' => 'required',
                'apo_telefono' => 'required|unique:acad_apoderado,apo_telefono',
            ]);
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('apoderado.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
 
            $apoderado = new Apoderado();
            $apoderado->apo_dni = request()->apo_dni;
            $apoderado->apo_apellidos = request()->apo_apellidos;
            $apoderado->apo_nombres = request()->apo_nombres;
            $apoderado->apo_direccion = request()->apo_direccion;
            $apoderado->apo_telefono = request()->apo_telefono;
            $apoderado->save();

           
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Apoderado';
            $auditoria->save();



            // Redirigir con cookie de éxito
            return redirect()->route('apoderado.create')
                ->withCookie(cookie('success', 'Apoderado registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('apoderado.create')
            ->withCookie(cookie('error', 'Error al registrar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
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
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'apo_dni' => 'required|unique:acad_apoderado,apo_dni,' . $id . ',apo_dni' ,// Excluir el DNI actual
                'apo_apellidos' => 'required',
                'apo_nombres' => 'required',
                'apo_direccion' => 'required',
                'apo_telefono' => 'required|unique:acad_apoderado,apo_telefono,'. $id . ',apo_dni' ,
            ]);
    
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('apoderado.show', $id) // Usamos 'edit' en lugar de 'create'
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
    
            // Encontrar el apoderado por el ID
            $apoderado = Apoderado::findOrFail($id);
    
            // Actualizar los campos
            $apoderado->apo_dni = $request->apo_dni;
            $apoderado->apo_apellidos = $request->apo_apellidos;
            $apoderado->apo_nombres = $request->apo_nombres;
            $apoderado->apo_direccion = $request->apo_direccion;
            $apoderado->apo_telefono = $request->apo_telefono;
            $apoderado->save();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Apoderado';
            $auditoria->save();
    
            // Redirigir con mensaje de éxito
            return redirect()->route('apoderado.show', $id) // Cambia a la ruta que desees
                ->withCookie(cookie('success', 'Apoderado actualizado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Manejar la excepción (puedes loguear el error o mostrar un mensaje)
            return redirect()->route('apoderado.show', $id)
                ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
        }
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

    public function destroy(string $id, Request $request){
        $registro = Apoderado::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Apoderado';
            $auditoria->save();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('apoderado.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Apoderado eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

 

    public function listar(Request $request)
    {
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Apoderado';
            $auditoria->save();
        $query = Apoderado::query();
        
        // Filtro de búsqueda
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('apo_dni', 'like', '%' . $search . '%')
                  ->orWhere('apo_apellidos', 'like', '%' . $search . '%')
                  ->orWhere('apo_nombres', 'like', '%' . $search . '%')
                  ->orWhere('apo_direccion', 'like', '%' . $search . '%')
                  ->orWhere('apo_telefono', 'like', '%' . $search . '%');
        }

        // Paginación con 10 elementos por página
        $apoderados = $query->paginate(10);

        // Retornar vista con los registros
        return view('apoderado.listar', compact('apoderados'));
    }
}
