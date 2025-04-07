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
    public function index()
    {
        $operaciones = Operacion::all();

        return response()->json([
            'operaciones' => $operaciones
        ], 200);
    }

    /**
     * Almacena una nueva operación.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'bodega' => 'required|string|max:255',
        ]);

        $operacion = Operacion::create($data);

        return response()->json([
            'message'    => 'Operación creada correctamente.',
            'operacion'  => $operacion,
        ], 201);
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