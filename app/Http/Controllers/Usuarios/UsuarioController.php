<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LogicaNegocio\Operacion;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios junto con sus roles, permisos y operaciones.
     */
    public function index(Request $request)
    {
        $query = User::with('operacion', 'roles');

        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        // Solo ordenamos por columnas simples
        $sortableColumns = ['name', 'email'];

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

    /**
     * Almacena un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Validar datos de entrada
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|string',              // Nombre o slug del rol
            'operacion_id' => 'required|exists:operaciones,id', // Operación válida
        ]);

        // Cifrar la contraseña
        $data['password'] = bcrypt($data['password']);

        // Crear el usuario
        $usuario = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => $data['password'],
            'operacion_id' => $data['operacion_id'],
        ]);

        // Asignar el rol utilizando Spatie
        $usuario->assignRole($data['role']);

        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Muestra los datos de un usuario en particular.
     */
    public function show($id)
    {
        $usuario = User::with('operacion', 'roles')->findOrFail($id);
        $roles = Role::all();
        $operaciones = Operacion::all();

        return response()->json([
            'usuario' => $usuario,
            'roles' => $roles,
            'operaciones' => $operaciones,
        ], 200);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Validar datos de actualización
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $usuario->id,
            'operacion_id' => 'required|exists:operaciones,id',
            'role'         => 'sometimes|required|string', // Opcional, si se actualiza el rol
        ]);

        // Actualizar datos del usuario
        $usuario->update($data);

        // Si se envía un nuevo rol, sincronizarlo
        if ($request->filled('role')) {
            $usuario->syncRoles([$data['role']]);
        }

        // Opcional: Si se actualizan permisos, sincronizarlos (se espera un arreglo en 'permissions')
        if ($request->has('permissions')) {
            $usuario->syncPermissions($request->input('permissions'));
        }

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'usuario' => $usuario,
        ], 200);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.',
        ], 200);
    }
}