<?php




$servidor = "localhost";
$baseDeDatos = "barbershop";
$usuario = "root";
$contrasenia = "";





    $conexion = new mysqli($servidor, $usuario, $contrasenia,$baseDeDatos);
 
  



    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }




  












?>