<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Vacaciones</title>
</head>
<body>
    <h1>Solicitud de Vacaciones Pendiente</h1>
    <p>Hola,</p>
    <p>El empleado <strong>{{ $data['employee_name'] }}</strong> ({{ $data['employee_email'] }}) ha solicitado el siguiente día de vacaciones:</p>
    <ul>
        <li><strong>Fecha Solicitada:</strong> {{ \Carbon\Carbon::parse($data['days'])->format('d-m-Y') }}</li>
    </ul>
    <p><strong>Detalles del Calendario:</strong></p>
    <ul>
        <li><strong>ID del Calendario:</strong> {{ $data['calendar_data']->id }}</li>
        <li><strong>Nombre del Calendario:</strong> {{ $data['calendar_data']->name }}</li>
    </ul>
    <p>Por favor, revisa y aprueba o rechaza la solicitud en el sistema.</p>
    <p>Gracias,</p>
    <p>El equipo de Recursos Humanos</p>
</body>
</html>
