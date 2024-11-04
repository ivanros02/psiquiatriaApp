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

    // Consultar el profesional asociado al turno
    $turno_query = "SELECT p.id_presentacion AS profesional_id
                    FROM disponibilidad_turnos d
                    LEFT JOIN usuarios p ON p.id=d.profesional_id
                    WHERE d.id = $turno_id AND d.disponible = 1";
    $turno_result = mysqli_query($conexion, $turno_query);

    if ($turno_result && mysqli_num_rows($turno_result) > 0) {
        $turno_row = mysqli_fetch_assoc($turno_result);
        $profesional_id = intval($turno_row['profesional_id']);

        // Verificar si la relación entre usuario y profesional ya existe
        $relacion_query = "SELECT * FROM usuario_profesional WHERE usuario_id = $usuario_id AND profesional_id = $profesional_id";
        $relacion_result = mysqli_query($conexion, $relacion_query);

        if (!$relacion_result || mysqli_num_rows($relacion_result) == 0) {
            // Si la relación no existe, insertarla
            $insert_relacion_query = "INSERT INTO usuario_profesional (usuario_id, profesional_id) VALUES ($usuario_id, $profesional_id)";
            mysqli_query($conexion, $insert_relacion_query);
        }

        // Insertar la reserva en la tabla reservas_turnos
        $insert_query = "INSERT INTO reservas_turnos (turno_id, usuario_id) VALUES ($turno_id, $usuario_id)";
        $insert_result = mysqli_query($conexion, $insert_query);

        if ($insert_result) {
            // Actualizar la disponibilidad del turno a no disponible
            $update_query = "UPDATE disponibilidad_turnos SET disponible = 0 WHERE id = $turno_id";
            $update_result = mysqli_query($conexion, $update_query);

            if ($update_result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error en la base de datos al actualizar la disponibilidad']);
            }
        } else {
            echo json_encode(['error' => 'Error en la base de datos al insertar la reserva']);
        }
    } else {
        echo json_encode(['error' => 'El turno no está disponible']);
    }
} else {
    echo json_encode(['error' => 'Datos insuficientes para la reserva']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
