<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No se ha iniciado sesión.']);
    exit();
}

$usuario_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$usuario_id) {
    echo json_encode(['success' => false, 'message' => 'No se encontró el ID de usuario.']);
    exit();
}


include '../../../../php/conexion.php';

$usuario_id = $_SESSION['user_id'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

$query = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("sssi", $nombre, $email, $telefono, $usuario_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos.']);
}


$stmt->close();
$conexion->close();
?>
