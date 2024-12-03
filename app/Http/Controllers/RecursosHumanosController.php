<?php

namespace App\Http\Controllers;

use App\Models\RecursosHumanos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;


class RecursosHumanosController extends Controller
{
    public function index()    {
        return view('recursoHumano.index');
    }

    public function create()    {
        return view('recursoHumano.crear');
    }

    public function store(Request $request) {
        try {
            // Validación de los datos
            $validator = FacadesValidator::make($request->all(), [
                'per_apellidos' => 'required',
                'per_nombres' => 'required',
                'per_cargo' => 'required',
                'per_fecha_inicio' => 'required|date_format:Y-m-d',
                'per_fecha_fin' => 'required|date_format:Y-m-d',
                'per_dni' => 'required|digits:8|unique:rrhh_personal,per_dni', // Validar DNI único
                 'per_telefono' => 'required|string|max:50|unique:rrhh_personal,per_telefono',
                'per_direccion' => 'required'
            ]);
            
            // Si la validación falla
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('recursoshh.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
            
            // Crear nuevo recurso humano
            $recursohh = new RecursosHumanos();
            $recursohh->per_apellidos = $request->per_apellidos;
            $recursohh->per_nombres = $request->per_nombres;
            $recursohh->per_cargo = $request->per_cargo;
            $recursohh->per_fecha_inicio = \Carbon\Carbon::parse($request->per_fecha_inicio)->format('Y-m-d');
            $recursohh->per_fecha_fin = \Carbon\Carbon::parse($request->per_fecha_fin)->format('Y-m-d');
            $recursohh->per_dni = $request->per_dni;
            $recursohh->per_telefono = $request->per_telefono;
            $recursohh->per_direccion = $request->per_direccion;
            $recursohh->per_estado = 'A';
    
            // Guardar en la base de datos
            $recursohh->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('recursoshh.create')
                ->withCookie(cookie('success', 'Recurso Humano registrado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Log del error y redirigir con mensaje de error
    
            return redirect()->route('recursoshh.create')
                ->withCookie(cookie('error', 'Error al registrar. Operación cancelada: ' . $e->getMessage(), 1));
        }
    }
    
    public function show(Request $request){
        $query = RecursosHumanos::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('per_dni', 'like', '%' . $request->search . '%');
        }

        $rrhh = $query->paginate(4); // Cambia esto para paginación

        return view('recursoHumano.editar', compact('rrhh'));
    }

    public function editando($id)
    {
        $rrhh = RecursosHumanos::findOrFail($id);

        return view('recursoHumano.editando', compact('rrhh'));
    }

    public function update(Request $request, $id) {
        try {
            // Validar los datos
            $validator = FacadesValidator::make($request->all(), [
                'per_apellidos' => 'required',
                'per_nombres' => 'required',
                'per_cargo' => 'required',
                'per_fecha_inicio' => 'required|date_format:Y-m-d',
                'per_fecha_fin' => 'required|date_format:Y-m-d',
                'per_dni' => 'required|digits:8|unique:rrhh_personal,per_dni,' . $id . ',per_id', // Excluir el DNI del registro actual
                'per_telefono' => 'required|string|max:50|unique:rrhh_personal,per_telefono,' . $id . ',per_id', // Excluir el teléfono del registro actual
                'per_direccion' => 'required',
                'per_estado' => 'required'
            ]);
    
            // Si la validación falla
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('recursoshh.show', $id) // Usamos 'edit' en lugar de 'create'
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }
    
            // Buscar el recurso humano por ID
            $recursohh = RecursosHumanos::findOrFail($id); 
    
            // Actualizar los campos
            $recursohh->per_apellidos = $request->per_apellidos;
            $recursohh->per_nombres = $request->per_nombres;
            $recursohh->per_cargo = $request->per_cargo;
            $recursohh->per_dni = $request->per_dni;
            $recursohh->per_telefono = $request->per_telefono;
            $recursohh->per_direccion = $request->per_direccion;
            $recursohh->per_estado = $request->per_estado;
    
            // Formatear fechas antes de guardar
            $recursohh->per_fecha_inicio = Carbon::parse($request->per_fecha_inicio)->format('Y-m-d');
            $recursohh->per_fecha_fin = Carbon::parse($request->per_fecha_fin)->format('Y-m-d');
    
            // Guardar los cambios
            $recursohh->save();
    
            // Redirigir con cookie de éxito
            return redirect()->route('recursoshh.show') // Cambia a la ruta que desees
                ->withCookie(cookie('success', 'Recurso Humano actualizado con éxito.', 1, '/', null, false, false));
    
        } catch (\Exception $e) {
            // Log del error y redirigir con mensaje de error
    
            return redirect()->route('recursoshh.show', $id)
                ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1));
        }
    }

    public function delete(Request $request){
        $query = RecursosHumanos::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('per_dni', 'like', '%' . $request->search . '%');
        }

        $rrhh = $query->paginate(4); // Cambia esto para paginación

        return view('recursoHumano.eliminar', compact('rrhh'));
   }

   public function eliminando($id)
    {
        $rrhh = RecursosHumanos::findOrFail($id);
        return view('recursoHumano.eliminando', compact('rrhh'));
    }

    public function destroy(string $id){
        $registro = RecursosHumanos::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('recursoshh.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Recurso Humano eliminado con éxito.', 1, '/', null, false, false));
    }
    return redirect()->back()->with('error', 'Registro no encontrado.');
    }


    public function listar(Request $request)
    {
        // Obtener el valor del buscador
        $search = $request->input('search');

        // Realizar la consulta
        $personales = RecursosHumanos::when($search, function ($query, $search) {
            return $query->where('per_dni', 'like', '%' . $search . '%')
                         ->orWhere('per_apellidos', 'like', '%' . $search . '%');
        })->paginate(10); // Paginación con 10 registros por página

        // Retornar la vista con los resultados
        return view('recursoHumano.listar', compact('personales', 'search'));
    }
}
