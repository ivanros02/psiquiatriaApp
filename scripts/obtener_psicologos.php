<?php
// Incluye el archivo de conexión a la base de datos
include_once '../php/conexion.php';

// Obtén los parámetros de filtrado desde la solicitud POST
$especialidad = $_POST['especialidad'];
$disponibilidad = $_POST['disponibilidad'];

// Consulta SQL para obtener los psicólogos filtrados
$sql = "SELECT * FROM presentaciones WHERE 
        (LOWER(especialidad) LIKE LOWER('%$especialidad%') OR '$especialidad' = '') AND
        (LOWER(disponibilidad) = LOWER('$disponibilidad') OR '$disponibilidad' = '')";

$result = $conexion->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Crea un array para almacenar los resultados
    $psicologosFiltrados = array();

    // Almacena cada fila como un elemento en el array
    while ($row = $result->fetch_assoc()) {
        $psicologosFiltrados[] = $row;
    }

    // Devuelve los resultados en formato JSON
    echo json_encode($psicologosFiltrados);
} else {
    // Devuelve un JSON vacío si no hay resultados
    echo json_encode([]);
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
