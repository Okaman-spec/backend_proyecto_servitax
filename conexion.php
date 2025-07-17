<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$basededatos = "servitax";
$conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);
if (!$conexion) {
    error_log("Error de conexión a la base de datos: " . mysqli_connect_error());
}