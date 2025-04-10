<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();

        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        $sortableColumns = ['name', 'guard_name']; // Agrega más si es necesario

        if (in_array($orderColumnName, $sortableColumns)) {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Paginación
        $total = $query->count();
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
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
