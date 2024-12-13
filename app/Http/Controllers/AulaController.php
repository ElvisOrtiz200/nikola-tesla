<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaLog;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\Aula;
use App\Models\Bimestre;
use App\Models\Nivel;
use Carbon\Carbon;

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
        // $bimSigla = Bimestre::where('estadoBIMESTRE', '=', '1')->value('bim_sigla');
        // $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        // $anioActual = now()->year;
        // dd($anioActual);
        // dd($bimSigla, $anio );
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $niveles = Nivel::with('grados')->where('estado','=',$anio)->get(); 
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
            $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            $grado->estado =$anio ;
            $grado->save();


            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Aula';
            $auditoria->save();

            
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
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $query =Aula::query(); 
    
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        
        }
        $query->where('estado', '=', $anioActual);
    
        $aula = $query->paginate(20); // Cambia esto para paginación
    
        return view('aula.editar', compact('aula'));
        }




       public function editando($id, Request $request)
        {
        // Cargar todos los grados para el dropdown
        // $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        // $niveles = Nivel::where('estado', '=', $anio)->get();
        $anio = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $grados = Grado::where('estado', '=', $anio)->get();
        
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
            $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
            $aulas->estado = $anioActual;
            // Guardar los cambios
            $aulas->save();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Aula';
            $auditoria->save();
            
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
        $query =Aula::query(); 
        
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        
        }
        $query->where('estado', '=', $anioActual);
        $aula = $query->paginate(20); // Cambia esto para paginación
    
        return view('aula.eliminar', compact('aula')); 
   }
 
   public function eliminando($id){
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $grados = Grado::where('estado','=',$anioActual);

        // Obtener el docente con la relación cargada
        $aulas = Aula::with('grado')->findOrFail($id);
    
        return view('aula.eliminando', compact('grados', 'aulas'));
    }

    public function destroy(string $id, Request $request){
        $registro = Aula::find($id);
        if ($registro) {
            // Elimina el registro
            $registro->delete();
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'D';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Aula';
            $auditoria->save();

            // Retorna una respuesta, redirige o envía un mensaje
            return redirect()->route('aula.eliminar') // Cambia a la ruta que desees
            ->withCookie(cookie('success', 'Aula eliminado con éxito.', 1, '/', null, false, false));
        }
        return redirect()->back()->with('error', 'Registro no encontrado.');
    }



    public function listar(Request $request)
    {
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Aula';
            $auditoria->save();
        // Crear una consulta básica
        $query = Aula::with('grado.nivel');
        $anioActual = Bimestre::where('estadoBIMESTRE', '=', '1')->value('anio');
        $query->where('estado', '=', $anioActual);
        // Aplicar filtro si se recibe un parámetro de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%') // Filtrar por nombre del aula
                    ->orWhereHas('grado', function ($subquery) use ($request) {
                        $subquery->where('nombre', 'like', '%' . $request->search . '%'); // Filtrar por grado
                    });
            });
        }

        // Paginación de 10 elementos por página
        $aulas = $query->paginate(10);

        return view('aula.listar', compact('aulas'));
    }
}
