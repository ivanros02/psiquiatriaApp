<?php
// Incluir el archivo de conexión
require_once '../../php/conexion.php';

// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los campos enviados desde el formulario
    $id = $_POST['id'];
    $rutaImagen = isset($_POST['rutaImagen']) ? $_POST['rutaImagen'] : null;
    $nombre = $_POST['nombre'];
    $titulo = $_POST['titulo'];
    $matricula = $_POST['matricula'];
    $matriculaP = $_POST['matriculaP'];
    $descripcion = $_POST['descripcion'];
    $telefono = $_POST['telefono'];
    $disponibilidad = $_POST['disponibilidad'];
    $valor = $_POST['valor'];
    $valor_internacional = $_POST['valor_internacional'];
    $mail = $_POST['mail'];
    $whatsapp = $_POST['whatsapp'];
    $instagram = $_POST['instagram'];

    // Recuperar la imagen actual de la base de datos
    // Asumiendo que tienes una consulta para obtener la imagen actual según el ID
    $sql = "SELECT rutaImagen FROM presentaciones WHERE id = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $rutaImagen = $row['rutaImagen']; // Imagen actual

        $stmt->close();
    }

    // Procesar imagen (con validación)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $rutaImagenServidor = "../../img/perfiles/" . $imagen_nombre; // Ruta para guardar en el servidor
        move_uploaded_file($imagen_temp, $rutaImagenServidor);

        // La ruta que se guardará en la base de datos
        $rutaImagen = "../img/perfiles/" . $imagen_nombre;
    }

    // Si no se sube una nueva imagen, se mantiene la imagen actual
    if (!$rutaImagen) {
        $rutaImagen = "../img/por_defecto.png"; // Imagen por defecto si no se sube una nueva y no hay imagen previa
    }




    // Verificar que el ID no esté vacío
    if (!empty($id)) {
        // Preparar la consulta para actualizar la presentación
        $sql = "UPDATE presentaciones SET 
                rutaImagen = ?, 
                nombre = ?, 
                titulo = ?, 
                matricula = ?, 
                matriculaP = ?, 
                descripcion = ?, 
                telefono = ?, 
                disponibilidad = ?, 
                valor = ?,
                valor_internacional = ?, 
                mail = ?, 
                whatsapp = ?, 
                instagram = ?
                WHERE id = ?";

        // Preparar la declaración
        if ($stmt = $conexion->prepare($sql)) {
            // Enlazar los parámetros (s = string, i = integer)
            $stmt->bind_param('sssssssssssssi', $rutaImagen, $nombre, $titulo, $matricula, $matriculaP, $descripcion, $telefono, $disponibilidad, $valor,$valor_internacional, $mail, $whatsapp, $instagram, $id);

            // Ejecutar la declaración
            if ($stmt->execute()) {
                // Enviar una respuesta en formato JSON de éxito
                echo json_encode(['status' => 'success']);
            } else {
                // Enviar una respuesta en formato JSON de error
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la presentación']);
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Enviar una respuesta en formato JSON de error
            echo json_encode(['status' => 'error', 'message' => 'No se pudo preparar la declaración']);
        }
    } else {
        // Enviar una respuesta en formato JSON de error si el ID está vacío
        echo json_encode(['status' => 'error', 'message' => 'ID no válido']);
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se accede mediante POST, devolver un error
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>