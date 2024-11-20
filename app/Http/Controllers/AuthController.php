<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = FacadesValidator::make(request()->all(), [
            'usu_login' => 'required',
            'password' => 'required',
            'correo' => 'required',
            'idrol' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        //dd($request);
        $user = new Usuario;
        $user->per_id = request()->per_id;
        $user->usu_login = request()->usu_login;
        $user->alu_dni = request()->alu_dni;
        $user->password = Hash::make(request()->password); // Usando Hash::make para hashear la contraseña
        $user->usu_estado = 'A';
        $user->correo = request()->correo;
        $user->idrol = request()->idrol;
        $user->save();
    
        return redirect()->route('usuario.crear')
                ->withCookie(cookie('success', 'Usuario registrado con éxito.', 1, '/', null, false, false));
    }

    //Function que se ejecuta con método POST
    public function login(Request $request)
    {
    $credentials = request(['usu_login', 'password']); 

    $usuario = \App\Models\Usuario::where('usu_login', $credentials['usu_login'])->first();

    if (!$usuario) {
        Log::warning('Usuario no encontrado', ['usu_login' => $credentials['usu_login']]);
        return response()->json(['error' => 'Unauthorized - Usuario no encontrado'], 401);
    }

    if (!Hash::check($credentials['password'], $usuario->password)) { 
        Log::warning('Contraseña incorrecta para el usuario', ['usu_login' => $credentials['usu_login']]);
        return response()->json(['error' => 'Unauthorized - Contraseña incorrecta'], 401);
    }

    $token = auth('api')->attempt($credentials); 
    $cookie = cookie('token', $token, 60); 
    $cookieName = cookie('user_name', $usuario->usu_login, 60);
    $cookieRole = cookie('user_role', $usuario->idrol, 60);

    if (!$token) {
        Log::error('No se pudo generar el token', [
            'credentials' => $credentials,
            'usuario' => $usuario,
            'token' => $token,
        ]);
    } 
    //dd($cookie, $cookieName, $cookieRole);
    //redirigimos a la ruta GET donde se muestra el menu.
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
        // Validación de los datos
        $validator = FacadesValidator::make($request->all(), [
            'per_id' => 'required',
            'usu_login' => 'required',
            'password' => 'required',

            'correo' => 'required|email', // Asegúrate de validar que sea un correo
        ]);
    
        
    // dd("hola");
        // Encontrar el usuario por ID
        $user = Usuario::findOrFail($id); // Busca el usuario existente
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
    
        // Redirigir con mensaje de éxito
        return redirect()->route('usuario.show') // Cambia a la ruta que desees
        ->withCookie(cookie('success', 'Usuario actualizado con éxito.', 1, '/', null, false, false));
    }
    

}
