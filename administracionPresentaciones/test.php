<?php
$password = '2024'; // Contraseña a hashear
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash de la contraseña: " . $hash;
?>
