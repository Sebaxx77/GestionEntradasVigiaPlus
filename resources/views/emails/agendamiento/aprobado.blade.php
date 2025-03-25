<x-mail::message>
    # Agendamiento Aprobado

    Tu solicitud de agendamiento con OP: **{{ $agendamiento->op }}** ha sido {{ $agendamiento->estatus }} para el dia:
    {{ $agendamiento->fecha_programada_entrega }}.

    - **Comentarios:** {{ $agendamiento->texto_respuesta_correo }}

    **Detalles de la solicitud:**
    - **Proveedor:** {{ $agendamiento->proveedor }}
    - **Placa:** {{ $agendamiento->placa }}
    - **Conductor:** {{ $agendamiento->conductor }}
    - **Cédula:** {{ $agendamiento->cedula }}
    - **Bodega:** {{ $agendamiento->bodega }}


    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>