<?php
include '../../../../php/conexion.php';

$id = $_GET['id'];
$query = "SELECT * FROM disponibilidad_turnos WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}
?>
