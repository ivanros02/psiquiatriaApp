<?php
include '../../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profesional_id = $_POST['profesional_id'];
    $paciente_id = $_POST['paciente_id'];
    $fecha_hora = $_POST['fecha_hora'];
    $enlace = $_POST['enlace'];

    // Verificar si ya existe una videollamada entre este profesional y paciente
    $sql = "SELECT * FROM videollamadas WHERE profesional_id = ? AND paciente_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $profesional_id, $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si existe una videollamada, retornar un mensaje de error
        echo json_encode(['status' => 'error', 'message' => 'Ya existe una videollamada para este profesional y paciente.']);
    } else {
        // Preparar la consulta para insertar si no existe
        $sql_insert = "INSERT INTO videollamadas (profesional_id, paciente_id, fecha_hora, enlace) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("iiss", $profesional_id, $paciente_id, $fecha_hora, $enlace);

        if ($stmt_insert->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $conexion->error]);
        }
        $stmt_insert->close();
    }

    $stmt->close();
    $conexion->close();
}
?>
