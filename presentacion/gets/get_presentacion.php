<?php
include '../../php/conexion.php'; // Asegúrate de que la ruta sea correcta

// Obtener el ID del psicólogo desde la URL
$psicologoId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar que se haya pasado un ID válido
if ($psicologoId > 0) {
    // Query para obtener la presentación de un psicólogo específico con sus especialidades
    $query = "SELECT p.*, GROUP_CONCAT(e.especi SEPARATOR ', ') AS especialidades
        FROM presentaciones AS p
        LEFT JOIN presentaciones_especialidades AS pe ON p.id = pe.presentacion_id
        LEFT JOIN especialidades AS e ON pe.especialidad_id = e.id
        WHERE p.id = ?
        GROUP BY p.id
    ";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $psicologoId); // "i" indica que el parámetro es un entero
} else {
    // Si no se pasó un ID válido, devolver un error
    echo json_encode(['error' => 'ID de psicólogo no válido']);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();
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
