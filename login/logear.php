<?php

 include("../bd.php"); 

 
 
 session_start();

 

 

 ?>


<?php


$username = $_POST['username'];


$password = $_POST['password'];


$passwordExistente = "";



$sql = "SELECT * FROM usuario where username = '$username'";

  $valor = "SELECT tipo from usuario where username = '$username'";


$respuesta = mysqli_query($conexion,$sql);

$passwordExistente =mysqli_fetch_array($respuesta)['password'];





if(password_verify($password, $passwordExistente)){
  $_SESSION['username'] = $username;
  $_SESSION['password'] = $password;


  $valor = "SELECT tipo FROM usuario WHERE username = '$username'";
  $resultado = mysqli_query($conexion, $valor);



  $tipoUsuario = mysqli_fetch_array($resultado)['tipo'];







  if ($tipoUsuario == "0") {

  
      
    mysqli_query($conexion, "GRANT ALL PRIVILEGES ON barbershop.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT GRANT OPTION ON *.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT CREATE USER ON *.* TO '$username'@'localhost';");

 
 
    mysqli_query($conexion, "FLUSH PRIVILEGES");

    mysqli_close($conexion);


 

      header("Location:../Usuarios/Administradores/index.php");



  } else if ($tipoUsuario == "1") {

    mysqli_query($conexion, "GRANT ALL PRIVILEGES ON barbershop.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT GRANT OPTION ON *.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT CREATE USER ON *.* TO '$username'@'localhost';");

   
    mysqli_query($conexion, "FLUSH PRIVILEGES");

    mysqli_close($conexion);


    
 

    header("Location:../Usuarios/Barberos/index.php");
  }

  else if ($tipoUsuario == "2") {

    mysqli_query($conexion, "GRANT ALL PRIVILEGES ON barbershop.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT GRANT OPTION ON *.* TO '$username'@'localhost'");
    mysqli_query($conexion ,"GRANT CREATE USER ON *.* TO '$username'@'localhost';");

   
    mysqli_query($conexion, "FLUSH PRIVILEGES");

    mysqli_close($conexion);


    header("Location:../Usuarios/Clientes/index.php");
}


}
else{
  header("Location:../index.php");
}





?>
