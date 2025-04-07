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
    public function index()
    {
        $parques = ParqueIndustrial::all();

        return response()->json([
            'parques' => $parques
        ], 200);
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