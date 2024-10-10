<?php
include '../../php/conexion.php'; // Asegúrate de que la ruta sea correcta

// Verificar si se recibió el ID de la presentación y el estado de aprobación
if (isset($_POST['id']) && isset($_POST['aprobado'])) {
    $id = intval($_POST['id']);
    $aprobado = intval($_POST['aprobado']);

    // Actualizar el estado de aprobación de la presentación
    $query = "UPDATE presentaciones SET aprobado = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ii", $aprobado, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parámetros inválidos']);
}
?>
