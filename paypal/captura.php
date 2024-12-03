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
    $psychologist_reference_id = $datos['detalles']['purchase_units'][0]['reference_id'];
    $payment_id = $datos['detalles']['id'];

    // Comprobar que el ID de referencia no sea nulo
    if ($psychologist_reference_id === null) {
        echo json_encode(['status' => 'error', 'message' => 'Psychologist reference ID is missing']);
        exit;
    }

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Obtener el `id_usuario` de la tabla `presentaciones` usando el `psychologist_reference_id`
        $query = "SELECT id_usuario FROM presentaciones WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $psychologist_reference_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $psychologist_id);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Verificar si se encontró un `id_usuario`
            if ($psychologist_id !== null) {
                // Insertar los datos de pago en la tabla `datos_usuario`
                $insertQuery = "INSERT INTO datos_usuario (user, psychologist_id, payment_id, pago_nacional) VALUES (?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($conexion, $insertQuery);

                if ($insertStmt) {
                    $pago_nacional = 0; // False para PayPal
                    mysqli_stmt_bind_param($insertStmt, 'iisi', $userId, $psychologist_id, $payment_id, $pago_nacional);
                    mysqli_stmt_execute($insertStmt);

                    if (mysqli_stmt_affected_rows($insertStmt) > 0) {
                        // Confirmar transacción y responder con éxito
                        mysqli_commit($conexion);
                        echo json_encode(['status' => 'success', 'message' => 'Datos guardados correctamente']);
                    } else {
                        mysqli_rollback($conexion);
                        echo json_encode(['status' => 'error', 'message' => 'Error al guardar los datos de pago en la tabla datos_usuario.']);
                    }
                    mysqli_stmt_close($insertStmt);
                } else {
                    mysqli_rollback($conexion);
                    echo json_encode(['status' => 'error', 'message' => 'Error en la consulta de inserción en datos_usuario.']);
                }
            } else {
                // Si no se encontró el `id_usuario` correspondiente
                mysqli_rollback($conexion);
                echo json_encode(['status' => 'error', 'message' => 'No se encontró el usuario en la tabla presentaciones.']);
            }
        } else {
            mysqli_rollback($conexion);
            echo json_encode(['status' => 'error', 'message' => 'Error en la consulta de búsqueda de usuario en presentaciones.']);
        }
    } catch (Exception $e) {
        // En caso de error, revertir transacción
        mysqli_rollback($conexion);
        echo json_encode(['status' => 'error', 'message' => 'Error en la transacción: ' . $e->getMessage()]);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos no válidos']);
}
?>