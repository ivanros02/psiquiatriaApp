<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "terapia";

/*
$hostname = "localhost";
$username = "terapial_terapia";
$password = "Wss1593.";
$database = "terapial_terapia";
*/

/*
$hostname = "localhost";
$username = "id21770911_comentariosphp";
$password = "Wss1593.";
$database = "id21770911_ivanross";
*/

$conexion = mysqli_connect($hostname, $username, $password, $database);

if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

$conexion->set_charset('utf8mb4');

?>
