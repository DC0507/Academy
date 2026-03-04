<?php

//Credenciales
$host = "localhost";
$user = "root";
$password = "";
$database = "academia_db";

//Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $database);

//Si hay un error de conexión se captura y se muestra
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

?>