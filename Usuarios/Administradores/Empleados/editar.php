<?php include("../templates/header.php");


session_start();
include("../conexion.php");

if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "SELECT usuario.nombre , usuario.ApeP , usuario.ApeM , usuario.sexo,usuario.telefono , usuario.correo , usuario.password , 
    usuario.username , usuario.tipo , barbero.fecha_ingreso from usuario
    INNER JOIN Barbero on barbero.id_usuario = usuario.id_usuario
    where usuario.id_usuario = '$txtID'";
    


 
    $resultado = mysqli_query($conexion,$sql);



    $empleados = [];

// Obtener cada fila de la consulta y guardarla en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $empleados[] = $fila;
}
}


if($_POST){

    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
    $ApeP = (isset($_POST['ApeP'])) ? $_POST['ApeP'] : '';
    $ApeM = (isset($_POST['ApeM'])) ? $_POST['ApeM'] : '';
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    $sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : '';
    $sexo = ($sexo == "masculino") ? "H" : "M";
    $correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
    $telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
  
    $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
    
    $fecha_ingreso = (isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '';
  
    $aux_id ="Select id_usuario from usuario where username = '$username'";
    $id_usuario =  mysqli_fetch_array(mysqli_query($conexion, $aux_id))['id_usuario'];

    if($tipo==2){
  

        $sql = "DELETE from barbero where id_usuario = '$id_usuario'";
        mysqli_query($conexion, $sql);

        
$sql ="INSERT INTO cliente(id_usuario) VALUES('$id_usuario')";
mysqli_query($conexion, $sql);
        

    }

    
    $sql = "UPDATE usuario SET 
    nombre='$nombre', 
    ApeP='$ApeP', 
    ApeM='$ApeM', 
    username='$username', 
    sexo='$sexo', 
    correo='$correo', 
    telefono='$telefono', 
    tipo='$tipo' 
    WHERE id_usuario=$id_usuario";

  
  mysqli_query($conexion, $sql);
  


if($tipo==1){
  $sql = "UPDATE barbero SET fecha_ingreso='$fecha_ingreso', 
  anios_trabajados=(YEAR(CURDATE()) - YEAR('$fecha_ingreso') - 
  (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT('$fecha_ingreso', '%m%d')))
  WHERE id_usuario='$id_usuario'";



  
  mysqli_query($conexion, $sql);
}
  
  
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
          <label for="" class="form-label">ID</label>
          <input type="text"

          value = <?php echo $txtID ;?>
            class="form-control" readonly name="id_usuario" id="id_usuario" aria-describedby="ID" placeholder="ID">

        </div>

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text"
          value ="<?php echo $empleados[0]["nombre"];?>"
            class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="nombre" required autofocus>
        </div>

        <div class="mb-3">
          <label for="ApeP" class="form-label">Apellido Paterno</label>
          <input type="text"
          value = <?php echo $empleados[0]["ApeP"];?>
            class="form-control" name="ApeP" id="ApeP" aria-describedby="helpId" placeholder="ApeP" required autofocus>
        </div>
        
        <div class="mb-3">
          <label for="ApeM" class="form-label">Apellido Materno</label>
          <input type="text"
          value = <?php echo $empleados[0]["ApeM"];?>
            class="form-control" name="ApeM" id="ApeM" aria-describedby="helpId" placeholder="ApeM" required autofocus>
        </div>


        <div class="form-group mb-3">
    <label for="sexo">Sexo</label>
    <select class="form-control" id="sexo" name="sexo">
        <option value="masculino" <?php if($empleados[0]["sexo"]=="masculino") echo "selected"; ?>>Masculino</option>
        <option value="femenino" <?php if($empleados[0]["sexo"]=="femenino") echo "selected"; ?>>Femenino</option>
    </select>
</div>






        <div class="mb-3">


          <label for="telefono" class="form-label">Telefono</label>
          <input type="text"
          value = <?php echo $empleados[0]["telefono"];?>
            class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="telefono" required autofocus>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email"
          value = <?php echo $empleados[0]["correo"];?>
            class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="correo" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password"
          value = "<?php echo  $empleados[0]["password"];?>"
            class="form-control" readonly name="password" id="password" aria-describedby="helpId" placeholder="password" required autofocus>
        </div>

        <div class="mb-3">
          <label for="user" class="form-label">Username</label>
          <input type="text"
          value = <?php echo $empleados[0]["username"];?>
            class="form-control" readonly name="username" id="username" aria-describedby="helpId" placeholder="username" required autofocus>
        </div>

        <div class="form-group mb-3">
    <label for="tipo">Tipo de Usuario</label>
    <select class="form-control" id="tipo" name="tipo"> 
        <option value="1" <?php echo ($empleados[0]["tipo"] == 1) ? "selected" : ""; ?>>Barbero</option>
        <option value="2" <?php echo ($empleados[0]["tipo"] == 2) ? "selected" : ""; ?>>Cliente</option>
    </select>
</div>



        <div class="mb-3">
          <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
          <input type="date"
          value = <?php echo $empleados[0]["fecha_ingreso"];?>
            class="form-control" name="fecha_ingreso" id="fecha_ingreso" aria-describedby="helpId" placeholder="fecha_ingreso" required autofocus>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>
        
    </div>
    <div class="card-footer text-muted"> </div>
</div>




<?php include("../templates/footer.php");  ?>