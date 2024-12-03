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

    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validator = FacadesValidator::make($request->all(), [
                'bim_sigla' => 'required|max:3|unique:bimestre,bim_sigla',
                'bim_descripcion' => 'required|max:15',
                'anio' => 'nullable|digits:4|integer',
                'fecha_inicio' => 'nullable|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            ]);

            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('bimestre.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
            }

            // Crear y guardar el nuevo bimestre
            $bimestre = new Bimestre();
            $bimestre->bim_sigla = $request->bim_sigla;
            $bimestre->bim_descripcion = $request->bim_descripcion;
            $bimestre->anio = $request->anio;
            $bimestre->fecha_inicio = $request->fecha_inicio;
            $bimestre->fecha_fin = $request->fecha_fin;
            $bimestre->save();

            // Redirigir con mensaje de éxito
            return redirect()->route('bimestre.create')
            ->withCookie(cookie('success', 'Bimestre registrado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            // Manejo de errores
           return redirect()->route('bimestre.create')
            ->withCookie(cookie('error', $e, 1, '/', null, false, false));
        }
    }
 
    public function show(Request $request)
    {
        $query = Bimestre::query();
    
        // Búsqueda por descripción
        if ($request->has('search') && $request->search != '') {
            $query->where('bim_descripcion', 'like', '%' . $request->search . '%');
        }
    
        // Paginación
        $bimestres = $query->paginate(4);
    
        return view('bimestre.editar', compact('bimestres'));
    }
    
    public function editando($id)
    {
        // Cargar el bimestre por la sigla
        $bimestre = Bimestre::findOrFail($id);
    
        return view('bimestre.editando', compact('bimestre'));
    }

    public function update(Request $request, $id)
{
    try {
        // Validar los datos del formulario
        $validator = FacadesValidator::make($request->all(), [
            'bim_sigla' => 'required|max:3|unique:bimestre,bim_sigla,' . $id . ',bim_sigla', // Excluye la sigla actual
            'bim_descripcion' => 'required|max:15',
            'anio' => 'nullable|digits:4|integer',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->route('bimestre.show', $id) // Cambia a la ruta que desees
                ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
        }

        // Encontrar el bimestre por su ID
        $bimestre = Bimestre::findOrFail($id);

        // Actualizar los campos
        $bimestre->bim_sigla = $request->bim_sigla;
        $bimestre->bim_descripcion = $request->bim_descripcion;
        $bimestre->anio = $request->anio;
        $bimestre->fecha_inicio = $request->fecha_inicio;
        $bimestre->fecha_fin = $request->fecha_fin;
        $bimestre->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('bimestre.show', $id) // Cambia a la ruta que desees
            ->withCookie(cookie('success', 'Bimestre actualizado con éxito.', 1, '/', null, false, false));

    } catch (\Exception $e) {
        // Manejo de errores
        return redirect()->route('bimestre.show', $id)
            ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
    }
}


    public function delete(Request $request){
        $query = Bimestre::query();
    
        // Búsqueda por descripción
        if ($request->has('search') && $request->search != '') {
            $query->where('bim_descripcion', 'like', '%' . $request->search . '%');
        }
    
        // Paginación
        $bimestres = $query->paginate(4);
    
        return view('bimestre.eliminar', compact('bimestres'));
   }

   public function eliminando($id)
    {
        // Cargar el bimestre por la sigla
        $bimestre = Bimestre::findOrFail($id);
    
        return view('bimestre.eliminando', compact('bimestre'));
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
