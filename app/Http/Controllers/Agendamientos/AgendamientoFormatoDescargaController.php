<?php

namespace App\Http\Controllers\Agendamientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendamientoAprobadoMail;
use App\Mail\AgendamientoRechazadoMail;
use App\Models\Agendamientos\AgendamientoFormatoDescarga;

class AgendamientoFormatoDescargaController extends Controller
{
    /**
     * Registra una nueva solicitud de agendamiento en estado "pendiente".
     */
    public function store(Request $request)
    {
        // Paso 1: Validar todos los campos, incluyendo el PDF como opcional
        $validated = $request->validate([
            'op'                    => 'required|integer',
            'fecha_entrega'         => 'required|date|after_or_equal:tomorrow',
            'proveedor'             => 'required|string|max:255',
            'codigo_articulo'       => 'required|string|max:100',
            'nombre_articulo'       => 'required|string|max:255',
            'cantidades_pedidas'    => 'required|integer',
            'placa'                 => 'required|string|max:20',
            'conductor'             => 'required|string|max:255',
            'cedula'                => 'required|string|max:20',
            'bodega'                => 'required|string|max:100',
            'correo_solicitante'    => 'required|email|max:255',
            'celular'               => 'required|string|max:20',
            'op_pdf'                => 'nullable|file|mimes:pdf|max:4048', // Opcional pero validado si se envía
        ]);
    
        // Paso 2: Procesar el PDF (si se envió) y añadirlo al array $validated
        if ($request->hasFile('op_pdf')) {
            $rutaPDF = $request->file('op_pdf')->store('agendamientos', 'public');
            $validated['op_pdf'] = $rutaPDF;
        }
    
        // Paso 3: Crear el registro con todos los datos validados
        $agendamiento = AgendamientoFormatoDescarga::create($validated + [
            'estatus'                  => 'pendiente',
            'autorizador'              => null,
            'fecha_programada_entrega' => null,
            'texto_respuesta_correo'   => null,
            'tipo'                     => 'formato_descarga',
        ]);
    
        return response()->json([
            'message' => 'Solicitud enviada correctamente. Será revisada por nuestro equipo.',
            'agendamiento' => $agendamiento
        ], 201);
    }

    /**
     * Actualiza el agendamiento a "aprobada" o "rechazada" según la acción del usuario.
     */
    public function update(Request $request, $id)
    {
        $agendamiento = AgendamientoFormatoDescarga::findOrFail($id);

        // Validamos que se envíe el campo "estatus" con uno de los valores permitidos
        $validated = $request->validate([
            'estatus' => 'required|in:aprobada,rechazada',
        ]);

        // Caso de aprobación
        if ($validated['estatus'] === 'aprobada') {
            // Validamos campos adicionales necesarios para la aprobación
            $additionalValidated = $request->validate([
                'autorizador'              => 'required|string|max:255',
                'fecha_programada_entrega' => 'required|date|after_or_equal:' . $agendamiento->fecha_entrega,
                'texto_respuesta_correo'   => 'required|string',
            ]);

            // Actualizamos el agendamiento con los datos adicionales
            $agendamiento->update($additionalValidated + $validated);

            // Enviamos el correo tanto a la dirección fija como al correo solicitante
            Mail::to('sebastian.piamba@vigiaplus.com')
                ->cc($agendamiento->correo_solicitante)
                ->send(new AgendamientoAprobadoMail($agendamiento));

            return response()->json([
                'message' => 'Solicitud aprobada y correo de confirmación enviado a Recepción Parque Industrial San Diego, Seguridad Colombia y al correo solicitante.',
                'agendamiento' => $agendamiento,
            ]);
        }

        // Caso de rechazo
        if ($validated['estatus'] === 'rechazada') {
            $additionalValidated = $request->validate([
                'autorizador'              => 'required|string|max:255',
                'texto_respuesta_correo'   => 'required|string',
            ]);
            
            // Actualizamos el agendamiento con los datos adicionales
            $agendamiento->update($additionalValidated + $validated);

            // Enviamos el correo de rechazo solo al solicitante
            Mail::to($agendamiento->correo_solicitante)
                ->send(new AgendamientoRechazadoMail($agendamiento));

            return response()->json([
                'message' => 'Solicitud rechazada y correo de respuesta enviado.',
                'agendamiento' => $agendamiento,
            ]);
        }
    }

    /**
     * Opcional: Método para retornar datos de agendamientos filtrados por estado.
     * Esto puede ser útil para que la UI muestre en diferentes secciones según el estatus.
     */
    public function otros(Request $request)
    {
        // Base query sin filtros
        $baseQuery = AgendamientoFormatoDescarga::whereIn('estatus', ['aprobada', 'rechazada'])
            ->where('tipo', 'formato_descarga');

        // Total sin filtros
        $total = $baseQuery->count();

        // Clonamos para aplicar filtros sin alterar el total
        $query = clone $baseQuery;

        // Filtro de búsqueda solo por correo_solicitante y cedula
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('correo_solicitante', 'LIKE', "%{$search}%")
                ->orWhere('cedula', 'LIKE', "%{$search}%");
            });
        }

        // Total filtrado
        $filtered = $query->count();

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumnName = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir', 'asc');

        $sortableColumns = ['fecha_entrega', 'bodega', 'op', 'correo_solicitante', 'estatus', 'created_at'];
        if (in_array($orderColumnName, $sortableColumns)) {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Paginación
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->skip($start)->take($length)->get();

        // Respuesta JSON para DataTables
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function pendientes()
    {
        $agendamientos = AgendamientoFormatoDescarga::where('estatus', 'pendiente')
            ->where('tipo', 'formato_descarga')
            ->get();

        return response()->json([
            'agendamientos' => $agendamientos
        ]);
    }
    public function todas()
    {
        // Obtener todos los registros de la tabla "agendamientos"
        $agendamientos = AgendamientoFormatoDescarga::all();

        return response()->json([
            'agendamientos' => $agendamientos
        ]);
    }

}
