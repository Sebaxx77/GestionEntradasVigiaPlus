<?php

namespace App\Http\Controllers\CorreosNotificables;

use App\Http\Controllers\Controller;
use App\Models\LogicaNegocio\CorreoNotificable;
use Illuminate\Http\Request;


class CorreoNotificableController extends Controller
{
    /**
     * Lista todos los parques industriales.
     */
    public function index(Request $request)
    {
        $query = CorreoNotificable::query();

        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('correo', 'LIKE', "%{$search}%");
            });
        }

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        $sortableColumns = ['nombre', 'correo'];  // Definir las columnas que se pueden ordenar

        if (in_array($orderColumnName, $sortableColumns)) {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Paginación
        $total = CorreoNotificable::count(); // Total sin filtros
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        // Obtener datos filtrados
        $filteredData = $query->skip($start)->take($length)->get();
        $filteredTotal = $filteredData->count(); // Número de registros después del filtro

        // Preparar la respuesta
        $data = $filteredData->map(function ($correoNotificable) {
            return [
                'id' => $correoNotificable->id,
                'nombre' => $correoNotificable->nombre,
                'correo' => $correoNotificable->correo,
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,  // Total de registros sin filtro
            'recordsFiltered' => $filteredTotal,  // Total de registros después de filtro
            'data' => $data,
        ]);
    }
}