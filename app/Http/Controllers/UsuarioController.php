<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaLog;
use App\Models\Estudiante;
use App\Models\RecursosHumanos;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $estudiantes = Estudiante::all();
        $rrhh = RecursosHumanos::all();
        return view('usuario.crear',compact('roles','estudiantes','rrhh'));
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
        $search = $request->input('search');
    
        $usuarios = Usuario::with('rol')
            ->when($search, fn($q) =>
                $q->where('usu_login', 'like', '%' . $search . '%')
                  ->orWhere('correo', 'like', '%' . $search . '%'))
            ->paginate(15);
    
        return view('usuario.editar', compact('usuarios'));
    }
    
    public function show2(Request $request)
    {
        $search = $request->input('search');
    
        $usuarios = Usuario::with('rol')
            ->when($search, fn($q) =>
                $q->where('usu_login', 'like', '%' . $search . '%')
                  ->orWhere('correo', 'like', '%' . $search . '%'))
            ->paginate(15);
    
        return view('usuario.editar', compact('usuarios'));
    }
 
    public function editando($id)
    {
        // Filtrar el personal por el id del usuario
        $personal = Usuario::join('rrhh_personal', 'rrhh_personal.per_id', '=', 'auth_usuario.per_id')
                            ->select('rrhh_personal.per_dni', 'rrhh_personal.per_id')
                            ->where('auth_usuario.usu_id', $id)  // Filtrar por id del usuario
                            ->first();
    
        // Filtrar los estudiantes por el id del usuario
        $estudiantes = Usuario::join('acad_estudiantes', 'acad_estudiantes.alu_dni', '=', 'auth_usuario.alu_dni')
                               ->where('auth_usuario.usu_id', $id)  // Filtrar por id del usuario
                               ->first();
    
        // Obtener todos los estudiantes y personales (para los select)
        $todosLosPersonales = RecursosHumanos::all();
    
        $todosLosEstudiantes = Estudiante::all();
        $rol = Rol::join('auth_usuario','auth_usuario.idrol','=','rol.idrol')->select('rol.nombre_rol','rol.idrol')->where('auth_usuario.usu_id', $id)  // Filtrar por id del usuario
        ->first();
        $roles = Rol::all();
        // Obtener el usuario por el id
        $usuario = Usuario::findOrFail($id);
    
        // Pasar los datos a la vista
        return view('usuario.editando', compact('usuario', 'personal', 'estudiantes', 'todosLosPersonales', 'todosLosEstudiantes','roles','rol'));
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

    public function listarUsuarios(Request $request)
    {
        // Obtener el término de búsqueda (si existe)
        $search = $request->input('search');

        // Consultar usuarios con paginación y búsqueda
        $usuarios = Usuario::when($search, function ($query, $search) {
                $query->where('usu_login', 'like', '%' . $search . '%')
                      ->orWhere('correo', 'like', '%' . $search . '%');
            })
            ->with('rol') // Cargar relación con la tabla de roles
            ->paginate(10); // Paginación de 10 elementos por página

        // Retornar la vista con los datos paginados
        return view('usuario.listar', compact('usuarios', 'search'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function eliminando($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.eliminando', compact('usuario'));
    }

    public function destroy(string $id, Request $request)
    {
        $registro = Usuario::find($id);

    if ($registro) {
        // Elimina el registro
        $registro->delete();
            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'R';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Rol';
            $auditoria->save();

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







    public function indexAuditoria(Request $request)
    {
        $query = Auditorialog::query();

    // Filtros de búsqueda
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('entidad', 'like', "%$search%")
              ->orWhere('usuario', 'like', "%$search%")
              ->orWhere('operacion', 'like', "%$search%");
    } else {
        $search = ''; // Definir la variable $search para evitar errores
    }

    // Obtener los datos
    $auditorias = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('usuario.Auditoria', compact('auditorias', 'search'));
    }
}
