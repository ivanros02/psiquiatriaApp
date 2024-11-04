<?php
include '../../../php/conexion.php';

$usuario_id = $_POST['usuario_id'];

// Obtener la última video llamada relacionada con el usuario
$query = "SELECT v.enlace FROM videollamadas v 
          INNER JOIN usuarios u ON v.paciente_id = u.id 
          WHERE u.id = ? 
          ORDER BY v.fecha_hora DESC LIMIT 1";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'enlace' => $row['enlace']]);
} else {
    echo json_encode(['status' => 'no_call']);
}

$stmt->close();
$conexion->close();
?>
