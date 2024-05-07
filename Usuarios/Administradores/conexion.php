
<?php 


$servidor = "localhost";
$baseDeDatos = "barbershop";
$usuario = $_SESSION['username'];
$contrasenia = $_SESSION['password'];




    $conexion = new mysqli($servidor, $usuario, $contrasenia,$baseDeDatos);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }





    



?>