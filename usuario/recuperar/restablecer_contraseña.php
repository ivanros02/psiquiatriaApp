<?php
// Incluir la conexión a la base de datos
include '../../php/conexion.php';  // Asegúrate de tener una conexión a la base de datos

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el token en la base de datos
    $query = "SELECT * FROM usuarios WHERE reset_token = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar si el token ha expirado
        $expiry = $user['reset_token_expiry'];
        if (strtotime($expiry) > time()) {
            // El token es válido, mostrar formulario para cambiar la contraseña
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST['password'];
                $password_hash = password_hash($password, PASSWORD_BCRYPT);  // Hashear la nueva contraseña

                // Actualizar la contraseña en la base de datos
                $query = "UPDATE usuarios SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("ss", $password_hash, $token);
                $stmt->execute();

                // Enviar el correo de notificación
                $email = $user['email'];  // Obtener el correo del usuario
                $subject = "Cambio de contraseña exitoso";
                $message = "<html>
                            <head><title>Cambio de Contraseña</title></head>
                            <body>
                                <p>Hola,</p>
                                <p>Tu contraseña ha sido cambiada exitosamente.</p>
                                <p>Si no realizaste este cambio, por favor contacta con nosotros de inmediato.</p>
                                <p>Saludos,</p>
                                <p>Terapia Libre</p>
                            </body>
                            </html>";

                // Cabeceras del correo
                $headers = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
                $headers .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                // Enviar correo
                if (mail($email, $subject, $message, $headers)) {
                    echo "Tu contraseña ha sido actualizada y hemos enviado una notificación por correo.";
                } else {
                    echo "Error al enviar la notificación por correo.";
                }
            }
        } else {
            echo "El enlace de recuperación ha expirado.";
        }
    } else {
        echo "El token no es válido.";
    }
} else {
    echo "No se proporcionó un token válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <!--icono pestana-->
    <link rel="icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
        }
        .d-flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            background-color: white;
        }
        .card h2 {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #dadea9;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-custom {
            background-color: #dadea9;
            color: #003d52;
            border: none;
            font-weight: 600;
            padding: 12px 20px;
            width: 100%;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background-color: #c4d69d;
            color: #002f3d;
        }
        .card-footer {
            text-align: center;
            margin-top: 20px;
        }
        .card-footer a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .card-footer a:hover {
            text-decoration: underline;
        }
        /* Responsive tweaks */
        @media (max-width: 576px) {
            .card {
                padding: 20px;
            }
            .btn-custom {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="d-flex-container">
    <div class="card">
        <h2>Cambiar Contraseña</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña:</label>
                <input type="password" name="password" class="form-control" required placeholder="Ingresa tu nueva contraseña">
            </div>
            <button type="submit" class="btn-custom">Cambiar Contraseña</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
