<?php

namespace App\Http\Controllers\ParquesIndustriales;

use App\Http\Controllers\Controller;
use App\Models\LogicaNegocio\ParqueIndustrial;
use Illuminate\Http\Request;

class ParqueController extends Controller
{
    /**
     * Lista todos los parques industriales.
     */
    public function index(Request $request)
    {
        $query = ParqueIndustrial::query();

        // Búsqueda
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('direccion', 'LIKE', "%{$search}%");
            });
        }

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        $sortableColumns = ['nombre', 'direccion'];  // Definir las columnas que se pueden ordenar

        if (in_array($orderColumnName, $sortableColumns)) {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Paginación
        $total = $query->count();
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->skip($start)->take($length)->get()->map(function ($parque) {
            return [
                'id' => $parque->id,
                'nombre' => $parque->nombre,
                'direccion' => $parque->direccion,
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total, // El total de registros filtrados puede ser diferente si la búsqueda está activa
            'data' => $data,
        ]);
    }

    /**
     * Almacena un nuevo parque industrial.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'ubicacion'    => 'required|string|max:255',
            'superficie'   => 'nullable|numeric',
            'descripcion'  => 'nullable|string',
        ]);

        $parque = ParqueIndustrial::create($data);

        return response()->json([
            'message' => 'Parque industrial creado correctamente.',
            'parque'  => $parque,
        ], 201);
    }

    /**
     * Muestra los detalles de un parque industrial.
     */
    public function show(string $id)
    {
        $parque = ParqueIndustrial::findOrFail($id);

        return response()->json([
            'parque' => $parque
        ], 200);
    }

    /**
     * Actualiza un parque industrial.
     */
    public function update(Request $request, string $id)
    {
        $parque = ParqueIndustrial::findOrFail($id);

        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'ubicacion'    => 'required|string|max:255',
            'superficie'   => 'nullable|numeric',
            'descripcion'  => 'nullable|string',
        ]);

        $parque->update($data);

        return response()->json([
            'message' => 'Parque industrial actualizado correctamente.',
            'parque'  => $parque,
        ], 200);
    }

    /**
     * Elimina un parque industrial.
     */
    public function destroy(string $id)
    {
        $parque = ParqueIndustrial::findOrFail($id);
        $parque->delete();

        return response()->json([
            'message' => 'Parque industrial eliminado correctamente.'
        ], 200);
    }
}