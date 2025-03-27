<?php

namespace App\Http\Controllers\Agendamientos;

use App\Http\Controllers\Controller;
use App\Models\Agendamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendamientoAprobadoMail;
use App\Mail\AgendamientoRechazadoMail;

class AgendamientoFormatoDescargaController extends Controller
{
    /**
     * Registra una nueva solicitud de agendamiento en estado "pendiente".
     */
    public function store(Request $request)
    {
        // Validación de los campos obligatorios para la creación inicial
        $validated = $request->validate([
            'op'                    => 'required|integer',
            'fecha_entrega'         => 'required|date|after_or_equal:tomorrow',
            'proveedor'             => 'required|string|max:255',
            'codigo_articulo'       => 'required|string|max:100',
            'nombre_articulo'       => 'required|string|max:255',
            'cantidades_pedidas'    => 'required|string|max:50',
            'placa'                 => 'required|string|max:20',
            'conductor'             => 'required|string|max:255',
            'cedula'                => 'required|string|max:20',
            'bodega'                => 'required|string|max:100',
            'correo_solicitante'    => 'required|email|max:255',
            'celular'               => 'required|string|max:20',
        ]);

        $agendamiento = Agendamiento::create($validated + [
            'estatus'                  => 'pendiente',
            'autorizador'              => null,
            'fecha_programada_entrega' => null,
            'texto_respuesta_correo'   => null,
        ]);

        // Retornamos la respuesta en formato JSON
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
        $agendamiento = Agendamiento::findOrFail($id);

        // Validamos que se envíe el campo "estatus" con uno de los valores permitidos
        $validated = $request->validate([
            'estatus' => 'required|in:aprobada,rechazada',
        ]);

        // Lógica para el caso de aprobación
        if ($validated['estatus'] === 'aprobada') {
            // Validamos campos adicionales necesarios para la aprobación
            $additionalValidated = $request->validate([
                'autorizador'              => 'required|string|max:255',
                'fecha_programada_entrega' => 'required|date',
                'texto_respuesta_correo'   => 'required|string',
            ]);

            // Actualizamos el agendamiento con los datos adicionales
            $agendamiento->update($additionalValidated + $validated);

            // Disparamos el envío de correo a las direcciones configuradas
            // Aquí asumimos que AgendamientoAprobadoMail es un Mailable que recibe el modelo
            Mail::to('sebastian.piamba@vigiaplus.com')->send((new AgendamientoAprobadoMail($agendamiento)));

            return response()->json([
                'message' => 'Solicitud aprobada y correo de confirmación enviado a Recepción Parque Industrial San Diego y Seguridad Colombia.',
                'agendamiento' => $agendamiento
            ]);
        }

        // Lógica para el caso de rechazo
        if ($validated['estatus'] === 'rechazada') {
            $agendamiento->update($validated);

            // Enviar correo al solicitante con el Mailable de rechazo
            Mail::to($agendamiento->correo_solicitante)
                ->send(new AgendamientoRechazadoMail($agendamiento));

            return response()->json([
                'message' => 'Solicitud rechazada y correo de respuesta enviado.',
                'agendamiento' => $agendamiento
            ]);
        }
    }

    /**
     * Opcional: Método para retornar datos de agendamientos filtrados por estado.
     * Esto puede ser útil para que la UI muestre en diferentes secciones según el estatus.
     */
    public function index(Request $request)
    {
        // Ejemplo: ?estatus=pendiente
        $estatus = $request->query('estatus', 'pendiente');
        $agendamientos = Agendamiento::where('estatus', $estatus)->get();

        return response()->json([
            'agendamientos' => $agendamientos
        ]);
    }
}
