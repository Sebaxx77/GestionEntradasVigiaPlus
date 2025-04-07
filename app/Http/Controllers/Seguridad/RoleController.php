<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        //Función para mostrar la lista de Roles
        $roles = Role::all();
        return response()->json([
            'roles' => $roles,
        ], 200);
    }

    public function store(Request $request)
    {
        //Función para almacenar un nuevo Rol
        $request->validate([
            "name" => 'required|unique:roles,name'
        ]);

        $role = Role::create(['name' => $request->name]);

        //Si se han seleccionado permisos, se asginaran
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'message' => 'Rol creado exitosamente.',
            'role' => $role,
        ], 201);
    }

        public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'role' => $role,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //Función para actualizar el Rol y sus permisos
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return response()->json([
                'message' => 'Rol actualizado correctamente.',
                'role'    => $role,
            ], 200);
    }

    public function destroy($id)
    {
        //Función para eliminar un Rol
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Rol eliminado correctamente.'
        ], 200);
    }
}
