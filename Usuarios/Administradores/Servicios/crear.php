<?php include("../templates/header.php");  






session_start();
include("../conexion.php");

if($_POST){

  $tipo_servicio = (isset($_POST['tipo_servicio'])) ? $_POST['tipo_servicio'] : '';
  $costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
  $duracion = (isset($_POST['duracion'])) ? $_POST['duracion'] : '';
  $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';



  $sql = "INSERT INTO servicio (tipo_servicio, costo , duracion,descripcion) 
  VALUES ('$tipo_servicio', '$costo', '$duracion', '$descripcion')";


mysqli_query($conexion, $sql);

header("Location:index.php");

}

?>


<div class="card">
    <div class="card-header">
    Datos de el servicio
    </div>
    <div class="card-body">
        <form action="" method="post">

        <div class="mb-3">
          <label for="tipo_servicio" class="form-label">Tipo de Servicio</label>
          <input type="text"
            class="form-control" name="tipo_servicio" id="tipo_servicio" aria-describedby="helpId" placeholder="Servicio" required autofocus>
        </div>

        <div class="mb-3">
          <label for="costo" class="form-label">Costo</label>
          <input type="text"
            class="form-control" name="costo" id="costo" aria-describedby="helpId" placeholder="costo" required autofocus>
        </div>
        
        <div class="mb-3">
          <label for="duracion" class="form-label">Duracion</label>
          <input type="time"
            class="form-control" name="duracion" id="duracion" aria-describedby="helpId" placeholder="Duracion" required autofocus>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripcion</label>
          <input type="text"
            class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripcion" required autofocus>
        </div>

        <button type="submit" class="btn btn-success">Agregar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../templates/footer.php");  ?>