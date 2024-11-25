<?php
include '../../../php/conexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Habilita los errores de MySQL

try {
    $conexion->begin_transaction(); // Inicia la transacción para garantizar consistencia de datos

    $usuario_id = $_POST['usuario_id'];
    $profesional_id = $_POST['profesional_id'];
    $turno_id = $_POST['turno_id'];

    // Obtener la fecha y hora del turno programado
    $sql = "SELECT dt.fecha, dt.hora, dt.id as disponibilidad_id FROM disponibilidad_turnos dt
            JOIN reservas_turnos rt ON dt.id = rt.turno_id
            WHERE rt.turno_id = ? AND rt.usuario_id = ? AND dt.profesional_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('iii', $turno_id, $usuario_id, $profesional_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fechaTurno = $row['fecha'];
        $horaTurno = $row['hora'];
        $disponibilidad_id = $row['disponibilidad_id'];

        $fechaHoraTurno = new DateTime("$fechaTurno $horaTurno");
        $fechaHoraActual = new DateTime();

        // Calcular la diferencia entre la fecha actual y la fecha del turno
        $diferencia = $fechaHoraActual->diff($fechaHoraTurno);
        $horasDiferencia = $diferencia->days * 24 + $diferencia->h;

        if ($horasDiferencia >= 48) {
            // Eliminar la reserva y actualizar la disponibilidad del turno
            $sqlCancel = "DELETE FROM reservas_turnos WHERE turno_id = ?";
            $stmtCancel = $conexion->prepare($sqlCancel);
            $stmtCancel->bind_param('i', $turno_id);

            if ($stmtCancel->execute()) {
                $sqlUpdateDisponibilidad = "UPDATE disponibilidad_turnos SET disponible = 1 WHERE id = ?";
                $stmtUpdateDisponibilidad = $conexion->prepare($sqlUpdateDisponibilidad);
                $stmtUpdateDisponibilidad->bind_param('i', $disponibilidad_id);

                if ($stmtUpdateDisponibilidad->execute()) {
                    $conexion->commit(); // Confirma la transacción si todo fue exitoso
                    echo json_encode(['status' => 'success']);
                } else {
                    throw new Exception("Error al actualizar la disponibilidad del turno.");
                }
            } else {
                throw new Exception("Error al eliminar la reserva.");
            }
        } else {
            echo json_encode(['status' => 'late']);
        }
    } else {
        echo json_encode(['status' => 'not_found']);
    }
} catch (Exception $e) {
    $conexion->rollback(); // Revertir la transacción en caso de error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
