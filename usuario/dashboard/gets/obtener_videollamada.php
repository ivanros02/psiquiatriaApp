<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON
include '../../../php/conexion.php';

$usuario_id = $_POST['usuario_id'];
$profesional_id = $_POST['profesional_id'];

// Obtener el id_usuario del profesional usando el id_presentacion
$query_profesional = "SELECT id_usuario FROM presentaciones WHERE id = ? LIMIT 1";
$stmt_profesional = $conexion->prepare($query_profesional);
$stmt_profesional->bind_param("i", $profesional_id);
$stmt_profesional->execute();
$result_profesional = $stmt_profesional->get_result();

if ($result_profesional->num_rows > 0) {
    $row_profesional = $result_profesional->fetch_assoc();
    $real_profesional_id = $row_profesional['id_usuario'];

    // Obtener el enlace de la videollamada sin verificar el estado de pago
    $query_enlace = "SELECT enlace FROM videollamadas 
                     WHERE profesional_id = ? AND paciente_id = ? 
                     ORDER BY fecha_hora DESC LIMIT 1";
    $stmt_enlace = $conexion->prepare($query_enlace);
    $stmt_enlace->bind_param("ii", $real_profesional_id, $usuario_id);
    $stmt_enlace->execute();
    $result_enlace = $stmt_enlace->get_result();

    if ($result_enlace->num_rows > 0) {
        $row_enlace = $result_enlace->fetch_assoc();
        echo json_encode(['status' => 'success', 'enlace' => $row_enlace['enlace']]);
    } else {
        echo json_encode(['status' => 'no_call', 'message' => 'No se encontró un enlace de videollamada.']);
    }

    $stmt_enlace->close();
} else {
    echo json_encode(['status' => 'no_call', 'message' => 'No se encontró un profesional asociado.']);
}

$stmt_profesional->close();
$conexion->close();

?>
