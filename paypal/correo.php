<?php
// Incluir el archivo de conexión si es necesario
include '../php/conexion.php';

// Incluir el autoload de Composer para cargar PHPMailer
require '../vendor/autoload.php';

// Usar las clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Recibir datos del formulario o de la solicitud AJAX (agregar validación si es necesario)
$psychologist_id = $_POST['psychologist_id'];
$user_email = $_POST['user_email'];

// Consulta a la base de datos para obtener la información del psicólogo
$query = "SELECT nombre, telefono, instagram, mail FROM presentaciones WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $psychologist_id);
$stmt->execute();
$result = $stmt->get_result();
$psychologistInfo = $result->fetch_assoc();

if (!$psychologistInfo) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontró información del psicólogo']);
    exit;
}

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';  // Cambiar al servidor SMTP que estés utilizando
    $mail->SMTPAuth = true;
    $mail->Username = 'terapialibre@terapialibre.com.ar';  // Cambiar al email que estés utilizando
    $mail->Password = 'password';  // Cambiar a la contraseña del email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;  // Cambiar al puerto adecuado

    // Remitente y destinatario
    $mail->setFrom('terapialibre@terapialibre.com.ar', 'Terapia Libre');
    $mail->addAddress($user_email);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Terapia Libre: información del profesional solicitado';
    $mail->Body = '
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
        </html>
    ';

    // Enviar el correo
    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Correo electrónico enviado correctamente']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo]);
}
?>