<?php
header('Content-Type: application/json');
ob_clean();
flush();

// Incluir el archivo de conexión
include '../php/conexion.php';

// Obtener el contenido JSON enviado por PayPal
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (isset($datos['detalles'])) {
    // Extraer los datos necesarios del JSON
    $user_email = $datos['detalles']['payer']['email_address'];
    $psychologist_id = $datos['detalles']['purchase_units'][0]['reference_id'];
    $payment_id = $datos['detalles']['id'];

    if ($psychologist_id === null) {
        echo json_encode(['status' => 'error', 'message' => 'Psychologist ID is missing']);
        exit;
    }

    // Insertar los datos en la base de datos
    $query = "INSERT INTO datos_usuario (user_email, psychologist_id, payment_id) VALUES (?,?,?)";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sis', $user_email, $psychologist_id, $payment_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Generar una respuesta JSON de éxito
            echo json_encode(['status' => 'success', 'message' => 'Datos guardados correctamente']);
        } else {
            // Generar una respuesta JSON de error
            echo json_encode(['status' => 'error', 'message' => 'Error al guardar los datos']);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Generar una respuesta JSON de error
        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta']);
    }
} else {
    // Generar una respuesta JSON de error
    echo json_encode(['status' => 'error', 'message' => 'Datos no válidos']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
