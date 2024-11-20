<?php

use App\Http\Controllers\ApoderadoController;
use App\Http\Controllers\AulaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BimestreController;
use App\Http\Controllers\Curso_DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\docentesCursosVistaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EstudianteCursoController;
use App\Http\Controllers\estudiantesCursosVistaController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\RecursosHumanosController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Models\AcadNota;
use App\Models\Curso_Docente;
use App\Models\RecursosHumanos;
use App\Models\Usuario;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 
Route::get('/login', function () {        
    return view('login');    
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    
    
    Route::get('/dashboard', function () {
        $user = JWTAuth::parseToken()->authenticate();
        $idrol = $user->idrol;  // Asumiendo que idrol es un atributo del modelo Usuario
    
        // Enviar el rol a la vista
        return view('dashboard', compact('idrol'));
    })->middleware('check.token')->name('dashboard');


    Route::get('/meC/{user}', function ($user) {
        // Recuperar un solo usuario con join en rol
        $user = App\Models\Usuario::where('auth_usuario.usu_id', $user)
            ->join('rol', 'auth_usuario.idrol', '=', 'rol.idrol')
            ->firstOrFail(); // Cambiamos get() por firstOrFail()
        
        return view('usuario', ['user' => $user]);
    })->middleware('check.token')->name('meC');

    Route::get('/rol',[RolController::class, 'index'])->middleware('check.token')->name('rol.index');
    Route::get('/rol/crear',[RolController::class, 'create'])->middleware('check.token')->name('rol.create');
    Route::post('/rol/crear/creado',[RolController::class, 'store'])->middleware('check.token')->name('rol.store');
    Route::get('/rol/editar/',[RolController::class, 'edit'])->middleware('check.token')->name('rol.editar');
    Route::get('/rol/editar/{id}/',[RolController::class, 'editando'])->middleware('check.token')->name('rol.editando');
    Route::get('/rol/elimiadasdasdasdasdasnar/{id}/',[RolController::class, 'eliminaNew'])->middleware('check.token')->name('rol.eliminaelimina');
    Route::get('/rol/eliminar/{id}/',[RolController::class, 'eliminando'])->middleware('check.token')->name('rol.eliminandos');
    Route::get('/rol/eliminar/{id}/',[RolController::class, 'eliminandosss'])->middleware('check.token')->name('rol.deleteando');
    Route::put('/rol/editar/update/{id}/',[RolController::class, 'update'])->middleware('check.token')->name('rol.update');
    Route::delete('/rol/eliminar/destroy/{id}/',[RolController::class, 'destroy'])->middleware('check.token')->name('rol.destroy');
    route::get('/rol/encontrado', [RolController::class, 'show'])->middleware('check.token')->name('rol.show');
    route::get('/rol/encontrado2', [RolController::class, 'showListar'])->middleware('check.token')->name('rol.showListar');
    route::get('/rol/encontrado3', [RolController::class, 'showEliminar'])->middleware('check.token')->name('rol.showEliminar');
    route::get('/rol/lista', [RolController::class, 'listadoListar'])->middleware('check.token')->name('rol.lista');
    Route::get('/rol/eliminar/',[RolController::class, 'delete'])->middleware('check.token')->name('rol.eliminar');

// USUARIOS
    Route::get('/usuario',[UsuarioController::class, 'index'])->middleware('check.token')->name('usuario.index');
    Route::get('/usuario/crear',[UsuarioController::class, 'create'])->middleware('check.token')->name('usuario.create');
    Route::get('/usuario/editar',[UsuarioController::class, 'edit'])->middleware('check.token')->name('usuario.edit');
    Route::get('/usuario/crear',[UsuarioController::class,'create'])->middleware(('check.token'))->name('usuario.crear');
    Route::get('/usuario/editar',[UsuarioController::class,'show'])->middleware(('check.token'))->name('usuario.show');
    Route::get('/usuario/editar/{id}/',[UsuarioController::class, 'editando'])->middleware('check.token')->name('usuario.editando');
    Route::put('/usuario/editar/update/{id}/',[AuthController::class, 'update'])->middleware('check.token')->name('usuario.update');
    Route::get('/usuario/eliminar/',[UsuarioController::class, 'delete'])->middleware('check.token')->name('usuario.eliminar');
    Route::delete('/usuario/eliminar/destroy/{id}/',[UsuarioController::class, 'destroy'])->middleware('check.token')->name('usuario.destroy');
    Route::get('/rol/eliminar/{id}/',[UsuarioController::class, 'eliminando'])->middleware('check.token')->name('usuario.eliminando');

// ESTUDANTES
    Route::get('/estudiante',[EstudianteController::class, 'index'])->middleware('check.token')->name('estudiante.index');
    Route::get('/estudiante/crear',[EstudianteController::class, 'create'])->middleware('check.token')->name('estudiante.create');
    Route::post('/estudiante/crear/creado',[EstudianteController::class, 'store'])->middleware('check.token')->name('estudiante.store');
    Route::get('/estudiante/editar',[EstudianteController::class,'show'])->middleware(('check.token'))->name('estudiante.show');
    route::get('/estudiante/lista', [EstudianteController::class, 'listadoListar'])->middleware('check.token')->name('estudiante.lista');
    
    Route::get('/estudiante/editar/{id}/',[EstudianteController::class, 'editando'])->middleware('check.token')->name('estudiante.editando');
    Route::put('/estudiante/editar/update/{id}/',[EstudianteController::class, 'update'])->middleware('check.token')->name('estudiante.update');
    Route::get('/estudiante/eliminar/',[EstudianteController::class, 'delete'])->middleware('check.token')->name('estudiante.eliminar');
    Route::get('/estudiante/eliminar/{id}/',[EstudianteController::class, 'eliminando'])->middleware('check.token')->name('estudiante.eliminando');
    Route::delete('/estudiante/eliminar/destroy/{id}/',[EstudianteController::class, 'destroy'])->middleware('check.token')->name('estudiante.destroy');


//APODERADOS
    //Home
    Route::get('/apoderado',[ApoderadoController::class, 'index'])->middleware('check.token')->name('apoderado.index');
    //Create
    Route::get('/apoderado/crear',[ApoderadoController::class, 'create'])->middleware('check.token')->name('apoderado.create');
    Route::post('/apoderado/crear/creado',[ApoderadoController::class, 'store'])->middleware('check.token')->name('apoderado.store');
    //Update
    Route::get('/apoderado/editar',[ApoderadoController::class,'show'])->middleware(('check.token'))->name('apoderado.show');
    Route::get('/apoderado/editar/{id}/',[ApoderadoController::class, 'editando'])->middleware('check.token')->name('apoderado.editando');
    Route::put('/apoderado/editar/update/{id}/',[ApoderadoController::class, 'update'])->middleware('check.token')->name('apoderado.update');
    //Delete
    Route::get('/apoderado/eliminar/',[ApoderadoController::class, 'delete'])->middleware('check.token')->name('apoderado.eliminar');
    Route::get('/apoderado/eliminar/{id}/',[ApoderadoController::class, 'eliminando'])->middleware('check.token')->name('apoderado.eliminando');
    Route::delete('/apoderado/eliminar/destroy/{id}/',[ApoderadoController::class, 'destroy'])->middleware('check.token')->name('apoderado.destroy');

//RECURSOS HUMANOS
    //Home
    Route::get('/recursoshh',[RecursosHumanosController::class, 'index'])->middleware('check.token')->name('recursoshh.index');
    //Create
    Route::get('/recursoshh/crear',[RecursosHumanosController::class, 'create'])->middleware('check.token')->name('recursoshh.create');
    Route::post('/recursoshh/crear/creado',[RecursosHumanosController::class, 'store'])->middleware('check.token')->name('recursoshh.store');
    //Update
    Route::get('/recursoshh/editar',[RecursosHumanosController::class,'show'])->middleware(('check.token'))->name('recursoshh.show');
    Route::get('/recursoshh/editar/{id}/',[RecursosHumanosController::class, 'editando'])->middleware('check.token')->name('recursoshh.editando');
    Route::put('/recursoshh/editar/update/{id}/',[RecursosHumanosController::class, 'update'])->middleware('check.token')->name('recursoshh.update');
    //Delete
    Route::get('/recursoshh/eliminar/',[RecursosHumanosController::class, 'delete'])->middleware('check.token')->name('recursoshh.eliminar');
    Route::get('/recursoshh/eliminar/{id}/',[RecursosHumanosController::class, 'eliminando'])->middleware('check.token')->name('recursoshh.eliminando');
    Route::delete('/recursoshh/eliminar/destroy/{id}/',[RecursosHumanosController::class, 'destroy'])->middleware('check.token')->name('recursoshh.destroy');

//DOCENTES
    //Home 
    Route::get('/docente',[DocenteController::class, 'index'])->middleware('check.token')->name('docente.index');
    //Create
    Route::get('/docente/crear',[DocenteController::class, 'create'])->middleware('check.token')->name('docente.create');
    Route::post('/docente/crear/creado',[DocenteController::class, 'store'])->middleware('check.token')->name('docente.store');
    //Update
    Route::get('/docente/editar',[DocenteController::class,'show'])->middleware(('check.token'))->name('docente.show');
    Route::get('/docente/editar/{id}/',[DocenteController::class, 'editando'])->middleware('check.token')->name('docente.editando');
    Route::put('/docente/editar/update/{id}/',[DocenteController::class, 'update'])->middleware('check.token')->name('docente.update');
    //Delete
    Route::get('/docente/eliminar/',[DocenteController::class, 'delete'])->middleware('check.token')->name('docente.eliminar');
    Route::get('/docente/eliminar/{id}/',[DocenteController::class, 'eliminando'])->middleware('check.token')->name('docente.eliminando');
    Route::delete('/docente/eliminar/destroy/{id}/',[DocenteController::class, 'destroy'])->middleware('check.token')->name('docente.destroy');


//NIVEL
    //Home 
    Route::get('/nivel',[NivelController::class, 'index'])->middleware('check.token')->name('nivel.index');
    //Create
    Route::get('/nivel/crear',[NivelController::class, 'create'])->middleware('check.token')->name('nivel.create');
    Route::post('/nivel/crear/creado',[NivelController::class, 'store'])->middleware('check.token')->name('nivel.store');
    //Update
    Route::get('/nivel/editar',[NivelController::class,'show'])->middleware(('check.token'))->name('nivel.show');
    Route::get('/nivel/editar/{id}/',[NivelController::class, 'editando'])->middleware('check.token')->name('nivel.editando');
    Route::put('/nivel/editar/update/{id}/',[NivelController::class, 'update'])->middleware('check.token')->name('nivel.update');
    //Delete
    Route::get('/nivel/eliminar/',[NivelController::class, 'delete'])->middleware('check.token')->name('nivel.eliminar');
    Route::get('/nivel/eliminar/{id}/',[NivelController::class, 'eliminando'])->middleware('check.token')->name('nivel.eliminando');
    Route::delete('/nivel/eliminar/destroy/{id}/',[NivelController::class, 'destroy'])->middleware('check.token')->name('nivel.destroy');

//Grado
    //Home 
    Route::get('/grado',[GradoController::class, 'index'])->middleware('check.token')->name('grado.index');
    //Create
    Route::get('/grado/crear',[GradoController::class, 'create'])->middleware('check.token')->name('grado.create');
    Route::post('/grado/crear/creado',[GradoController::class, 'store'])->middleware('check.token')->name('grado.store');
    //Update
    Route::get('/grado/editar',[GradoController::class,'show'])->middleware(('check.token'))->name('grado.show');
    Route::get('/grado/editar/{id}/',[GradoController::class, 'editando'])->middleware('check.token')->name('grado.editando');
    Route::put('/grado/editar/update/{id}/',[GradoController::class, 'update'])->middleware('check.token')->name('grado.update');
    //Delete
    Route::get('/grado/eliminar/',[GradoController::class, 'delete'])->middleware('check.token')->name('grado.eliminar');
    Route::get('/grado/eliminar/{id}/',[GradoController::class, 'eliminando'])->middleware('check.token')->name('grado.eliminando');
    Route::delete('/grado/eliminar/destroy/{id}/',[GradoController::class, 'destroy'])->middleware('check.token')->name('grado.destroy');

//Aula
    //Home 
    Route::get('/aula',[AulaController::class, 'index'])->middleware('check.token')->name('aula.index');
    //Create
    Route::get('/aula/crear',[AulaController::class, 'create'])->middleware('check.token')->name('aula.create');
    Route::post('/aula/crear/creado',[AulaController::class, 'store'])->middleware('check.token')->name('aula.store');
    //Update
    Route::get('/aula/editar',[AulaController::class,'show'])->middleware(('check.token'))->name('aula.show');
    Route::get('/aula/editar/{id}/',[AulaController::class, 'editando'])->middleware('check.token')->name('aula.editando');
    Route::put('/aula/editar/update/{id}/',[AulaController::class, 'update'])->middleware('check.token')->name('aula.update');
    //Delete
    Route::get('/aula/eliminar/',[AulaController::class, 'delete'])->middleware('check.token')->name('aula.eliminar');
    Route::get('/aula/eliminar/{id}/',[AulaController::class, 'eliminando'])->middleware('check.token')->name('aula.eliminando');
    Route::delete('/aula/eliminar/destroy/{id}/',[AulaController::class, 'destroy'])->middleware('check.token')->name('aula.destroy');

 
//CURSOS
    //Home
    Route::get('/cursos',[CursoController::class, 'index'])->middleware('check.token')->name('curso.index');
    //Create
    Route::get('/cursos/crear',[CursoController::class, 'create'])->middleware('check.token')->name('curso.create');
    Route::post('/cursos/crear/creado',[CursoController::class, 'store'])->middleware('check.token')->name('curso.store');
    //Update
    Route::get('/cursos/editar',[CursoController::class,'show'])->middleware(('check.token'))->name('curso.show');
    // Route::get('/apoderado/editar/{id}/',[ApoderadoController::class, 'editando'])->middleware('check.token')->name('apoderado.editando');
    // Route::put('/apoderado/editar/update/{id}/',[ApoderadoController::class, 'update'])->middleware('check.token')->name('apoderado.update');
    // //Delete
    // Route::get('/apoderado/eliminar/',[ApoderadoController::class, 'delete'])->middleware('check.token')->name('apoderado.eliminar');
    // Route::get('/apoderado/eliminar/{id}/',[ApoderadoController::class, 'eliminando'])->middleware('check.token')->name('apoderado.eliminando');
    // Route::delete('/apoderado/eliminar/destroy/{id}/',[ApoderadoController::class, 'destroy'])->middleware('check.token')->name('apoderado.destroy');

    
//BIMESTRES
    //Home
    Route::get('/bimestres',[BimestreController::class, 'index'])->middleware('check.token')->name('bimestre.index');
    //Create
    Route::get('/bimestres/crear',[BimestreController::class, 'create'])->middleware('check.token')->name('bimestre.create');
    Route::post('/bimestres/crear/creado',[BimestreController::class, 'store'])->middleware('check.token')->name('bimestre.store');
    //Update
    Route::get('/bimestres/editar',[BimestreController::class,'show'])->middleware(('check.token'))->name('bimestre.show');
    // Route::get('/apoderado/editar/{id}/',[ApoderadoController::class, 'editando'])->middleware('check.token')->name('apoderado.editando');
    // Route::put('/apoderado/editar/update/{id}/',[ApoderadoController::class, 'update'])->middleware('check.token')->name('apoderado.update');
    // //Delete
    // Route::get('/apoderado/eliminar/',[ApoderadoController::class, 'delete'])->middleware('check.token')->name('apoderado.eliminar');
    // Route::get('/apoderado/eliminar/{id}/',[ApoderadoController::class, 'eliminando'])->middleware('check.token')->name('apoderado.eliminando');
    // Route::delete('/apoderado/eliminar/destroy/{id}/',[ApoderadoController::class, 'destroy'])->middleware('check.token')->name('apoderado.destroy');


        
//CURSOS_DOCENTES
    //Home
    Route::get('/curso-docente',[Curso_DocenteController::class, 'index'])->middleware('check.token')->name('curso-docente.index');
    //Create
    Route::get('/curso-docente/crear',[Curso_DocenteController::class, 'create'])->middleware('check.token')->name('curso-docente.create');
    Route::post('/curso-docente', [Curso_DocenteController::class, 'store'])->middleware('check.token')->name('curso-docente.store');;
    //Update
    Route::get('/bimestres/editar',[BimestreController::class,'show'])->middleware(('check.token'))->name('bimestre.show');
    // Route::get('/apoderado/editar/{id}/',[ApoderadoController::class, 'editando'])->middleware('check.token')->name('apoderado.editando');
    // Route::put('/apoderado/editar/update/{id}/',[ApoderadoController::class, 'update'])->middleware('check.token')->name('apoderado.update');
    // //Delete
    // Route::get('/apoderado/eliminar/',[ApoderadoController::class, 'delete'])->middleware('check.token')->name('apoderado.eliminar');
    // Route::get('/apoderado/eliminar/{id}/',[ApoderadoController::class, 'eliminando'])->middleware('check.token')->name('apoderado.eliminando');
    // Route::delete('/apoderado/eliminar/destroy/{id}/',[ApoderadoController::class, 'destroy'])->middleware('check.token')->name('apoderado.destroy');
    


//ESTUDIANTES-CURSO-GRADO
    //Home
    Route::get('/estudiante-curso',[EstudianteCursoController::class, 'index'])->middleware('check.token')->name('estudiante-curso.index');
    //Create
    Route::get('/estudiante-curso/crear',[EstudianteCursoController::class, 'create'])->middleware('check.token')->name('estudiante-curso.create');
    Route::post('/estudiante-curso/crear/creado',[EstudianteCursoController::class, 'store'])->middleware('check.token')->name('estudiante-curso.store');
    //Update
    Route::get('/estudiante-curso/editar',[EstudianteCursoController::class,'show'])->middleware(('check.token'))->name('estudiante-curso.show');
    Route::get('/estudiante-curso/editar/{id}/',[EstudianteCursoController::class, 'editando'])->middleware('check.token')->name('estudiante-curso.editando');
    Route::put('/estudiante-curso/editar/update/{id}/',[EstudianteCursoController::class, 'update'])->middleware('check.token')->name('estudiante-curso.update');
    //Delete
    Route::get('/estudiante-curso/eliminar/',[EstudianteCursoController::class, 'delete'])->middleware('check.token')->name('estudiante-curso.eliminar');
    Route::get('/estudiante-curso/eliminar/{id}/',[EstudianteCursoController::class, 'eliminando'])->middleware('check.token')->name('estudiante-curso.eliminando');
    Route::delete('/estudiante-curso/eliminar/destroy/{id}/',[EstudianteCursoController::class, 'destroy'])->middleware('check.token')->name('estudiante-curso.destroy');



//HORARIOS
    //Home
    Route::get('/horario',[HorarioController::class, 'index'])->middleware('check.token')->name('horario.index');
    //Create
    Route::get('/horario/crear',[HorarioController::class, 'create'])->middleware('check.token')->name('horario.create');
    Route::post('/horario/crear/creado',[HorarioController::class, 'store'])->middleware('check.token')->name('horario.store');
    //Update
    Route::get('/horario/editar',[HorarioController::class,'show'])->middleware(('check.token'))->name('horario.show');
    Route::get('/horario/editar/{id}/',[HorarioController::class, 'editando'])->middleware('check.token')->name('horario.editando');
    Route::put('/horario/editar/update/{id}/',[HorarioController::class, 'update'])->middleware('check.token')->name('horario.update');
    //Delete
    Route::get('/horario/eliminar/',[HorarioController::class, 'delete'])->middleware('check.token')->name('horario.eliminar');
    Route::get('/horario/eliminar/{id}/',[HorarioController::class, 'eliminando'])->middleware('check.token')->name('horario.eliminando');
    Route::delete('/horario/eliminar/destroy/{id}/',[HorarioController::class, 'destroy'])->middleware('check.token')->name('horario.destroy');

 
//VISTAS_DE_ESTUDIANTE
    Route::get('/estudiante/cursos/vistas',[estudiantesCursosVistaController::class,'obtenerCursos'])->middleware('check.token')->name('estudiantesCursosVistas.index');
    Route::get('/estudiante/horario/vistas',[estudiantesCursosVistaController::class,'show'])->middleware('check.token')->name('estudiantesHorarioVistas.index');
    Route::get('/estudiante/cursosDetalle/vistas/{id}', [estudiantesCursosVistaController::class, 'showCursoDetalle'])->middleware('check.token')->name('estudiantescursodetalle.show');


//VISTAS_DE_DOCENTE
    Route::get('/docente/cursos/vistas',[docentesCursosVistaController::class,'obtenerCursos'])->middleware('check.token')->name('docentesCursosVistas.index');
    Route::get('/docente/cursosDetalle/vistas/{id}', [docentesCursosVistaController::class, 'obtenerCursosPorId'])->middleware('check.token')->name('docentescursodetalle.show');
    Route::post('/docente/anuncios', [docentesCursosVistaController::class, 'storeAnuncios'])->middleware('check.token')->name('docentesAnuncios.store');
    Route::put('/docente/anuncios/{id}', [docentesCursosVistaController::class, 'updateAnuncio'])->middleware('check.token')->name('docentesAnuncios.update');
    Route::delete('/docente/anuncios/{id}', [docentesCursosVistaController::class, 'destroyAnuncio'])->middleware('check.token')->name('docentesAnuncios.destroy');
    Route::post('/docente/recursos', [docentesCursosVistaController::class, 'storeRecursoAcademico'])->middleware('check.token')->name('docentesRecursos.store');
    Route::post('/docente/notas', [docentesCursosVistaController::class, 'storeNota'])->middleware('check.token')->name('docentesNotas.store');
    Route::post('/docente/guardar-calificaciones', [docentesCursosVistaController::class, 'guardarCalificaciones'])->middleware('check.token')->name('guardar.calificaciones');
    Route::post('/docente/guardar-asistencia', [docentesCursosVistaController::class, 'storeAsistencia'])->middleware('check.token')->name('guardar.asistencias');

    // web.php o api.php
  

    

    Route::post('/register', [AuthController::class, 'register'])->middleware('check.token')->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
   
});
 

// Route::post('/curso-docente', [Curso_DocenteController::class, 'store']);



Route::post('/registrar-estudiantes-cursos', [EstudianteCursoController::class, 'registrarEstudiantesEnCursos']);
