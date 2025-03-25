<x-mail::message>
# Agendamiento Aprobado

Tu solicitud de agendamiento con OP: **{{ $agendamiento->op }}** ha sido aprobada.

**Detalles de la solicitud:**
- **Fecha de entrega:** {{ $agendamiento->fecha_entrega }}
- **Proveedor:** {{ $agendamiento->proveedor }}
- **Autorizador:** {{ $agendamiento->autorizador }}
- **Fecha programada de entrega:** {{ $agendamiento->fecha_programada_entrega }}
- **Comentarios:** {{ $agendamiento->texto_respuesta_correo }}

<x-mail::button :url="url('/')">
Ver detalles
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
