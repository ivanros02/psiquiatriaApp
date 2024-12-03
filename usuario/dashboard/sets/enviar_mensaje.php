<?php
session_start();
include '../../../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

$usuario_id = $_SESSION['user_id'];  // ID del usuario logueado
$chat_id = $_POST['chat_id'];  // ID del chat desde la solicitud
$mensaje = $_POST['mensaje'];  // Mensaje enviado desde el formulario

if (empty($mensaje)) {
    echo "El mensaje no puede estar vacío.";
    exit();
}

// Insertar el mensaje en la base de datos
$query = "INSERT INTO mensajes (chat_id, id_remitente, mensaje) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param('iis', $chat_id, $usuario_id, $mensaje);
$stmt->execute();

// Verificar si la inserción fue exitosa
if ($stmt->affected_rows > 0) {
    echo "Mensaje enviado correctamente.";
} else {
    echo "Hubo un error al enviar el mensaje.";
}

$stmt->close();
?>
