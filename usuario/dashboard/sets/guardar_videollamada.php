<?php
include '../../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profesional_id = $_POST['profesional_id'];
    $paciente_id = $_POST['paciente_id'];
    $fecha_hora = $_POST['fecha_hora'];
    $enlace = $_POST['enlace'];

    // Preparar la consulta
    $sql = "INSERT INTO videollamadas (profesional_id, paciente_id, fecha_hora, enlace) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiss", $profesional_id, $paciente_id, $fecha_hora, $enlace);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conexion->error]);
    }

    $stmt->close();
    $conexion->close();
}
?>
