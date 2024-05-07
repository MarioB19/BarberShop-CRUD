<?php include("../templates/header.php");  






session_start();
include("../conexion.php");

if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "SELECT tipo_servicio , costo , duracion , descripcion from servicio where id_servicio = '$txtID'";

    $resultado = mysqli_query($conexion,$sql);



    $servicio = [];

// Obtener cada fila de la consulta y guardarla en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $servicio[] = $fila;
}



}



if($_POST){

  $tipo_servicio = (isset($_POST['tipo_servicio'])) ? $_POST['tipo_servicio'] : '';
  $costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
  $duracion = (isset($_POST['duracion'])) ? $_POST['duracion'] : '';
  $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';



  $sql = "UPDATE servicio
  SET tipo_servicio =  '$tipo_servicio' ,costo = '$costo' , duracion = '$duracion' ,descripcion = '$descripcion' 
where id_servicio = '$txtID'";


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
          value = "<?php echo $servicio[0]["tipo_servicio"];?>"

            class="form-control" name="tipo_servicio" id="tipo_servicio" aria-describedby="helpId" placeholder="Servicio" required autofocus>
        </div>

        <div class="mb-3">
          <label for="costo" class="form-label">Costo</label>
          <input type="text"
          value ="<?php echo $servicio[0]["costo"];?>"
            class="form-control" name="costo" id="costo" aria-describedby="helpId" placeholder="costo" required autofocus>
        </div>
        
        <div class="mb-3">
          <label for="duracion" class="form-label">Duracion</label>
          <input type="time"
          value =<?php echo $servicio[0]["duracion"];?>
            class="form-control" name="duracion" id="duracion" aria-describedby="helpId" placeholder="Duracion" required autofocus>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripcion</label>
          <input type="text"
          value = "<?php echo $servicio[0]["descripcion"];?>"
            class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripcion" required autofocus>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../templates/footer.php");  ?>

