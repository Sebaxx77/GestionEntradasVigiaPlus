<x-mail::message>
    # NOTIFICACIONES AL PARQUE

    Se ha aprobado un agendamiento con los siguientes datos para la fecha: {{ $agendamiento->fecha_programada_entrega
    }}.

    - **Comentarios:** {{ $agendamiento->texto_respuesta_correo }}

    **Detalles de la solicitud:**
    - **Estatus:** {{ $agendamiento->estatus }}
    - **Numero de OP** {{ $agendamiento->op}}
    - **Proveedor:** {{ $agendamiento->proveedor }}
    - **Placa:** {{ $agendamiento->placa }}
    - **Conductor:** {{ $agendamiento->conductor }}
    - **Cédula:** {{ $agendamiento->cedula }}
    - **Bodega:** {{ $agendamiento->bodega }}

    - **Autorizador:** {{ $agendamiento->autorizador }}

    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>