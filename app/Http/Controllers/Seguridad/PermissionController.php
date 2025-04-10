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
    public function index(Request $request)
    {
        $query = Permission::query();
    
        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }
    
        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');
    
        $sortableColumns = ['name'];
    
        if (in_array($orderColumnName, $sortableColumns)) {
            $query->orderBy($orderColumnName, $orderDir);
        }
    
        // Paginación
        $total = $query->count();
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
    
        $data = $query->skip($start)->take($length)->get()->map(function ($permiso) {
            return [
                'id' => $permiso->id,
                'name' => $permiso->name,
            ];
        });
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
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