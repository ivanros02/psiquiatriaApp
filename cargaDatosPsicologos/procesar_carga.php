<?php
// Incluir el archivo de conexión
include '../php/conexion.php';

// Recibir datos del formulario (agregar validación si es necesario)
$nombre = $_POST['nombre'];
$titulo = $_POST['titulo'];
$matricula = $_POST['matricula'];
$matriculaP = $_POST['matriculaP'];
$especialidades_id = $_POST['especialidad']; // Obtener los IDs de las especialidades seleccionadas
$descripcion = $_POST['descripcion'];
$telefono = $_POST['telefono'];
$disponibilidad = $_POST['disponibilidad'];
$valor = $_POST['valor'];
$mail = $_POST['mail'];
$whatsapp = $_POST['whatsapp'];
$instagram = $_POST['instagram'];

// Procesar la imagen (agregar validación si es necesario)
$imagen_nombre = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];
$rutaImagen = "../img/" . $imagen_nombre;
move_uploaded_file($imagen_temp, $rutaImagen);

// Consulta para obtener los nombres de las especialidades (añadir validación)
$especialidades_nombres = [];
foreach ($especialidades_id as $id) {
    $id = mysqli_real_escape_string($conexion, $id);
    $query = "SELECT especi FROM especialidades WHERE id = $id";
    $result = $conexion->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $especialidades_nombres[] = $row['especi'];
    }
}

// Convertir array de nombres en una cadena separada por comas
$especialidades = implode(',', $especialidades_nombres);

// Consulta SQL para la inserción de datos (añadir validación)
$sql = "INSERT INTO presentacionesCheck (rutaImagen, nombre, titulo, matricula, matriculaP, especialidad, descripcion, telefono, disponibilidad, valor, mail, whatsapp, instagram) VALUES ('$rutaImagen', '$nombre', '$titulo', $matricula, $matriculaP, '$especialidades', '$descripcion', $telefono, $disponibilidad, $valor, '$mail', $whatsapp, '$instagram')";

if ($conexion->query($sql) === TRUE) {
    // Envío de correo electrónico
    $to = $mail; // Destinatario será el correo ingresado en el formulario
    $subject = 'Registro exitoso en Terapia Libre';
    
    // Diseño del correo electrónico
    $message = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                padding: 10px 0;
            }
            .header img {
                max-width: 150px;
            }
            .content {
                text-align: left;
                padding: 20px;
            }
            .footer {
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #888888;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="https://terapialibre.com.ar/img/Logo_transparente.png" alt="Terapia Libre">
            </div>
            <div class="content">
                <h2>Estimado/a ' . $nombre . ',</h2>
                <p>Su registro como psicólogo en Terapia Libre ha sido exitoso. Gracias por unirse a nosotros.</p>
                <p>Saludos,<br>El equipo de Terapia Libre</p>
            </div>
            <div class="footer">
                &copy; ' . date("Y") . ' Terapia Libre. Todos los derechos reservados.
            </div>
        </div>
    </body>
    </html>';

    $headers = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
    $headers .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Manejar errores de correo electrónico
    if (mail($to, $subject, $message, $headers)) {
        echo '<script>alert("Datos enviados correctamente. Se ha enviado un correo electrónico de confirmación.");</script>';
    } else {
        echo '<script>alert("Error al enviar el correo electrónico.");</script>';
    }

    // Redirigir a la página de psicólogos después de 3 segundos
    echo '<script>setTimeout(function() { window.location.href = "../psicologos/psicologosOnline.php"; }, 3000);</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}


// Cerrar conexión
$conexion->close();
?>
