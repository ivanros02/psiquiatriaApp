<?php
session_start();
include '../../../../php/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = $_SESSION['user_id'];

// Consulta para obtener los datos del usuario
$sql = "SELECT nombre, email, telefono FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user); // Retorna los datos en formato JSON
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}
?>
