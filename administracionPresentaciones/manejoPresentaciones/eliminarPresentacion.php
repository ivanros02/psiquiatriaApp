<?php
// Incluir el archivo de conexión
require_once '../../php/conexion.php';

// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID enviado desde el formulario
    $id = $_POST['id'];

    // Verificar que el ID no esté vacío
    if (!empty($id)) {
        // Verificar si hay registros relacionados en la tabla usuario_profesional
        $checkSql = "SELECT COUNT(*) FROM usuario_profesional WHERE profesional_id = ?";
        if ($checkStmt = $conexion->prepare($checkSql)) {
            $checkStmt->bind_param('i', $id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            // Si hay registros relacionados, no permitir la eliminación
            if ($count > 0) {
                echo json_encode(['status' => 'error', 'message' => 'No se puede eliminar la presentación porque está relacionada con usuarios profesionales.']);
                exit; // Salir del script
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al verificar relaciones']);
            exit; // Salir del script
        }

        // Preparar la consulta para eliminar la presentación
        $sql = "DELETE FROM presentaciones WHERE id = ?";

        // Preparar la declaración
        if ($stmt = $conexion->prepare($sql)) {
            // Enlazar el parámetro (i = integer)
            $stmt->bind_param('i', $id);

            // Ejecutar la declaración
            if ($stmt->execute()) {
                // Enviar una respuesta en formato JSON de éxito
                echo json_encode(['status' => 'success']);
            } else {
                // Enviar una respuesta en formato JSON de error
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la presentación']);
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
