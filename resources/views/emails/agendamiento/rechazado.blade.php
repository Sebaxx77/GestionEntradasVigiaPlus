<x-mail::message>
    # Agendamiento Rechazado

    Lamentamos informarte que tu solicitud de agendamiento con OP: **{{ $agendamiento->op }}** ha sido {{
    $agendamiento->estatus }}.

    **Detalles de la solicitud:**

    - **Fecha de Agendamiento:** {{ $agendamiento->fecha_entrega }}
    - **Proveedor:** {{ $agendamiento->proveedor }}
    - **Placa:** {{ $agendamiento->placa }}
    - **Conductor:** {{ $agendamiento->conductor }}
    - **Cédula:** {{ $agendamiento->cedula }}
    - **Bodega:** {{ $agendamiento->bodega }}
    - **Correo solicitante:** {{ $agendamiento->correo_solicitante }}

    - **Comentarios:** {{ $agendamiento->texto_respuesta_correo }}

    Si consideras que se trata de un error o necesitas mayor información, por favor adjunta esta solicitud y responde a
    el siguiente correo sebastian.piamba@vigiaplus.com

    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>