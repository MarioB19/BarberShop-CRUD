<?php include("../templates/header.php");


session_start();
include("../conexion.php");

if($_POST){

  $fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
  $hora = (isset($_POST['hora'])) ? $_POST['hora'] : '';
  $id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';


  
  


  $sql = "INSERT INTO horario (fecha, hora, id_barbero) 
  VALUES ('$fecha', '$hora', '$id_barbero')";


mysqli_query($conexion, $sql);






header("Location:index.php");





}

?>

<div class="card">
    <div class="card-header">
    Datos de el horario
    </div>
    <div class="card-body">
        <form action="" method="post">


        <div class="mb-3">
  <label for="id_barbero" class="form-label">Barbero</label>
  <select class="form-select" name="id_barbero" id="id_barbero" required autofocus>
    <?php
    //Mostrar los barberos disponibles en el select
    $sql = "SELECT barbero.id_barbero , usuario.nombre FROM usuario
    INNER JOIN barbero on barbero.id_usuario= usuario.id_usuario";

    $resultado = mysqli_query($conexion, $sql);

    while($row = mysqli_fetch_array($resultado)){


      echo "<option value='{$row['id_barbero']}' $selected>{$row['id_barbero']} - {$row['nombre']}</option>";
    }
    ?>
  </select>
</div>



        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date"
            class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha" required autofocus>
        </div>

        <div class="mb-3">
          <label for="hora" class="form-label">Hora</label>
          <input type="time"
            class="form-control" name="hora" id="hora" aria-describedby="helpId" placeholder="Hora" required autofocus>
        </div>
        
        
       

        <button type="submit" class="btn btn-success">Agregar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../templates/footer.php");  ?>