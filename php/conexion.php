<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "comentariosphp";

/*
$hostname = "localhost";
$username = "c2012063_terapia";
$password = "guBUgede85";
$database = "c2012063_terapia";
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

?>
