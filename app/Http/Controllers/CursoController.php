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

    public function listar(Request $request)
    {
        // Obtener los filtros de búsqueda
        $searchCurso = $request->query('searchCurso');
        $searchGrado = $request->query('searchGrado');
        $searchNivel = $request->query('searchNivel');

        // Consultar cursos con relación a grado y nivel, aplicando filtros
        $cursos = Curso::with('grado.nivel')
            ->when($searchCurso, function ($query, $searchCurso) {
                return $query->where('acu_nombre', 'LIKE', '%' . $searchCurso . '%');
            })
            ->when($searchGrado, function ($query, $searchGrado) {
                return $query->whereHas('grado', function ($q) use ($searchGrado) {
                    $q->where('nombre', 'LIKE', '%' . $searchGrado . '%');
                });
            })
            ->when($searchNivel, function ($query, $searchNivel) {
                return $query->whereHas('grado.nivel', function ($q) use ($searchNivel) {
                    $q->where('nombre', 'LIKE', '%' . $searchNivel . '%');
                });
            })
            ->paginate(10);

        return view('curso.listar', compact('cursos'));
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
                'acu_nombre' => 'required|unique:acad_cursos,acu_nombre',
                'id_grado' => 'required'
               
              
            ]);
            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->route('curso.create')
                    ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
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
        $search = $request->query('search');
        $cursos = Curso::with('grado.nivel')
            ->when($search, function ($query, $search) {
                $query->where('acu_nombre', 'like', '%' . $search . '%');
            })
            ->paginate(10); // Paginación de 10 elementos por página

        return view('curso.editar', compact('cursos', 'search'));
    }

    public function editando($id)
    {
        $curso = Curso::findOrFail($id);
        // $curso = AcadCurso::findOrFail($id);
        $grados = Grado::all(); // Obtener todos los grados para el dropdown
        // return view('cursos.edit', compact('curso', 'grados'));
        return view('curso.editando', compact('curso','grados'));
    }


    public function update(Request $request, $id) {

        
        $request->validate([
            'acu_nombre' => 'required|string|max:200|unique:acad_cursos,acu_nombre,' . $id . ',acu_id',
            'id_grado' => 'nullable|exists:acad_grado,id_grado',
        ]);
    
        $curso = Curso::findOrFail($id);
        $curso->acu_nombre = $request->acu_nombre;
        $curso->id_grado = $request->id_grado;
        $curso->save();
    
        return redirect()->route('curso.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Apoderado actualizado con éxito.', 1, '/', null, false, false));
    }

    public function delete(Request $request){
        $search = $request->query('search');

        $cursos = Curso::with('grado')
            ->when($search, function ($query, $search) {
                return $query->where('acu_nombre', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        return view('curso.eliminar', compact('cursos'));
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
