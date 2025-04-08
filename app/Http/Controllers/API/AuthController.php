<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User; // Asegúrate de importar tu modelo de Usuario
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // Si vas a enviar correos
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Inicia sesión y genera un nuevo token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        // Intentar autenticar
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Autenticación exitosa, obtenemos el usuario autenticado
        $user = $request->user();

        // Revocar tokens anteriores para asegurar que sólo exista uno activo
        $user->tokens()->delete();

        // Crear un nuevo token para la sesión actual
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ]);
    }

    /**
     * Cierra la sesión revocando el token actual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Si el usuario está autenticado, revocamos su token actual
        if ($user) {
            // Eliminar el token actual (revocar el token activo)
            $request->user()->currentAccessToken()->delete(); 

            // Responder que la sesión fue cerrada correctamente
            return response()->json(['message' => 'Sesión cerrada correctamente, token revocado.']);
        }

        return response()->json(['message' => 'No se pudo cerrar sesión, usuario no autenticado.'], 401);
    }

    /**
     * Solicita el restablecimiento de contraseña enviando un enlace por correo electrónico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Asegúrate de que el email exista en tu tabla de usuarios
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Generar un token único para restablecer la contraseña
        $token = Str::random(60);

        // Guardar el token en la tabla de usuarios (o en una tabla separada de restablecimiento de contraseñas)
        $user->remember_token = $token;
        $user->save();
        
        // Mail::to($user->email)->send(new ResetPasswordEmail($token)); 

        return response()->json(['message' => 'Se ha enviado un enlace para restablecer la contraseña a su correo electrónico.']);
    }

    /**
     * Restablece la contraseña del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)
                    ->where('remember_token', $request->token)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Token de restablecimiento de contraseña inválido.'], 400);
        }

        // Actualizar la contraseña del usuario
        $user->password = bcrypt($request->password);
        $user->remember_token = null; // Invalidar el token
        $user->save();

        return response()->json(['message' => 'Su contraseña ha sido restablecida exitosamente.']);
    }
    public function me(Request $request)
    {
        $user = $request->user()->load('roles'); // Carga la relación 'roles'

        $roleName = $user->roles->first()->name ?? null; // Obtiene el nombre del primer rol (asumiendo que tiene uno)

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $roleName,
            // ... otra información del usuario ...
        ]);
    }
}