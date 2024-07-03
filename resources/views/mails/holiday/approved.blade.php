<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Vacaciones Aprobada</title>
</head>
<body>
    <h1>Solicitud de Vacaciones Aprobada</h1>
    <p>Hola {{ $data['name'] }},</p>
    <p>Nos complace informarte que tu solicitud de vacaciones para el día <strong>{{ \Carbon\Carbon::parse($data['day'])->format('d-m-Y') }}</strong> ha sido aprobada.</p>
    <p>Si tienes alguna pregunta, no dudes en ponerte en contacto con Recursos Humanos.</p>
    <p>Gracias,</p>
    <p>El equipo de Recursos Humanos</p>
</body>
</html>
