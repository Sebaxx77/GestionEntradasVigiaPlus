<?php

namespace App\Http\Controllers\Perfil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class PerfilController extends Controller
{
    /**
     * Mostrar perfil del usuario autenticado.
     */
    public function showProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ], 200);
    }

    /**
     * Actualizar nombre y correo del perfil.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Perfil actualizado.']);
    }

    /**
     * Activar o desactivar 2FA.
     */
    public function toggleTwoFactor(Request $request)
    {
        $user = $request->user();

        if ($user->two_factor_secret) {
            $user->forceFill([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
            ])->save();

            return response()->json(['success' => true, 'message' => '2FA desactivado.']);
        } else {
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();

            $user->forceFill([
                'two_factor_secret' => encrypt($secret),
                'two_factor_recovery_codes' => encrypt(json_encode(
                    collect(range(1, 8))->map(fn () => Str::random(10))->all()
                )),
            ])->save();

            return response()->json([
                'success' => true,
                'message' => '2FA habilitado.',
                'secret' => $secret,
            ]);
        }
    }
}