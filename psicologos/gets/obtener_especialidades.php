<?php 
include '../../php/conexion.php';
header('Content-Type: application/json');

$query = "SELECT id, especi FROM especialidades";
$result = $conexion->query($query);

$especialidades = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $especialidades[] = $row; // Almacena cada fila en el array
    }
}

echo json_encode($especialidades); // Devuelve los resultados como JSON
$conexion->close(); // Cierra la conexión

?>