<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agendamientos\AgendamientoFormatoDescarga;
use App\Models\Agendamientos\AgendamientoFormatoVisita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Retorna datos del dashboard según el rol del usuario.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('Administrador')) {
            return response()->json([
                'rol' => 'Administrador',
                'message' => 'Bienvenido al panel del administrador.'
            ], 200);
        }

        if ($user->hasRole('Autorizador Agendamientos')) {
            $solicitudesDescarga = AgendamientoFormatoDescarga::all(); // Creamos una consulta para obtener todas las solicitudes de descarga
            $solicitudesVisita = AgendamientoFormatoVisita::all(); // Filtramos las solicitudes de descarga con estado 'Visita'

            return response()->json([
                'rol' => 'Autorizador',
                'solicitudesDescarga' => $solicitudesDescarga,
                'solicitudesVisita' => $solicitudesVisita,
            ], 200);
        }

        return response()->json([
            'message' => 'Acceso denegado. No tienes permisos para acceder al dashboard.'
        ], 403);
    }
}