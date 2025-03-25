<x-mail::message>
# Agendamiento Rechazado

Lamentamos informarte que tu solicitud de agendamiento con los siguientes detalles ha sido rechazada:

- **OP:** {{ $agendamiento->op }}
- **Fecha de entrega:** {{ $agendamiento->fecha_entrega }}
- **Proveedor:** {{ $agendamiento->proveedor }}

Si consideras que se trata de un error o necesitas mayor información, por favor adjunta esta solicitud y responde a el siguiente correo sebastian.piamba@vigiaplus.com

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
