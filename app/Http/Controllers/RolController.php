<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function listado()
    {
        // Obtener todos los registros de la tabla 'rol'
        $roles = Rol::paginate(25); // O Rol::paginate(10) para paginación

        // Retornar la vista 'roles.index' y pasar los roles a la vista
        return view('rol.editar', compact('roles'));
    }

    public function listadoListar()
    {
        // Obtener todos los registros de la tabla 'rol'
        $roles = Rol::paginate(25); // O Rol::paginate(10) para paginación

        // Retornar la vista 'roles.index' y pasar los roles a la vista
        return view('rol.listar', compact('roles'));
    }

    public function index()
    {
        return view('rol.index');
    }

 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rol.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            try {
                // Validar los datos
                $request->validate([
                    'nombre_rol' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/','unique:rol,nombre_rol'],
                ]);

                // Crear el rol
                Rol::create([
                    'nombre_rol' => $request->nombre_rol
                ]);
                // Redirigir con cookie de éxito
                return redirect()->route('rol.create')
                    ->withCookie(cookie('success', 'Rol registrado con éxito.', 1, '/', null, false, false));

            } catch (\Exception $e) {
                // Manejar la excepción y enviar mensaje en cookie
                return redirect()->route('rol.create')
                    ->withCookie(cookie('error', 'Error al registrar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
            }
        }

 
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = Rol::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre_rol', 'like', '%' . $request->search . '%');
        }

        $roles = $query->paginate(15); // Cambia esto para paginación

        return view('rol.editar', compact('roles'));
    }

    public function showListar(Request $request)
    {
        $query = Rol::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre_rol', 'like', '%' . $request->search . '%');
        }

        $roles = $query->paginate(15); // Cambia esto para paginación

        return view('rol.listar', compact('roles'));
    }


    public function showEliminar(Request $request)
    {
        $query = Rol::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nombre_rol', 'like', '%' . $request->search . '%');
        }

        $roles = $query->paginate(15); // Cambia esto para paginación

        return view('rol.eliminar', compact('roles'));
    }

    public function editando($id)
    {
        $rol = Rol::findOrFail($id);
        return view('rol.editando', compact('rol'));
    }

    public function eliminandosss($id)
    {
        $rol = Rol::findOrFail($id);
        return view('rol.eliminando', compact('rol'));
    }

    public function eliminaNew($id){
        $rol = Rol::findOrFail($id);
        return view('rol.eliminando', compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Obtener todos los registros de la tabla 'rol'
        $roles = Rol::paginate(15); // O Rol::paginate(10) para paginación

        // Retornar la vista 'roles.index' y pasar los roles a la vista
        return view('rol.editar', compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        // Validar los datos
        $request->validate([
            'nombre_rol' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Solo permite letras y espacios
                'unique:rol,nombre_rol,' .  $id . ',idrol',  // Validar que el nombre de rol sea único, pero excluyendo el rol actual
            ],
        ]);

        // Encontrar el rol por ID
        $rol = Rol::findOrFail($id);

        // Actualizar el rol
        $rol->nombre_rol = $request->nombre_rol;
        $rol->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('rol.editar', ['id' => $id])
            ->withCookie(cookie('success', 'Rol actualizado con éxito.', 1, '/', null, false, false));

    } catch (\Exception $e) {
        // En caso de error, redirigir con mensaje de error en cookie
        return redirect()->route('rol.editar', ['id' => $id])
            ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registro = Rol::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();

        // Retorna una respuesta, redirige o envía un mensaje
        return redirect()->route('rol.eliminar') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Rol eliminado con éxito.', 1, '/', null, false, false));
    }

    return redirect()->back()->with('error', 'Registro no encontrado.');
    }

    public function delete()
    {
        // Obtener todos los registros de la tabla 'rol'
        $roles = Rol::paginate(15); // O Rol::paginate(10) para paginación

        // Retornar la vista 'roles.index' y pasar los roles a la vista
        return view('rol.eliminar', compact('roles'));
    }
}
