<?php
session_start();
include '../../../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

$usuario_id = $_SESSION['user_id']; // ID del usuario logueado

// Consulta para obtener destinatarios: profesionales o usuarios de chats
$query = "SELECT DISTINCT u.id AS id_usuario, u.nombre
    FROM usuarios u
    LEFT JOIN usuario_profesional up ON (u.id = up.profesional_id OR up.usuario_id = u.id)
    WHERE  u.id != ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $usuario_id);

if (!$stmt->execute()) {
    echo "Error en la consulta: " . $stmt->error;
    exit();
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "No se encontraron destinatarios.";
    exit();
}

// Listar los destinatarios
while ($row = $result->fetch_assoc()) {
    echo "<li class='destinatario' data-id='" . $row['id_usuario'] . "'>" . htmlspecialchars($row['nombre']) . "</li>";
}

$stmt->close();
?>
