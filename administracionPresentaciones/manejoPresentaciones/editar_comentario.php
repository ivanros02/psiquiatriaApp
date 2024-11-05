<?php
include '../../php/conexion.php'; // Asegúrate de que la ruta sea correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $id = $_POST['id'];
    $comentario = $_POST['comentario'];
    $nombre = $_POST['nombre'];

    // Preparamos la consulta de actualización
    $sql = "UPDATE comentarios_presentaciones SET comentario = ?, nombre = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $comentario, $nombre, $id);

    // Ejecutamos la consulta y verificamos el resultado
    if ($stmt->execute()) {
        echo "Comentario actualizado correctamente.";
    } else {
        echo "Error al actualizar el comentario: " . $stmt->error;
    }

    // Cerramos la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "Solicitud no válida.";
}
?>
