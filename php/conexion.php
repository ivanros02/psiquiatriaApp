<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "comentariosphp";

/*
$hostname = "localhost";
$username = "id21770911_ivanross";
$password = "Wss1593.";
$database = "id21770911_comentariosphp";
*/

$conexion = mysqli_connect($hostname, $username, $password, $database);

if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

?>
