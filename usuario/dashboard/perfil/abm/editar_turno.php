<?php
include '../../../../php/conexion.php';

$id = $_POST['id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$disponible = $_POST['disponible'];

$query = "UPDATE disponibilidad_turnos SET fecha = ?, hora = ?, disponible = ? WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssii", $fecha, $hora, $disponible, $id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}
echo json_encode($response);
?>
