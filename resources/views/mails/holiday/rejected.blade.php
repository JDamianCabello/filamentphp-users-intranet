<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Vacaciones Rechazada</title>
</head>
<body>
    <h1>Solicitud de Vacaciones Rechazada</h1>
    <p>Hola {{ $data['name'] }},</p>
    <p>Lamentamos informarte que tu solicitud de vacaciones para el día <strong>{{ \Carbon\Carbon::parse($data['day'])->format('d-m-Y') }}</strong> ha sido rechazada.</p>
    <p>Si tienes alguna pregunta o necesitas más información, por favor, ponte en contacto con Recursos Humanos.</p>
    <p>Gracias,</p>
    <p>El equipo de Recursos Humanos</p>
</body>
</html>
