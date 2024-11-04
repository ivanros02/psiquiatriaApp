<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
include '../../php/conexion.php';

// Verificar que se enviaron los datos necesarios
if (isset($_POST['turno_id']) && isset($_POST['usuario_id'])) {
    $turno_id = intval($_POST['turno_id']);
    $usuario_id = intval($_POST['usuario_id']);

    // Insertar la reserva en la tabla reservas_turnos
    $insert_query = "INSERT INTO reservas_turnos (turno_id, usuario_id) VALUES ($turno_id, $usuario_id)";
    $insert_result = mysqli_query($conexion, $insert_query);

    if ($insert_result) {
        // Actualizar la disponibilidad del turno a no disponible
        $update_query = "UPDATE disponibilidad_turnos SET disponible = 0 WHERE id = $turno_id";
        $update_result = mysqli_query($conexion, $update_query);

        if ($insert_result && $update_result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error en la base de datos al procesar la reserva']);
        }
    } else {
        echo json_encode(['error' => 'Datos insuficientes para la reserva']);
    }
} else {
    echo json_encode(['error' => 'Datos insuficientes para la reserva']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>