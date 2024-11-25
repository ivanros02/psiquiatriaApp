<?php
include '../../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profesional_id = $_POST['profesional_id'];
    $paciente_id = $_POST['paciente_id'];

    // Eliminar la videollamada donde coincidan el profesional y el paciente
    $sql = "DELETE FROM videollamadas WHERE profesional_id = ? AND paciente_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $profesional_id, $paciente_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conexion->error]);
    }

    $stmt->close();
    $conexion->close();
}
?>
