<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validación básica del correo electrónico
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Conectar a la base de datos
        include '../../php/conexion.php'; // Conexión a la base de datos

        // Verificar si el correo electrónico existe en la base de datos
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Usuario encontrado, generar token único
            $user = $result->fetch_assoc();
            $token = bin2hex(random_bytes(50));  // Genera un token único

            // Guardar el token en la base de datos (expira en 1 hora)
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
            $query = "UPDATE usuarios SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("sss", $token, $expiry, $email);
            $stmt->execute();

            // Enviar correo electrónico con el token de recuperación
            $to = $email;
            $subject = "Recuperación de Contraseña";
            $message = "
            <html>
            <head>
            <title>Recuperación de Contraseña</title>
            </head>
            <body>
            <p>Hola,</p>
            <p>Recibimos una solicitud para restablecer tu contraseña en Terapia Libre. Si no realizaste esta solicitud, puedes ignorar este mensaje.</p>
            <p>Para restablecer tu contraseña, haz clic en el siguiente enlace:</p>
            <p><a href='https://terapialibre.com.ar/usuario/recuperar/restablecer_contraseña.php?token=$token'>Restablecer mi contraseña</a></p>
            <p>Este enlace expirará en una hora.</p>
            <p>Si tienes algún problema, contáctanos a terapialibre@terapialibre.com.ar.</p>
            </body>
            </html>
            ";

            // Encabezados del correo
            $headers = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
            $headers .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "Se ha enviado un enlace de recuperación a tu correo.";
            } else {
                echo "Hubo un error al enviar el correo. Intenta de nuevo.";
            }
        } else {
            echo "El correo electrónico no está registrado.";
        }
    } else {
        echo "El correo electrónico no es válido.";
    }
}
?>
