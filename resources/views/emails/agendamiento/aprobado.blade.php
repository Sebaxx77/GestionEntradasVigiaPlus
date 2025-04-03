<x-mail::message>
    <h1 style="font-size: 28px; color: #1F2937; text-align: center; margin-bottom: 20px; margin-top: 20px;">Agendamiento de Descarga Aprobado</h1>

    <p style="font-size: 16px; color: #333;">
        -La solicitud de agendamiento de ingreso para descarga, correspondiente a el numero de Orden de Producción(OP): <strong>{{ $agendamiento->op }}</strong>
    </p>

    <p>
        ha sido <span style="color: #10B981; font-weight: bold;">{{ $agendamiento->estatus }}</span>, para la fecha:
    </p>

    <p>
        <strong>{{ $agendamiento->fecha_programada_entrega }} (AAAA-MM-DD)</strong>
    </p>

    <x-mail::panel>
        <p style="margin: 0; font-size: 16px; color: #555;"><strong>ESPECIFICACIONES:</strong> {{ $agendamiento->texto_respuesta_correo }}</p>
    </x-mail::panel>

    <h3 style="font-size: 18px; color: #1F2937; margin-top: 20px;">Detalles de la solicitud:</h3>
    <ul style="padding-left: 20px; font-size: 16px; color: #555; list-style-type: disc;">
        <li><strong>Proveedor:</strong> {{ $agendamiento->proveedor }}</li>
        <li><strong>Placa:</strong> {{ $agendamiento->placa }}</li>
        <li><strong>Conductor:</strong> {{ $agendamiento->conductor }}</li>
        <li><strong>Cédula:</strong> {{ $agendamiento->cedula }}</li>
        <li><strong>Bodega:</strong> {{ $agendamiento->bodega }}</li>
    </ul>

    <p style="font-size: 16px; color: #333;">
        Autorizado y revisado por: <strong>{{ $agendamiento->autorizador }}</strong>.
    </p>

    <p style="margin-bottom: 20px ;margin-top: 20px; font-size: 16px; color: #333;">Atentamente,<br>
    <strong>Vigia Plus Logistics.</strong></p>
</x-mail::message>