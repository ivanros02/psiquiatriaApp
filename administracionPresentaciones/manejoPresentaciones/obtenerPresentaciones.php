<?php
include '../../php/conexion.php'; // Asegúrate de que la ruta sea correcta

// Query para obtener todas las presentaciones con sus especialidades
$query = "SELECT p.*, GROUP_CONCAT(e.especi SEPARATOR ', ') AS especialidades
          FROM presentaciones AS p
          LEFT JOIN presentaciones_especialidades AS pe ON p.id = pe.presentacion_id
          LEFT JOIN especialidades AS e ON pe.especialidad_id = e.id
          GROUP BY p.id";

// Ejecutar la consulta
$result = $conexion->query($query);

// Preparar un array para almacenar las presentaciones
$presentaciones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $presentaciones[] = $row;
    }
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($presentaciones);
?>
