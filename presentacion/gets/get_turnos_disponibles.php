<?php
include '../../php/conexion.php';

// Verificar que se envió un ID de profesional
if (isset($_GET['id'])) {
    $profesional_id = intval($_GET['id']);

    // Consulta para obtener los turnos disponibles del profesional
    $query = "SELECT d.*, u.nombre AS terapeuta
              FROM disponibilidad_turnos d 
              LEFT JOIN usuarios u ON u.id = d.profesional_id 
              WHERE u.id_presentacion = $profesional_id AND disponible = 1";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $turnos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $turnos[] = $row;
        }
        // Enviar los turnos disponibles en formato JSON
        echo json_encode($turnos);
    } else {
        echo json_encode(['error' => 'Error al obtener los turnos']);
    }
} else {
    echo json_encode(['error' => 'ID de profesional no proporcionado']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
