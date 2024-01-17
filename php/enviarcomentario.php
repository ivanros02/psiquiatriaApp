<?php
include 'conexion.php';

// Obtener el ID del psicólogo desde el formulario
$psychologistId = isset($_POST['psychologist_id']) ? intval($_POST['psychologist_id']) : 0;

// Validar el ID del psicólogo
if ($psychologistId <= 0) {
    // Mostrar mensaje de error si el ID no es válido
    echo '<script>alert("ID de psicólogo no válido");</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Llamando a los campos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);

    // Insertar comentario en la base de datos
    $query = "INSERT INTO comentarios (nombre, comentario, psychologist_id) VALUES ('$nombre', '$comentario', $psychologistId)";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // Redireccionar a la página original con éxito
        header("Location: ../presentacion/presentacionProfesional.php?id=$psychologistId&comentarioExitoso=true");
        exit;
    } else {
        // Manejar error en la inserción si es necesario
        echo "Error al insertar el comentario en la base de datos: " . mysqli_error($conexion);
    }
} else {
    // Si no es una solicitud POST, redirigir a alguna página o mostrar un mensaje de error.
    echo "Error en la solicitud.";
}
?>
