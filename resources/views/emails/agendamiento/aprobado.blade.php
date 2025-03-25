@component('mail::message')
# Agendamiento Aprobado

Estimado usuario,

Tu solicitud de agendamiento con OP: **{{ $agendamiento->op }}** ha sido aprobada.

**Detalles de la solicitud:**
- **Fecha de entrega:** {{ $agendamiento->fecha_entrega }}
- **Proveedor:** {{ $agendamiento->proveedor }}
- **Autorizador:** {{ $agendamiento->autorizador }}
- **Fecha programada de entrega:** {{ $agendamiento->fecha_programada_entrega }}
- **Comentarios:** {{ $agendamiento->texto_respuesta_correo }}

@component('mail::button', ['url' => url('/')])
Ver detalles
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
