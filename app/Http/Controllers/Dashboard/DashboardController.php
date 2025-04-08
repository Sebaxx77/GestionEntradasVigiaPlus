<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agendamientos\AgendamientoFormatoDescarga;
use App\Models\Agendamientos\AgendamientoFormatoVisita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('Administrador')) {
            $totalPermisos = Permission::count();
            $totalRoles = Role::count();
            $totalUsuarios = User::count();
            $ultimosUsuarios = User::latest()->take(5)->get()->map(function ($u) {
                return [
                    'name' => $u->name,
                    'email' => $u->email,
                    'created_at' => $u->created_at,
                ];
            });

            return response()->json([
                'rol' => 'Administrador',
                'message' => 'Bienvenido al panel del administrador.',
                'total_permisos' => $totalPermisos,
                'total_roles' => $totalRoles,
                'total_usuarios' => $totalUsuarios,
                'ultimos_usuarios' => $ultimosUsuarios,
            ], 200);
        }
        if ($user->hasRole('Supervisor Agendamientos')) {
            $solicitudesDescarga = AgendamientoFormatoDescarga::all();
            $solicitudesVisita = AgendamientoFormatoVisita::all();

            return response()->json([
                'rol' => 'Supervisor Agendamientos',
                'solicitudesDescarga' => $solicitudesDescarga,
                'solicitudesVisita' => $solicitudesVisita,
            ], 200);
        }

        if ($user->hasRole('Autorizador Agendamientos')) {
            $solicitudesDescarga = AgendamientoFormatoDescarga::all();
            $solicitudesVisita = AgendamientoFormatoVisita::all();

            return response()->json([
                'rol' => 'Autorizador Agendamientos',
                'solicitudesDescarga' => $solicitudesDescarga,
                'solicitudesVisita' => $solicitudesVisita,
            ], 200);
        }

        return response()->json([
            'message' => 'Acceso denegado. No tienes permisos para acceder al dashboard.'
        ], 403);
    }
}