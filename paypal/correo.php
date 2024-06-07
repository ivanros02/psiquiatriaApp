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
$subject_user = 'Confirmación de pago';
$message_user = ' 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        .cta-button {
            background-color: #c1c700;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Gracias por utilizar nuestra plataforma de servicios de salud mental “Terapia Libre”!</h2>
        <p>Tu pago ha sido acreditado.</p>
        <h2>Información del Profesional:</h2>
        <p><strong>Nombre:</strong> ' . $psychologistInfo['nombre'] . '</p>
        <p><strong>Teléfono:</strong> ' . $psychologistInfo['telefono'] . '</p>
        <p><strong>Instagram:</strong> <a href="' . $psychologistInfo['instagram'] . '" style="color: #333;"><i class="fab fa-instagram"></i> Instagram</a></p>
        <p><strong>Mail:</strong> ' . $psychologistInfo['mail'] . '</p>
        <p>¡Gracias por ser parte de Terapia Libre!</p>
        <p>Tu opinión nos importa. Agradecemos tus comentarios y recomendaciones <a href="mailto:queremostuopinion@terapialibre.com.ar">aquí</a>.</p>
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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        .cta-button {
            background-color: #c1c700;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Has recibido un nuevo cliente en Terapia Libre!</h2>
        <p>Información del cliente:</p>
        <p><strong>Email:</strong> ' . $user_email . '</p>
        <p>Por favor, ponte en contacto con el cliente a la brevedad.</p>
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