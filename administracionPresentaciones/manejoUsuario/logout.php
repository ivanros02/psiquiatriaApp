<?php
session_start();
session_destroy(); // Destruir todas las sesiones activas

header("Location: ../inicioAdmin.php"); // Redirigir al login
exit;
?>
