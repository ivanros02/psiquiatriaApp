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

// Iniciar la transacción para asegurar que ambas inserciones (presentaciones y presentaciones_especialidades) se realicen correctamente
$conexion->begin_transaction();

try {
    // Consulta SQL para la inserción de datos en la tabla presentaciones
    $sql = "INSERT INTO presentaciones (rutaImagen, nombre, titulo, matricula, matriculaP, descripcion, telefono, disponibilidad, valor, mail, whatsapp, instagram) 
            VALUES ('$rutaImagen', '$nombre', '$titulo', $matricula, $matriculaP, '$descripcion', $telefono, $disponibilidad, $valor, '$mail', $whatsapp, '$instagram')";

    if ($conexion->query($sql) === TRUE) {
        // Obtener el último ID insertado en la tabla presentaciones
        $presentacion_id = $conexion->insert_id;

        // Insertar las especialidades seleccionadas en la tabla presentaciones_especialidades
        foreach ($especialidades_id as $especialidad_id) {
            $especialidad_id = mysqli_real_escape_string($conexion, $especialidad_id);

            $sql_especialidades = "INSERT INTO presentaciones_especialidades (presentacion_id, especialidad_id) 
                                   VALUES ($presentacion_id, $especialidad_id)";

            if (!$conexion->query($sql_especialidades)) {
                // Si hay un error al insertar una especialidad, lanzamos una excepción
                throw new Exception("Error al insertar la especialidad con ID $especialidad_id: " . $conexion->error);
            }
        }

        // Envío de correo electrónico de confirmación
        $to = $mail;
        $subject = 'Registro exitoso en Terapia Libre';
        
        // Diseño del correo electrónico
        $message = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body { font-family: "Montserrat", sans-serif; background-color: #e9ecef; padding: 20px; margin: 0; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
                h2 { color: #c1c700; font-size: 24px; }
                p { color: #495057; line-height: 1.6; font-size: 16px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Estimado/a ' . $nombre . ',</h2>
                <p>Nos complace informarte que tu registro como psicólogo en Terapia Libre ha sido exitoso.</p>
                <p>¡Gracias por unirte a nosotros y formar parte de nuestro equipo!</p>
                <p>Saludos,<br>El equipo de Terapia Libre</p>
            </div>
        </body>
        </html>';

        $headers = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n";
        $headers .= "Reply-To: terapialibre@terapialibre.com.ar\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo '<script>alert("Datos enviados correctamente. Se ha enviado un correo electrónico de confirmación.");</script>';
        } else {
            throw new Exception("Error al enviar el correo electrónico.");
        }

        // Confirmar la transacción si todo va bien
        $conexion->commit();

        // Redirigir a la página de psicólogos
        echo '<script>setTimeout(function() { window.location.href = "../psicologos/psicologosOnline.php"; }, 3000);</script>';
    } else {
        throw new Exception("Error: " . $sql . "<br>" . $conexion->error);
    }
} catch (Exception $e) {
    // Si ocurre un error, revertir la transacción
    $conexion->rollback();
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$conexion->close();
?>
