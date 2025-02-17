<?php
header('Content-Type: application/json');
include '../../../php/conexion.php';

// Verificar que el ID de la videollamada está presente
if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID de videollamada faltante']);
    exit;
}

$id_videollamada = intval($_POST['id']); // Asegura que sea un número entero

// Prepara la consulta SQL para eliminar
$query_delete = "DELETE FROM videollamadas WHERE id = ?";
$stmt = $conexion->prepare($query_delete);
$stmt->bind_param("i", $id_videollamada);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Videollamada eliminada']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la videollamada']);
}

$stmt->close();
$conexion->close();
?>
