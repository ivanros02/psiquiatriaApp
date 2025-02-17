<?php
header('Content-Type: application/json'); // Establece el tipo de contenido como JSON
include '../../../php/conexion.php';

if (!isset($_POST['usuario_id']) || !isset($_POST['profesional_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    exit;
}

$usuario_id = $_POST['usuario_id'];  // ID del usuario regular
$profesional_id = $_POST['profesional_id'];  // ID del profesional

try {
    // Consultar el enlace de la videollamada sin verificar el estado de pago
    $query_enlace = "SELECT enlace FROM videollamadas 
                     WHERE profesional_id = ? AND paciente_id = ? 
                     ORDER BY fecha_hora DESC LIMIT 1";
    $stmt_enlace = $conexion->prepare($query_enlace);
    $stmt_enlace->bind_param("ii", $profesional_id, $usuario_id);
    $stmt_enlace->execute();
    $result_enlace = $stmt_enlace->get_result();

    if ($result_enlace->num_rows > 0) {
        $row_enlace = $result_enlace->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'id' => $row_enlace['id'],  // Se agrega el ID de la videollamada
            'enlace' => $row_enlace['enlace']
        ]);
    } else {
        echo json_encode(['status' => 'no_call', 'message' => 'No se encontró un enlace de videollamada.']);
    }

    $stmt_enlace->close();
    $conexion->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error en el servidor.', 'details' => $e->getMessage()]);
    exit;
}
?>