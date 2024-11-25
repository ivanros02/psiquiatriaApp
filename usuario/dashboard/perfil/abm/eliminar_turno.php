<?php
include '../../../../php/conexion.php';

$id = $_GET['id'];
$query = "DELETE FROM disponibilidad_turnos WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}
echo json_encode($response);
?>
