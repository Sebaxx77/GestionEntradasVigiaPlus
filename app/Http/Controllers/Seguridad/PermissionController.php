<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Listar todos los permisos.
     */
    public function index()
    {
        $permissions = Permission::all();

        return response()->json([
            'permissions' => $permissions,
        ], 200);
    }

    /**
     * Crear un nuevo permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        $permission = Permission::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Permiso creado correctamente.',
            'permission' => $permission,
        ], 201);
    }

    /**
     * Mostrar un permiso específico.
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json([
            'permission' => $permission,
        ], 200);
    }

    /**
     * Actualizar un permiso.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->name = $request->name;
        $permission->save();

        return response()->json([
            'message' => 'Permiso actualizado correctamente.',
            'permission' => $permission,
        ], 200);
    }

    /**
     * Eliminar un permiso.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'message' => 'Permiso eliminado correctamente.'
        ], 200);
    }
}