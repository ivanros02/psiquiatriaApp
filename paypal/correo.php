<?php
// Incluir el archivo de conexión si es necesario
include '../php/conexion.php';

// Recibir datos del formulario o de la solicitud AJAX (agregar validación si es necesario)
$psychologist_id = $_POST['psychologist_id'];
$user_email = $_POST['user_email'];

// Consulta a la base de datos para obtener la información del psicólogo
$query = "SELECT nombre, telefono, instagram, mail FROM presentaciones WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $psychologist_id);
$stmt->execute();
$result = $stmt->get_result();
$psychologistInfo = $result->fetch_assoc();

if (!$psychologistInfo) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontró información del psicólogo']);
    exit;
}

// Configuración del correo para el usuario
// Generar un ID único para la videollamada
$uniqueId = uniqid('session-', true);
$videoCallLink = 'https://meet.jit.si/' . $uniqueId;

$subject_user = 'Confirmación de pago';
$message_user = ' 
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
    <style>
        body {
            font-family: \'Montserrat\', sans-serif;
            background-color: #e9ecef;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        h2 {
            color: #c1c700;
            font-size: 24px;
            margin-top: 0;
        }

        p {
            color: #495057;
            line-height: 1.6;
            font-size: 16px;
            margin: 10px 0;
        }

        .cta-button {
            background-color: #c1c700;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #c1c700;
            text-decoration: none;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .social-links a {
            color: #007bff;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>¡Gracias por utilizar nuestra plataforma de servicios de salud mental “Terapia Libre”!</h2>
        <p>Nos complace informarte que tu pago ha sido acreditado exitosamente.</p>
        <h2>Información del Profesional:</h2>
        <p><strong>Nombre:</strong> ' . $psychologistInfo['nombre'] . '</p>
        <p><i class="fas fa-phone" style="color: #a3a000;"></i><strong>Teléfono:</strong> ' .
            $psychologistInfo['telefono'] . '</p>
        <p><i class="fab fa-instagram" style="color: #a3a000;"></i><strong>Instagram:</strong> <a
                href="' . $psychologistInfo['instagram'] . '">Instagram</a></p>
        <p><strong>Correo Electrónico:</strong> ' . $psychologistInfo['mail'] . '</p>
        <p>Tu enlace para la videollamada es: <a href="' . $videoCallLink . '">' . $videoCallLink . '</a></p>
        <p>¡Gracias por ser parte de Terapia Libre!</p>
        <p>Tu opinión es muy importante para nosotros. Agradecemos tus comentarios y recomendaciones <a
                href="mailto:queremostuopinion@terapialibre.com.ar">aquí</a>.</p>
        <a href="https://www.terapialibre.com.ar" class="cta-button">Explora más en nuestro sitio web</a>
    </div>
</body>

</html>';
$headers_user = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
$headers_user .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
$headers_user .= "MIME-Version: 1.0\r\n";
$headers_user .= "Content-type: text/html; charset=UTF-8\r\n";

// Enviar correo al usuario
$mail_status_user = mail($user_email, $subject_user, $message_user, $headers_user);

// Configuración del correo para el profesional
$subject_pro = 'Notificación de nuevo cliente';
$message_pro = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <style>
        body {
            font-family: \'Montserrat\', sans-serif;
            background-color: #e9ecef;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        h2 {
            color: #c1c700;
            font-size: 24px;
            margin-top: 0;
        }

        p {
            color: #495057;
            line-height: 1.6;
            font-size: 16px;
            margin: 10px 0;
        }

        .cta-button {
            background-color: #c1c700;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #c1c700;
            text-decoration: none;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .social-links a {
            color: #007bff;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Nuevo Paciente Asignado!</h2>
        <p>Hola '. $psychologistInfo['nombre'] .',</p>
        <p>Has sido asignado como el psicólogo de un nuevo paciente en Terapia Libre.</p>
        <h2>Información del Paciente:</h2>
        <p><strong>Correo Electrónico:</strong> ' . $user_email . '</p>
        <p>Tu enlace para la videollamada es: <a href="' . $videoCallLink . '">' . $videoCallLink . '</a></p>
        <p>Por favor, revisa los detalles del paciente y prepárate para la primera sesión. Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros.</p>
        <p>¡Gracias por tu colaboración y dedicación!</p>
    </div>
</body>
</html>';
$headers_pro = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
$headers_pro .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
$headers_pro .= "MIME-Version: 1.0\r\n";
$headers_pro .= "Content-type: text/html; charset=UTF-8\r\n";

// Enviar correo al profesional
$mail_status_pro = mail($psychologistInfo['mail'], $subject_pro, $message_pro, $headers_pro);

// Comprobar si ambos correos fueron enviados correctamente
if ($mail_status_user && $mail_status_pro) {
    echo json_encode(['status' => 'success', 'message' => 'Correos electrónicos enviados correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar los correos electrónicos']);
}
?>