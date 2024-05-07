
<?php 
include("../templates/header.php");
session_start();
include("../conexion.php");


if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";


    mysqli_query($conexion, "DROP View IF EXISTS vCliente");
    $query = "CREATE VIEW vCliente AS SELECT cliente.id_cliente, usuario.nombre FROM cliente
    INNER JOIN usuario ON usuario.id_usuario = cliente.id_usuario
    INNER JOIN agendar on agendar.id_cliente =cliente.id_cliente
    where id_cita = '$txtID'";

    
   mysqli_query($conexion,$query);


   

    
    $resultado = mysqli_query($conexion,"SELECT * from vCliente");



    $cliente = [];
    
    // Obtener cada fila de la consulta y guardarla en el arreglo
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cliente[] = $fila;
    }




    mysqli_query($conexion, "DROP View IF EXISTS vCita");

    $query = "CREATE VIEW vCita AS SELECT agendar.fecha_cita , agendar.hora_cita , 
    agendar.estado , servicio.id_servicio , servicio.tipo_servicio
    from agendar
    INNER JOIN servicio on servicio.id_servicio = agendar.id_servicio
    where id_cita = '$txtID'";


    
 mysqli_query($conexion,$query);



    
 $resultado = mysqli_query($conexion,"SELECT * from vCita");



$cita = [];

// Obtener cada fila de la consulta y guardarla en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $cita[] = $fila;
}

    


mysqli_query($conexion, "DROP View IF EXISTS vBarbero");
    $query = "CREATE VIEW vBarbero AS SELECT barbero.id_barbero, usuario.nombre FROM barbero
    INNER JOIN usuario ON usuario.id_usuario = barbero.id_usuario
    INNER JOIN agendar on agendar.id_barbero = barbero.id_barbero
    where id_cita = '$txtID'";

mysqli_query($conexion,$query);



    
$resultado = mysqli_query($conexion,"SELECT * from vBarbero");

    $barbero = [];
    
    // Obtener cada fila de la consulta y guardarla en el arreglo
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $barbero[] = $fila;
    }











}










if($_POST){


    $estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

    $sql = "UPDATE agendar
    SET 
    estado = '$estado'
    WHERE id_cita = '$txtID'";
  
    mysqli_query($conexion, $sql);
  
    header("Location:index.php");
  
  
  }




?>






<div class="card">
    <div class="card-header">
    Datos de la cita
    </div>
    <div class="card-body">
        <form action="" method="post">
            


        <div class="mb-3">
          <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
          <input type="date"
          value = <?php echo $cita[0]["fecha_cita"]?>
            class="form-control" readonly name="fecha_cita" id="fecha_cita" aria-describedby="helpId" placeholder="fecha_cita" >
        </div>

        <div class="mb-3">
          <label for="hora_cita" class="form-label">Hora de  la Cita</label>
          <input type="time"
          value = <?php echo $cita[0]["hora_cita"]?>
            class="form-control" readonly name="hora_cita" id="hora_cita" aria-describedby="helpId" placeholder="hora_cita" >
        </div>





<div class="mb-3">
  <label for="estado" class="form-label">Estado</label>
  <select class="form-select" name="estado" id="estado">
    <?php
      //Mostrar los estados disponibles en el select
      $estados = array("P" => "Pendiente", "A" => "Aceptada", "C" => "Cancelada");
      foreach($estados as $key => $value) {
        $selected = "";
        if (isset($cita) && $cita[0]["estado"] == $key) {
          $selected = "selected";
        }
        echo "<option value='$key' $selected>$value</option>";
      }
    ?>
  </select>
</div>



   

  <div class="mb-3">
          <label for="id_servicio" class="form-label">Servicio</label>
          <input type="text"
          value = "<?php echo $cita[0]["id_servicio"]."-".$cita[0]["tipo_servicio"];?>"
            class="form-control" readonly name="id_servicio" id="fecha_cita" aria-describedby="helpId" placeholder="fecha_cita" >
        </div>



        <div class="mb-3">
          <label for="id_cliente" class="form-label">Cliente</label>
          <input type="text"
          value = "<?php echo $cliente[0]["id_cliente"]."-".$cliente[0]["nombre"];?>"
            class="form-control" readonly name="id_cliente" id="id_cliente" aria-describedby="helpId" placeholder="id_cliente" >
        </div>













    

    <button type="submit" name="confirmar_cita" id="confirmar_cita" class="btn btn-success">Actualizar cita</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    
    

    

  </form>
</div>







<?php include("../templates/footer.php");  ?>