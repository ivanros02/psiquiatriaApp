<?php
// Incluir el archivo de conexión
include '../php/conexion.php';

try {
    // Recibir datos del formulario
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

    // Verificar si el correo ya está registrado
    $sql_verificar = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql_verificar);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el correo ya existe, mostrar mensaje y detener el proceso
        echo '<script>alert("El correo ya está registrado. Por favor, usa otro.");</script>';
        echo '<script>window.location.href = "../index.php";</script>';
        exit;
    }
    $stmt->close();

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
    $sql_usuario = "INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_usuario);
    $stmt->bind_param("ssss", $nombre, $mail, $password, $telefono);

    if (!$stmt->execute()) {
        throw new Exception("Error al insertar en usuarios: " . $stmt->error);
    }
    $usuario_id = $conexion->insert_id;
    $stmt->close();

    // Insertar en presentaciones
    $sql_presentacion = "INSERT INTO presentaciones (rutaImagen, nombre, titulo, matricula, matriculaP, descripcion, telefono, disponibilidad, valor, valor_internacional, mail, whatsapp, instagram, id_usuario) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_presentacion);
    $stmt->bind_param("ssssssiidssssi", $rutaImagen, $nombre, $titulo, $matricula, $matriculaP, $descripcion, $telefono, $disponibilidad, $valor, $valor_internacional, $mail, $whatsapp, $instagram, $usuario_id);

    if (!$stmt->execute()) {
        throw new Exception("Error al insertar en presentaciones: " . $stmt->error);
    }
    $presentacion_id = $conexion->insert_id;
    $stmt->close();

    // Actualizar el usuario con id_presentacion
    $sql_actualizar_usuario = "UPDATE usuarios SET id_presentacion = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql_actualizar_usuario);
    $stmt->bind_param("ii", $presentacion_id, $usuario_id);

    if (!$stmt->execute()) {
        throw new Exception("Error al actualizar el usuario con id_presentacion: " . $stmt->error);
    }
    $stmt->close();

    // Insertar especialidades seleccionadas
    if (is_array($especialidades_id) && !empty($especialidades_id)) {
        foreach ($especialidades_id as $especialidad_id) {
            $sql_especialidades = "INSERT INTO presentaciones_especialidades (presentacion_id, especialidad_id) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql_especialidades);
            $stmt->bind_param("ii", $presentacion_id, $especialidad_id);

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar especialidad con ID $especialidad_id: " . $stmt->error);
            }
            $stmt->close();
        }
    }

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

    // Confirmar la transacción
    $conexion->commit();

    echo '<script>alert("Datos enviados correctamente. Revisa tu correo para más detalles.");</script>';
    echo '<script>setTimeout(function() { window.location.href = "../psicologos/psicologosOnline.php"; }, 1000);</script>';

} catch (Exception $e) {
    // Si ocurre un error, revertir la transacción
    $conexion->rollback();
    
    // Mostrar un mensaje de error más amigable
    if (strpos($e->getMessage(), "Duplicate entry") !== false) {
        echo '<script>alert("El correo ya está registrado. Intenta con otro.");</script>';
        echo '<script>window.location.href = "../index.php";</script>';
    } else {
        echo '<div class="alert alert-danger">Ocurrió un error: ' . $e->getMessage() . '</div>';
    }
} finally {
    // Cerrar conexión
    $conexion->close();
}
?>
