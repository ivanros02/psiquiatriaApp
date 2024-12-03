<?php 
session_start();
include '../../../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo "No estás logueado.";
    exit();
}

$usuario_id = $_SESSION['user_id'];  // ID del usuario logueado
$chat_id = $_POST['chat_id'];  // ID del chat desde la solicitud

// Consulta SQL para obtener los mensajes y el nombre del destinatario
$query = "SELECT m.id, m.mensaje, m.fecha, u.nombre AS remitente_nombre, 
                 m.id_remitente, c.usuario_id_1, c.usuario_id_2
          FROM mensajes m
          LEFT JOIN chats c ON c.id = m.chat_id
          JOIN usuarios u ON u.id = m.id_remitente
          WHERE m.chat_id = ?
          ORDER BY m.fecha ASC";

$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $chat_id);
$stmt->execute();
$result = $stmt->get_result();

$mensajes_html = '';
$nombre_destinatario = '';

while ($row = $result->fetch_assoc()) {
    $mensaje = htmlspecialchars($row['mensaje']);
    $nombre_remitente = htmlspecialchars($row['remitente_nombre']);
    $fecha = date('d/m/Y H:i', strtotime($row['fecha']));
    
    // Determinar la clase CSS según el remitente
    $clase = ($row['id_remitente'] == $usuario_id) ? 'mensaje-enviado' : 'mensaje-recibido';
    
    // Obtener el nombre del destinatario si aún no se tiene
    if (empty($nombre_destinatario)) {
        $destinatario_id = ($row['usuario_id_1'] == $usuario_id) ? $row['usuario_id_2'] : $row['usuario_id_1'];
        $stmt_destinatario = $conexion->prepare("SELECT nombre FROM usuarios WHERE id = ?");
        $stmt_destinatario->bind_param('i', $destinatario_id);
        $stmt_destinatario->execute();
        $result_destinatario = $stmt_destinatario->get_result();
        if ($destinatario = $result_destinatario->fetch_assoc()) {
            $nombre_destinatario = htmlspecialchars($destinatario['nombre']);
        }
        $stmt_destinatario->close();
    }

    // Generar HTML para los mensajes
    $mensajes_html .= "
        <div class='mensaje $clase'>
            <p>$mensaje</p>
            <small>$nombre_remitente | $fecha</small>
        </div>
    ";
}

$stmt->close();

echo json_encode(['mensajes' => $mensajes_html, 'nombre_destinatario' => $nombre_destinatario]);
?>
