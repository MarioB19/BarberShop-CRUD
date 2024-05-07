<?php include("../templates/header.php");


session_start();
include("../conexion.php");

if($_POST){

  $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
  $ApeP = (isset($_POST['ApeP'])) ? $_POST['ApeP'] : '';
  $ApeM = (isset($_POST['ApeM'])) ? $_POST['ApeM'] : '';
  $username = (isset($_POST['username'])) ? $_POST['username'] : '';
  $password = (isset($_POST['password'])) ? password_hash($_POST['password'],PASSWORD_DEFAULT) : '';
  $password2 = (isset($_POST['password'])) ?  $_POST['password'] : '';
  $sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : '';
  $sexo = ($sexo == "masculino") ? "H" : "M";
  $correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
  $telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';

  $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
  
  $fecha_ingreso = (isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '';

  mysqli_query($conexion, "DROP PROCEDURE IF EXISTS calcular_anios_trabajados");

  $sql = "CREATE PROCEDURE calcular_anios_trabajados (
    IN fecha_ingreso DATE, 
    OUT anios_trabajados INT
)
BEGIN
    -- Calcula los años transcurridos desde la fecha de ingreso hasta la fecha actual
    SET anios_trabajados = YEAR(CURDATE()) - YEAR(fecha_ingreso) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(fecha_ingreso, '%m%d'));
END;";
mysqli_query($conexion, $sql);





  $sql = "INSERT INTO usuario (nombre, ApeP, ApeM, username, password, sexo, correo, telefono, tipo) 
  VALUES ('$nombre', '$ApeP', '$ApeM', '$username', '$password', '$sexo', '$correo', '$telefono', '$tipo')";

mysqli_query($conexion, $sql);

$aux_id ="Select id_usuario from usuario where username = '$username'";

$id =  mysqli_fetch_array(mysqli_query($conexion, $aux_id))['id_usuario'];


$sql = "CALL calcular_anios_trabajados('$fecha_ingreso', @anios_trabajados)";
mysqli_query($conexion, $sql);

// Obtener el valor de la variable @anios_trabajados
$resultado = mysqli_query($conexion, "SELECT @anios_trabajados AS anios_trabajados");
$anios_trabajados = mysqli_fetch_array($resultado)['anios_trabajados'];




$sql ="INSERT INTO barbero(fecha_ingreso,id_usuario, anios_trabajados) 
  VALUES('$fecha_ingreso' ,'$id', '$anios_trabajados')";

mysqli_query($conexion, $sql);

mysqli_query($conexion, "CREATE USER '$username'@'localhost' IDENTIFIED BY  '$password2'");

header("Location:index.php");









}


  ?>

<div class="card">
    <div class="card-header">
    Datos del Empleado 
    </div>
    <div class="card-body">
        <form action="" method="post">

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text"
            class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="nombre" required autofocus>
        </div>

        <div class="mb-3">
          <label for="ApeP" class="form-label">Apellido Paterno</label>
          <input type="text"
            class="form-control" name="ApeP" id="ApeP" aria-describedby="helpId" placeholder="ApeP" required autofocus>
        </div>
        
        <div class="mb-3">
          <label for="ApeM" class="form-label">Apellido Materno</label>
          <input type="text"
            class="form-control" name="ApeM" id="ApeM" aria-describedby="helpId" placeholder="ApeM" required autofocus>
        </div>


        <div class="form-group mb-3">
        <label for="sexo">Sexo</label>
              <select class="form-control" id="sexo" name="sexo">
        
              <option value="masculino">Masculino</option>
              <option value="femenino">Femenino</option>
             </select>
             </div>



        <div class="mb-3">
          <label for="telefono" class="form-label">Telefono</label>
          <input type="text"
            class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="telefono" required autofocus>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email"
            class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="correo" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password"
            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="password" required autofocus>
        </div>

        <div class="mb-3">
          <label for="user" class="form-label">Username</label>
          <input type="text"
            class="form-control" name="username" id="username" aria-describedby="helpId" placeholder="username" required autofocus>
        </div>

        <div class="form-group mb-3">
        <label for="tipo">Tipo Usuario</label>

              <select class="form-control" id="tipo" name="tipo"> 
              
              <option value="1">Barbero</option>
             </select>
             </div>


        <div class="mb-3">
          <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
          <input type="date"
            class="form-control" name="fecha_ingreso" id="fecha_ingreso" aria-describedby="helpId" placeholder="fecha_ingreso" required autofocus>
        </div>

        <button type="submit" class="btn btn-success">Agregar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>
        
    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../templates/footer.php");  ?>