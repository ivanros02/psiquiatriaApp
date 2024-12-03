<?php
include '../../php/conexion.php'; // Asegúrate de que la ruta sea correcta

// Obtener los parámetros de paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = 30;
$offset = ($pagina - 1) * $registrosPorPagina;

// Query para obtener las presentaciones con sus especialidades
$query = "SELECT p.*, GROUP_CONCAT(e.especi SEPARATOR ', ') AS especialidades
          FROM presentaciones AS p
          LEFT JOIN presentaciones_especialidades AS pe ON p.id = pe.presentacion_id
          LEFT JOIN especialidades AS e ON pe.especialidad_id = e.id
          GROUP BY p.id
          LIMIT $registrosPorPagina OFFSET $offset";

// Ejecutar la consulta
$result = $conexion->query($query);

// Preparar un array para almacenar las presentaciones
$presentaciones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $presentaciones[] = $row;
    }
}

// Contar el total de registros
$totalQuery = "SELECT COUNT(*) as total FROM presentaciones";
$totalResult = $conexion->query($totalQuery);
$totalRegistros = $totalResult->fetch_assoc()['total'];

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode([
    'presentaciones' => $presentaciones,
    'total' => $totalRegistros,
    'pagina' => $pagina,
    'registrosPorPagina' => $registrosPorPagina
]);
?>
