<?php
header('Content-Type: application/json');
ob_clean();  // Limpia cualquier salida previa
flush();     // Asegura que no haya salida residual

// Incluir el archivo de conexión
include '../php/conexion.php';

// Obtener el contenido JSON enviado por PayPal
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

// Verificar si se envió userId y detalles
if (isset($datos['userId']) && isset($datos['detalles'])) {
    // Extraer los datos necesarios del JSON
    $userId = $datos['userId'];
    $psychologist_id = $datos['detalles']['purchase_units'][0]['reference_id'];
    $payment_id = $datos['detalles']['id'];

    if ($psychologist_id === null) {
        echo json_encode(['status' => 'error', 'message' => 'Psychologist ID is missing']);
        exit;
    }

    // Insertar los datos en la base de datos
    $query = "INSERT INTO datos_usuario (user, psychologist_id, payment_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        // Usar bind_param con tipos correctos
        mysqli_stmt_bind_param($stmt, 'sis', $userId, $psychologist_id, $payment_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Respuesta exitosa
            echo json_encode(['status' => 'success', 'message' => 'Datos guardados correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al guardar los datos']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos no válidos']);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
