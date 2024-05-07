

<?php include("../templates/header.php");


session_start();

include("../conexion.php");



if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "SELECT barbero.id_barbero , usuario.nombre , horario.hora , horario.fecha FROM barbero
    INNER JOIN horario on horario.id_barbero= barbero.id_barbero
    INNER JOIN usuario on usuario.id_usuario = barbero.id_usuario
    where horario.id_horario = '$txtID'";




    


 
    $resultado = mysqli_query($conexion,$sql);



    $horario = [];

// Obtener cada fila de la consulta y guardarla en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $horario[] = $fila;
}
}




if($_POST){

  $fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
  $hora = (isset($_POST['hora'])) ? $_POST['hora'] : '';
  $id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';


  $sql = "UPDATE horario
  SET fecha = '$fecha' , hora = '$hora' , id_barbero = '$id_barbero'
  where id_horario = '$txtID'";
  


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

      $valorSeleccionado = "";

      if(isset($horario[0])) {
        $valorSeleccionado = $horario[0]["id_barbero"] . ", " . $horario[0]["nombre"];
      }

      while($row = mysqli_fetch_array($resultado)){
        $valorActual = $row['id_barbero'] . ", " . $row['nombre'];

        $selected = ($valorSeleccionado == $valorActual) ? "selected" : "";

        echo "<option value='{$row['id_barbero']}' $selected>{$row['id_barbero']} - {$row['nombre']}</option>";
      }
    ?>
  </select>
</div>





        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date"
          value = <?php echo $horario[0]["fecha"];?>
            class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha" required autofocus>
        </div>

        <div class="mb-3">
          <label for="hora" class="form-label">Hora</label>
          <input type="time"
          value = <?php echo $horario[0]["hora"];?>
            class="form-control" name="hora" id="hora" aria-describedby="helpId" placeholder="Hora" required autofocus>
        </div>
        
        
       

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../templates/footer.php");  ?>



<?php include("../templates/footer.php");  ?>