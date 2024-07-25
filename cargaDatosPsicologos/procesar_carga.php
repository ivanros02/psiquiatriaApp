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
$rutaImagen = "../img/perfiles/" . $imagen_nombre;
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
        <h2>Estimado/a ' . $nombre . ',</h2>
        <p>Nos complace informarte que tu registro como psicólogo en Terapia Libre ha sido exitoso.</p>
        <p>¡Gracias por unirte a nosotros y formar parte de nuestro equipo!</p>
        <p class="signature">Saludos,<br>El equipo de Terapia Libre</p>
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
