<x-mail::message>
# NOTIFICACIONES A SEGURIDAD

Se ha aprobado un agendamiento de ingreso con los siguientes datos:

- **OP:** {{ $agendamiento->op }}
- **Proveedor:** {{ $agendamiento->proveedor }}
- **Fecha de entrega:** {{ $agendamiento->fecha_entrega }}
- **Autorizador:** {{ $agendamiento->autorizador }}
- **Fecha programada de entrega:** {{ $agendamiento->fecha_programada_entrega }}

**Campo de aprobación:** (Aquí puedes resaltar el campo que sirva como aprobación, si es un valor específico)

**Correo solicitante:** {{ $agendamiento->correo_solicitante }}

<x-mail::button :url="url('/')">
Ver más detalles
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
