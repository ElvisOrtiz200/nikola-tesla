<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return view('usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuario.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = Usuario::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('usu_login', 'like', '%' . $request->search . '%');
        }

        $usuarios = Usuario::with('rol')->paginate(15); // Cambia esto para paginación

        return view('usuario.editar', compact('usuarios'));
    }

    public function editando($id)
    {
        $usuario = Usuario::findOrFail($id);

        return view('usuario.editando', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('usuario.editar');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         
    }

    /**
     * Remove the specified resource from storage.
     */

    public function eliminando($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.eliminando', compact('usuario'));
    }

    public function destroy(string $id)
    {
        $registro = Usuario::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('usuario.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Usuario eliminado con éxito.', 1, '/', null, false, false));
    }

    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

    public function delete(){
         // Obtener todos los registros de la tabla 'rol'
         $usuario = Usuario::paginate(5); // O Rol::paginate(10) para paginación

         // Retornar la vista 'roles.index' y pasar los roles a la vista
         return view('usuario.eliminar', compact('usuario'));
    }
}
