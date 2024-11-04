<?php
// Incluir el archivo de conexión
include '../php/conexion.php';

try {
    // Recibir datos del formulario (valida antes si es necesario)
    $nombre = $_POST['nombre'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $matricula = $_POST['matricula'] ?? 0;
    $matriculaP = $_POST['matriculaP'] ?? 0;
    $especialidades_id = $_POST['especialidad'] ?? [];
    $descripcion = $_POST['descripcion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $disponibilidad = $_POST['disponibilidad'] ?? 0;
    $valor = $_POST['valor'] ?? 0;
    $valor_internacional = $_POST['valor_internacional'] ?? 0;
    $mail = $_POST['mail'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $instagram = $_POST['instagram'] ?? '';

    // Procesar imagen (con validación)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $rutaImagen = "../img/perfiles/" . $imagen_nombre;
        move_uploaded_file($imagen_temp, $rutaImagen);
    } else {
        $rutaImagen = "../img/por_defecto.png"; // Imagen por defecto
    }

    // Iniciar la transacción
    $conexion->begin_transaction();

    // Crear un usuario con el mismo mail y contraseña
    $password = password_hash($mail, PASSWORD_DEFAULT); // Hasheamos la contraseña
    $sql_usuario = "INSERT INTO usuarios (nombre, email, password, telefono) 
                    VALUES ('$nombre', '$mail', '$password', '$telefono')";

    if (!$conexion->query($sql_usuario)) {
        throw new Exception("Error al insertar en usuarios: " . $conexion->error);
    }

    // Obtener el ID del nuevo usuario
    $usuario_id = $conexion->insert_id;

    // Consulta SQL para insertar en presentaciones, incluyendo el id_usuario
    $sql = "INSERT INTO presentaciones (rutaImagen, nombre, titulo, matricula, matriculaP, descripcion, telefono, disponibilidad, valor, valor_internacional, mail, whatsapp, instagram, id_usuario) 
            VALUES ('$rutaImagen', '$nombre', '$titulo', $matricula, $matriculaP, '$descripcion', '$telefono', $disponibilidad, $valor, $valor_internacional, '$mail', '$whatsapp', '$instagram', $usuario_id)";

    if (!$conexion->query($sql)) {
        throw new Exception("Error al insertar en presentaciones: " . $conexion->error);
    }

    // Obtener el ID de la nueva presentación
    $presentacion_id = $conexion->insert_id;

    // Insertar especialidades seleccionadas
    if (is_array($especialidades_id) && !empty($especialidades_id)) {
        foreach ($especialidades_id as $especialidad_id) {
            $especialidad_id = mysqli_real_escape_string($conexion, $especialidad_id);
            $sql_especialidades = "INSERT INTO presentaciones_especialidades (presentacion_id, especialidad_id) VALUES ($presentacion_id, $especialidad_id)";

            if (!$conexion->query($sql_especialidades)) {
                throw new Exception("Error al insertar especialidad con ID $especialidad_id: " . $conexion->error);
            }
        }
    }

    /*
    // Enviar correo de confirmación
    $to = $mail;
    $subject = 'Registro exitoso en Terapia Libre';
    $message = "
        <html lang='es'>
        <head>
            <style>
                body { font-family: 'Montserrat', sans-serif; background-color: #e9ecef; padding: 20px; }
                .container { max-width: 600px; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
                h2 { color: #c1c700; }
                p { color: #495057; font-size: 16px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Estimado/a $nombre,</h2>
                <p>Nos complace informarte que tu registro como psicólogo en Terapia Libre ha sido exitoso.</p>
                <p>Gracias por unirte a nosotros y formar parte de nuestro equipo.</p>
                <p>Saludos,<br>El equipo de Terapia Libre</p>
            </div>
        </body>
        </html>";
    $headers = "From: Terapia Libre <terapialibre@terapialibre.com.ar>\r\n" .
               "Reply-To: terapialibre@terapialibre.com.ar\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";

    if (!mail($to, $subject, $message, $headers)) {
        throw new Exception("Error al enviar el correo electrónico.");
    }
   */

    // Confirmar la transacción
    $conexion->commit();

    echo '<script>alert("Datos enviados correctamente. Revisa tu correo para más detalles.");</script>';
    echo '<script>setTimeout(function() { window.location.href = "../psicologos/psicologosOnline.php"; }, 3000);</script>';

} catch (Exception $e) {
    // Si ocurre un error, revertir la transacción
    $conexion->rollback();
    echo '<div class="alert alert-danger">Ocurrió un error: ' . $e->getMessage() . '</div>';
} finally {
    // Cerrar conexión
    $conexion->close();
}
?>