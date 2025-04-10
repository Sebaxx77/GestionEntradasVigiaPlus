<?php

namespace App\Http\Controllers\Operaciones;

use App\Http\Controllers\Controller;
use App\Models\LogicaNegocio\Operacion;
use Illuminate\Http\Request;

class OperacionController extends Controller
{
    /**
     * Lista todas las operaciones.
     */
    public function index(Request $request)
    {
        $query = Operacion::with(['parquesIndustriales', 'correosNotificables']);

        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                ->orWhereHas('parquesIndustriales', function ($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%");
                });
            });
        }

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        $sortableColumns = ['nombre']; // solo columnas base

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
     * Muestra una operación específica.
     */
    public function show($id)
    {
        $operacion = Operacion::findOrFail($id);

        return response()->json([
            'operacion' => $operacion
        ], 200);
    }

    /**
     * Actualiza una operación existente.
     */
    public function update(Request $request, $id)
    {
        $operacion = Operacion::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'bodega' => 'required|string|max:255',
        ]);

        $operacion->update($data);

        return response()->json([
            'message'    => 'Operación actualizada correctamente.',
            'operacion'  => $operacion,
        ], 200);
    }

    /**
     * Elimina una operación.
     */
    public function destroy($id)
    {
        $operacion = Operacion::findOrFail($id);
        $operacion->delete();

        return response()->json([
            'message' => 'Operación eliminada correctamente.'
        ], 200);
    }
}