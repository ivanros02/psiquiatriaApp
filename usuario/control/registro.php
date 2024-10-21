<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("sss", $nombre, $email, $password);

  if ($stmt->execute()) {
    // Redirige a la página de login con un parámetro para mostrar la alerta
    header('Location: ../index.php?registro=exitoso');
  } else {
    echo "Error al registrar el usuario.";
  }
}
?>
