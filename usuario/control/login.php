<?php
session_start();
include '../../php/conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM usuarios WHERE email = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nombre'] = $user['nombre'];  // Guardar el nombre del usuario en la sesión

    // Si hay un valor en 'redirect_to', redirige a esa URL
    if (!empty($_POST['redirect_to'])) {
      header('Location: ' . $_POST['redirect_to']);
    } else {
      // Si no hay redirección, lleva al dashboard
      header('Location: ../dashboard/dashboard.php');
    }
    exit();  // Siempre es buena práctica terminar el script después de la redirección
  } else {
    // Redirige a la página de inicio de sesión con un mensaje de error
    header('Location: ../index.php?error=invalid_credentials');
    exit();
  }


}
?>