<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Nivel;
use Carbon\Carbon;
use App\Models\AuditoriaLog;
use App\Models\Bimestre;

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

    public function store(Request $request) {
        //
        try {
            $validator = FacadesValidator::make(request()->all(), [
                'nombre' => 'required',
            ]);
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('nivel.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
            $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            $nivel = new Nivel();
            $nivel->nombre = request()->nombre;
            $nivel->estado =  $anioActual;
            $nivel->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Nivel';
            $auditoria->save();


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
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
       
        $query->where('estado', '=', $anioActual);
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

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->route('nivel.show', $id) // Usamos 'edit' en lugar de 'create'
                ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
        }

        $nivel = Nivel::findOrFail($id); 
        $nivel->id_nivel = $id;
        $nivel->nombre = request()->nombre;
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $nivel->estado = $anioActual; 

        $nivel->save();

        $auditoria = new AuditoriaLog();
        $auditoria->usuario = $request->cookie('user_name');
        $auditoria->operacion = 'U';
        $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
        $auditoria->entidad = 'Nivel';
        $auditoria->save();
    
        return redirect()->route('nivel.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Nivel actualizado con éxito.', 1, '/', null, false, false));
    }


    public function delete(Request $request){
        
        $query = Nivel::query();
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
 
        $query->where('estado', '=', $anioActual);
        if ($request->has('search') && $request->search != '') {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $apoderado = $query->paginate(4); // Cambia esto para paginación

        return view('nivel.eliminar', compact('apoderado'));
   }

   public function eliminando($id)
    {

        $apoderado = Nivel::findOrFail($id);
        return view('nivel.eliminando', compact('apoderado'));
    }

    public function destroy(string $id, Request $request){
        $registro = Nivel::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();
        $auditoria = new AuditoriaLog();
        $auditoria->usuario = $request->cookie('user_name');
        $auditoria->operacion = 'D';
        $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
        $auditoria->entidad = 'Nivel';
        $auditoria->save();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('nivel.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Nivel eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }


    public function listar(Request $request)
{
    // Auditoría
    $auditoria = new AuditoriaLog();
    $auditoria->usuario = $request->cookie('user_name');
    $auditoria->operacion = 'R';
    $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
    $auditoria->entidad = 'Nivel';
    $auditoria->save();

    // Obtener el término de búsqueda si existe
    $search = $request->get('search', '');

    // Obtener el año actual
    $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');

    // Filtrar los niveles según el término de búsqueda y el año actual
    $niveles = Nivel::when($search, function ($query, $search) {
        return $query->where('nombre', 'LIKE', "%{$search}%");
    })
    ->when($anioActual, function ($query) use ($anioActual) {
        return $query->where('estado', '=', $anioActual); // Filtrar por el año actual en el campo estado
    })
    ->paginate(10); // Paginación

    return view('nivel.listar', compact('niveles', 'search'));
}


}
