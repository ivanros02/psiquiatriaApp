<?php 
include '../../php/conexion.php';

header('Content-Type: application/json');

// Inicializa la consulta base
$query = "SELECT p.*, e.especi, pE.especialidad_id 
          FROM presentaciones p 
          JOIN presentaciones_especialidades pE ON p.id=pE.presentacion_id 
          LEFT JOIN especialidades e ON e.id=pE.especialidad_id
          ";

// Agregar la condición para traer solo los registros con aprobado = 1
$conditions[] = "aprobado = 1";

// Comprueba si se han enviado parámetros de filtro
if (!empty($_GET['especialidadFilter'])) {
    $especialidad = $conexion->real_escape_string($_GET['especialidadFilter']);
    $conditions[] = "pE.especialidad_id  = '$especialidad'"; // Filtra por especialidad
}

if (!empty($_GET['disponibilidadFilter'])) {
    $disponibilidad = $conexion->real_escape_string($_GET['disponibilidadFilter']);
    $conditions[] = "p.disponibilidad = '$disponibilidad'"; // Filtra por disponibilidad
}

// Si hay condiciones, las añadimos a la consulta
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

// Comprueba si se ha enviado un parámetro para ordenar
if (isset($_GET['ordenar_valor']) && ($_GET['ordenar_valor'] === 'ASC' || $_GET['ordenar_valor'] === 'DESC')) {
    $ordenar_valor = $conexion->real_escape_string($_GET['ordenar_valor']);
    $query .= " ORDER BY p.valor $ordenar_valor"; // Ordena por valor
} else {
    // Opción por defecto si no se especifica un valor de ordenación válido
    $query .= " ORDER BY p.valor ASC"; // O puedes quitar esta línea si no deseas un orden por defecto
}




$result = $conexion->query($query);

$presentaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $presentaciones[] = $row; // Almacena cada fila en el array
    }
}

echo json_encode($presentaciones); // Devuelve los resultados como JSON
?>
