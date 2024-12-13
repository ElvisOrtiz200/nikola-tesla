<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaLog;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        // Validar los datos del formulario
        $validator = FacadesValidator::make($request->all(), [
            'usu_login' => 'required|unique:auth_usuario,usu_login', // 'usu_login' debe ser único
            'password' => 'required|min:8', // La contraseña es obligatoria y debe tener al menos 8 caracteres
            'correo' => 'required|email|unique:auth_usuario,correo', // 'correo' debe ser único y debe ser un correo válido
            'idrol' => 'required',
        ]);

        // Si la validación falla, devolver los errores
        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->route('usuario.crear')
                ->withCookie(cookie('error', $errorMessages, 1, '/', null, false, false));
        }

        // Crear el nuevo usuario
        $user = new Usuario();
        $user->per_id = $request->per_id;
        $user->usu_login = $request->usu_login;
        $user->alu_dni = $request->alu_dni;
        $user->password = Hash::make($request->password); // Usando Hash::make para hashear la contraseña
        $user->usu_estado = 'A';
        $user->correo = $request->correo;
        $user->idrol = $request->idrol;
        $user->save();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'C';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Usuario';
            $auditoria->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('usuario.crear')
            ->withCookie(cookie('success', 'Usuario registrado con éxito.', 1, '/', null, false, false));

    } catch (\Exception $e) {
        // Manejar la excepción y enviar mensaje en cookie
        return redirect()->route('usuario.crear')
            ->withCookie(cookie('error', 'Error al registrar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
    }
}

    //Function que se ejecuta con método POST
    public function login(Request $request)
{
    $credentials = $request->only(['usu_login', 'password']); 

    $usuario = \App\Models\Usuario::where('usu_login', $credentials['usu_login'])->first();

    if (!$usuario) {
        Log::warning('Usuario no encontrado', ['usu_login' => $credentials['usu_login']]);
        return redirect()->route('dashboard')
                    ->withCookie(cookie('error', 'Usuario no encontrado.', 1, '/', null, false, false));
       
    }

    if (!Hash::check($credentials['password'], $usuario->password)) { 
        Log::warning('Contraseña incorrecta para el usuario', ['usu_login' => $credentials['usu_login']]);
        return redirect()->route('dashboard')
                    ->withCookie(cookie('error', 'Contraseña incorrecta.', 1, '/', null, false, false));
    }

    $token = auth('api')->attempt($credentials); 
    if (!$token) {
        Log::error('No se pudo generar el token', [
            'credentials' => $credentials,
            'usuario' => $usuario,
        ]);
        return redirect()->back()->withErrors(['general' => 'Error interno. Intenta nuevamente.']);
    }

    $cookie = cookie('token', $token, 60); 
    $cookieName = cookie('user_name', $usuario->usu_login, 60);
    $cookieRole = cookie('user_role', $usuario->idrol, 60);

    return redirect()->route('dashboard')->withCookies([$cookie, $cookieName, $cookieRole]);
}


    //Function POST para obtener quien es el usuario dado el token activo
    public function me(Request $request)
    {
        $token = $request->cookie('token');
              
        try {
            // Establecer el token que será usado para autenticación
            JWTAuth::setToken($token);

            // Obtener el usuario autenticado
            $user = JWTAuth::authenticate();
             return redirect()->route('meC', ['user' => $user]);
            // return response()->json(['usu_login' => $user->usu_login]);
            // return view('usuario', ['user' => $user]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token ha expirado'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token no encontrado'], 401);
        }

    }
    public function logout()
    {
        auth('api')->logout();
        $forgetToken = cookie()->forget('token');
        $forgetName = cookie()->forget('user_name');
        $forgetRole = cookie()->forget('user_role');
    
        // Redirigir eliminando todas las cookies
        return redirect()->route('login')->withCookies([$forgetToken, $forgetName, $forgetRole]);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 1
        ]);
    }
 
    public function update(Request $request, $id) {
        try {
            $request->validate([
     
          
                'usu_login' => ['required', 'unique:auth_usuario,usu_login,'.$id.',usu_id'],
                'password' => 'required',
                'correo' => ['required', 'unique:auth_usuario,correo,'.$id.',usu_id'],
                'idrol' => 'required',
            ]);
        
          
            $user = Usuario::findOrFail($id);
            $inputPassword = request()->password;
            // Asignar los nuevos valores
            $user->per_id = $request->per_id;
            $user->usu_login = $request->usu_login;
            
            if ($request->filled('password')) {
                // Verificar si la contraseña tiene 60 caracteres
                if (strlen($request->password) !== 60) {
                    $user->password = Hash::make($request->password); // Hashear la nueva contraseña
                } else {
                    // Si la contraseña ya tiene 60 caracteres, no se hace nada
                    $user->password = $request->password; // Asignar la contraseña sin hashear
                }
            }
            
            $user->usu_estado = 'A';
            $user->correo = $request->correo;
            $user->save();

            $auditoria = new AuditoriaLog();
            $auditoria->usuario = $request->cookie('user_name');
            $auditoria->operacion = 'U';
            $auditoria->fecha = Carbon::now('America/Lima'); // Fecha y hora actual de Lima
            $auditoria->entidad = 'Usuario';
            $auditoria->save();
        
            // Redirigir con mensaje de éxito
            return redirect()->route('usuario.show') // Cambia a la ruta que desees
            ->withCookie(cookie('success', 'Usuario actualizado con éxito.', 1, '/', null, false, false));
        } catch (\Exception $e) {
            return redirect()->route('usuario.show', ['id' => $id])
            ->withCookie(cookie('error', 'Error al actualizar. Operación cancelada: ' . $e->getMessage(), 1, '/', null, false, false));
        }

      
    }
    

}
