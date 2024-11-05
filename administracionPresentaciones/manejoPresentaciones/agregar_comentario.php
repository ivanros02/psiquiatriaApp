<?php
// Incluir el archivo de conexión
require_once '../../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profesional_id = $_POST['profesional_id'];
    $comentario = $_POST['comentario'];
    $nombre = $_POST['nombre'];

    // Preparar la consulta de inserción
    $sql = "INSERT INTO comentarios_presentaciones (profesional_id, comentario, nombre) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $profesional_id, $comentario, $nombre);

    // Ejecutar la consulta y verificar el resultado
    if ($stmt->execute()) {
        echo "Comentario agregado correctamente.";
    } else {
        echo "Error al agregar el comentario: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    // Redireccionar o manejar el resultado según sea necesario
    header("Location: ../adminPanel.php"); // Cambia esto por la ruta donde quieras redirigir después de agregar
    exit();
} else {
    echo "Solicitud no válida.";
}
?>
