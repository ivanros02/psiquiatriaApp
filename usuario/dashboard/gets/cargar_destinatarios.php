<?php
session_start();
include '../../../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

$usuario_id = $_SESSION['user_id']; // ID del usuario logueado

// Verificar si el usuario logueado tiene una presentación
$query_presentacion = "SELECT id_presentacion FROM usuarios WHERE id = ?";
$stmt_presentacion = $conexion->prepare($query_presentacion);
$stmt_presentacion->bind_param('i', $usuario_id);
$stmt_presentacion->execute();
$result_presentacion = $stmt_presentacion->get_result();

if ($result_presentacion->num_rows === 0) {
    echo "Error: Usuario no encontrado.";
    exit();
}

$row_presentacion = $result_presentacion->fetch_assoc();
$id_presentacion = $row_presentacion['id_presentacion']; // NULL si no tiene presentación

// Consulta para obtener destinatarios relacionados
$query = "
    SELECT DISTINCT u.id AS id_usuario, u.nombre
    FROM usuarios u
    INNER JOIN usuario_profesional up
        ON (
            (up.usuario_id = ? AND u.id_presentacion = up.profesional_id) -- Caso usuario logueado relacionado con profesional
            OR 
            (up.profesional_id = ? AND u.id = up.usuario_id)             -- Caso profesional logueado relacionado con usuarios
        )
    WHERE u.id != ?
";

$stmt = $conexion->prepare($query);

// Si el usuario es profesional (tiene id_presentacion), usamos ese ID en la consulta
if ($id_presentacion !== NULL) {
    $stmt->bind_param('iii', $usuario_id, $id_presentacion, $usuario_id);
} else {
    $stmt->bind_param('iii', $usuario_id, $usuario_id, $usuario_id);
}

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
