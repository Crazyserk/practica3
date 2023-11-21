<?php //IP BASE DE DATOS
$servername = "localhost";
$username = "root";
$password = "medac";
$dbname = "db_base";

$conn = new mysqli($servername, $username, $password, $dbname)
    or die("Error en la conexión");
?>