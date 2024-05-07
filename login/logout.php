<?php 

session_start();
session_destroy();

include("../Usuarios/Administradores/conexion.php");
include("../Usuarios/Barberos/conexion.php");
include("../Usuarios/Clientes/conexion.php");


mysqli_close($conexion);


include("../bd.php");


Header("Location:../index.php");

?>