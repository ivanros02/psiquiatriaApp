<?php
// Incluir el archivo de conexión
include '../php/conexion.php';

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$titulo = $_POST['titulo'];
$matricula = $_POST['matricula'];
$matriculaP = $_POST['matriculaP'];
$especialidad = $_POST['especialidad'];
$descripcion = $_POST['descripcion'];
$telefono = $_POST['telefono'];
$disponibilidad = $_POST['disponibilidad'];
$valor = $_POST['valor'];
$mail = $_POST['mail'];
$whatsapp = $_POST['whatsapp'];
$instagram = $_POST['instagram'];

// Procesar la imagen
$imagen_nombre = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];
$rutaImagen = "../img/" . $imagen_nombre;
move_uploaded_file($imagen_temp, $rutaImagen);

// Consulta SQL para la inserción de datos
$sql = "INSERT INTO presentaciones (rutaImagen, nombre, titulo, matricula, matriculaP, especialidad, descripcion, telefono, disponibilidad, valor, mail, whatsapp, instagram) VALUES ('$rutaImagen', '$nombre', '$titulo', $matricula, $matriculaP, '$especialidad', '$descripcion', $telefono, $disponibilidad, $valor, '$mail', $whatsapp, '$instagram')";

if ($conexion->query($sql) === TRUE) {
    echo "Los datos se han insertado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

// Cerrar conexión (si es necesario, dependiendo de cómo esté configurado en tu archivo de conexión)
$conexion->close();
?>
