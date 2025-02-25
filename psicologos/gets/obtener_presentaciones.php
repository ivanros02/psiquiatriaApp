<?php 
include '../../php/conexion.php';

header('Content-Type: application/json');

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30; // Cantidad de registros por página (30 por defecto)
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0; // Offset para la paginación

$query = "SELECT p.*, e.especi, pE.especialidad_id 
          FROM presentaciones p 
          JOIN presentaciones_especialidades pE ON p.id=pE.presentacion_id 
          LEFT JOIN especialidades e ON e.id=pE.especialidad_id
          WHERE p.aprobado = 1";

// Filtrar por especialidad si se pasa un filtro
if (!empty($_GET['especialidadFilter'])) {
    $especialidad = $conexion->real_escape_string($_GET['especialidadFilter']);
    $query .= " AND pE.especialidad_id = '$especialidad'";
}

// Filtrar por disponibilidad si se pasa un filtro
if (!empty($_GET['disponibilidadFilter'])) {
    $disponibilidad = $conexion->real_escape_string($_GET['disponibilidadFilter']);
    $query .= " AND p.disponibilidad = '$disponibilidad'";
}

// Ordenar si se pasa un orden específico
if (isset($_GET['ordenar_valor']) && ($_GET['ordenar_valor'] === 'ASC' || $_GET['ordenar_valor'] === 'DESC')) {
    $ordenar_valor = $conexion->real_escape_string($_GET['ordenar_valor']);
    $query .= " ORDER BY p.valor $ordenar_valor";
} else {
    $query .= " ORDER BY p.valor ASC";
}

// Aplicar paginación
$query .= " LIMIT $limit OFFSET $offset";

$result = $conexion->query($query);

$presentaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $presentaciones[] = $row;
    }
}

// Obtener el total de registros sin paginación para saber cuántas páginas hay
$totalQuery = "SELECT COUNT(*) as total FROM presentaciones WHERE aprobado = 1";
$totalResult = $conexion->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRegistros = $totalRow['total'];

$response = [
    "presentaciones" => $presentaciones,
    "total" => $totalRegistros
];

echo json_encode($response);
?>
