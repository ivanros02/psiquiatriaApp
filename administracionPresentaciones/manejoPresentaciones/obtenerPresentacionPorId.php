<?php
require_once '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "El ID es obligatorio."]);
        exit;
    }

    $query = "SELECT * FROM presentaciones WHERE id = ?";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conexion->error]);
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(["error" => "Presentación no encontrada."]);
        exit;
    }

    $presentacion = $result->fetch_assoc();

    echo json_encode($presentacion);

    $stmt->close();
    $conexion->close();
}
?>
