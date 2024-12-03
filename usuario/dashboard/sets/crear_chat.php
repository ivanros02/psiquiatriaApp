<?php
session_start();
include '../../../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

$usuario_id = $_SESSION['user_id'];  // ID del usuario logueado
$destinatario_id = $_POST['id_destinatario'];  // ID del destinatario

// Verificar si ya existe un chat entre el usuario y el destinatario
$query = "SELECT id FROM chats 
          WHERE (usuario_id_1 = ? AND usuario_id_2 = ?) 
          OR (usuario_id_1 = ? AND usuario_id_2 = ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param('iiii', $usuario_id, $destinatario_id, $destinatario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si el chat ya existe, obtener el ID del chat
    $row = $result->fetch_assoc();
    $chat_id = $row['id'];
} else {
    // Si el chat no existe, crear uno nuevo
    $query = "INSERT INTO chats (usuario_id_1, usuario_id_2) VALUES (?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ii', $usuario_id, $destinatario_id);
    $stmt->execute();
    $chat_id = $stmt->insert_id;  // Obtener el ID del nuevo chat
}

$stmt->close();
echo $chat_id;  // Devolver el ID del chat
?>
