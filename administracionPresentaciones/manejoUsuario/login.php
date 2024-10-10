<?php
session_start(); // Asegurarse de iniciar la sesión al principio
require_once('../../php/conexion.php'); // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar el usuario
    $sql = "SELECT * FROM administradores WHERE username = '$username'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Verificar la contraseña
        if (password_verify($password, $admin['password'])) {
            // Contraseña correcta, crear sesión de usuario
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];

            // Redirigir a la página de administración
            header("Location: ../adminPanel.php");
            exit;
        } else {
            // Contraseña incorrecta, enviar error por URL
            header("Location: ../inicioAdmin.php?error=incorrect_password");
            exit;
        }
    } else {
        // Usuario no encontrado, enviar error por URL
        header("Location: ../inicioAdmin.php?error=user_not_found");
        exit;
    }
}
?>
