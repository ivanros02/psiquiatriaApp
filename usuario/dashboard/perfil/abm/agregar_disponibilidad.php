<?php
// Incluir el archivo de conexión a la base de datos
include '../../../../php/conexion.php';

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar y sanitizar los datos enviados desde el formulario
    $profesional_id = intval($_POST['profesional_id']); // ID del profesional (por ejemplo, $usuario_id de la sesión)
    $fechas = $_POST['fechas']; // Esto será un array de fechas
    $hora = $conexion->real_escape_string($_POST['hora']);
    $disponible = 1; // Por defecto se marca como disponible

    // Validar que los campos no estén vacíos
    if (!empty($profesional_id) && !empty($fechas) && !empty($hora)) {
        // Preparar la consulta para insertar cada fecha
        foreach ($fechas as $fecha) {
            $fecha = $conexion->real_escape_string($fecha); // Sanitizar cada fecha
            $query = "INSERT INTO disponibilidad_turnos (profesional_id, fecha, hora, disponible) 
                      VALUES ('$profesional_id', '$fecha', '$hora', '$disponible')";

            // Ejecutar la consulta y verificar si fue exitosa
            if ($conexion->query($query) !== TRUE) {
                $response = [
                    'success' => false,
                    'message' => 'Error al agregar la disponibilidad para la fecha: ' . $fecha
                ];
                echo json_encode($response);
                exit;
            }
        }
        
        // Si todas las fechas se insertaron correctamente
        $response = [
            'success' => true,
            'message' => 'Disponibilidad agregada exitosamente para todas las fechas.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ];
    }

    // Enviar la respuesta en formato JSON
    echo json_encode($response);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
