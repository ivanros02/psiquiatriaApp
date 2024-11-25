<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
include '../../php/conexion.php';

// Leer datos del cuerpo de la solicitud
$inputData = json_decode(file_get_contents("php://input"), true);

if (!isset($inputData['turno_id']) || !isset($inputData['usuario_id'])) {
    echo json_encode(['error' => 'Datos insuficientes para la reserva']);
    exit;
}

$turno_id = intval($inputData['turno_id']);
$usuario_id = intval($inputData['usuario_id']);

// Validar si turno_id y usuario_id son válidos
if ($turno_id <= 0 || $usuario_id <= 0) {
    echo json_encode(['error' => 'Datos inválidos para la reserva']);
    exit;
}

// Consultar el profesional asociado al turno
$turno_query = "SELECT p.id_presentacion AS profesional_id
                FROM disponibilidad_turnos d
                LEFT JOIN usuarios p ON p.id = d.profesional_id
                WHERE d.id = $turno_id AND d.disponible = 1";
$turno_result = mysqli_query($conexion, $turno_query);

if ($turno_result && mysqli_num_rows($turno_result) > 0) {
    $turno_row = mysqli_fetch_assoc($turno_result);
    $profesional_id = intval($turno_row['profesional_id']);

    // Verificar o insertar relación usuario-profesional
    $relacion_query = "SELECT * FROM usuario_profesional WHERE usuario_id = $usuario_id AND profesional_id = $profesional_id";
    $relacion_result = mysqli_query($conexion, $relacion_query);

    if (!$relacion_result || mysqli_num_rows($relacion_result) == 0) {
        $insert_relacion_query = "INSERT INTO usuario_profesional (usuario_id, profesional_id) VALUES ($usuario_id, $profesional_id)";
        if (!mysqli_query($conexion, $insert_relacion_query)) {
            echo json_encode(['error' => 'Error al crear relación usuario-profesional']);
            exit;
        }
    }

    // Insertar reserva y actualizar turno
    $insert_query = "INSERT INTO reservas_turnos (turno_id, usuario_id) VALUES ($turno_id, $usuario_id)";
    if (mysqli_query($conexion, $insert_query)) {
        $update_query = "UPDATE disponibilidad_turnos SET disponible = 0 WHERE id = $turno_id";
        if (mysqli_query($conexion, $update_query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al actualizar la disponibilidad del turno: ' . mysqli_error($conexion)]);
        }
    } else {
        echo json_encode(['error' => 'Error al insertar la reserva: ' . mysqli_error($conexion)]);
    }

} else {
    echo json_encode(['error' => 'El turno no está disponible o no existe']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>