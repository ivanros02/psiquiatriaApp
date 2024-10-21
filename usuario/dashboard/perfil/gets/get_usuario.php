<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No se ha iniciado sesión.']);
    exit();
}

include '../../../../php/conexion.php';

$usuario_id = $_SESSION['user_id'];

$query = "SELECT nombre, email, telefono FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    echo json_encode($usuario);
} else {
    echo json_encode(['error' => 'Usuario no encontrado.']);
}

$stmt->close();
$conexion->close();
?>
