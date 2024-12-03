<?php
session_start();
include '../../../../php/conexion.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$contrasenaActual = $data['contrasenaActual'];
$nuevaContrasena = $data['nuevaContrasena'];

$sql = "SELECT password FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($contrasenaActual, $user['password'])) {
        if (strlen($nuevaContrasena) < 8) {
            echo json_encode(['error' => 'La nueva contraseña debe tener al menos 8 caracteres']);
            exit;
        }

        $nuevaContrasenaHasheada = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('si', $nuevaContrasenaHasheada, $id_usuario);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
            echo json_encode(['error' => 'Error al actualizar la contraseña']);
        }
    } else {
        echo json_encode(['error' => 'La contraseña actual es incorrecta']);
    }
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

exit;
?>
