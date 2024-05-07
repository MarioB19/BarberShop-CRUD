<?php 
include("../templates/header.php");
session_start();
include("../conexion.php");


$aux_id = "SELECT cliente.id_cliente FROM usuario 
INNER JOIN cliente on cliente.id_usuario = usuario.id_usuario
WHERE usuario.username = '{$_SESSION['username']}'";

$id_cliente =  mysqli_fetch_array(mysqli_query($conexion, $aux_id))['id_cliente'];




if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";


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







if($_POST && isset($_POST['confirmar_cita'])){

  $id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';
  $fecha_cita = (isset($_POST['fecha_cita'])) ? $_POST['fecha_cita'] : '';
  $hora_cita = (isset($_POST['hora_cita'])) ? $_POST['hora_cita'] : '';
  $estado = $cita[0]["estado"];

  if($barbero[0]["id_barbero"] != $id_barbero || $cita[0]["hora_cita"] != $hora_cita || $cita[0]["fecha_cita"] != $fecha_cita){
    $estado = "P";
  }

  $id_servicio= (isset($_POST['id_servicio'])) ?  $_POST['id_servicio'] : '';


  $fecha_ingreso = (isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '';

  $sql = ("Select id_horario from horario where fecha='$fecha_cita' && hora='$hora_cita' && id_barbero ='$id_barbero'");

  $id= mysqli_query($conexion, $sql);


  $id_horario = mysqli_fetch_array($id)['id_horario'];




  $sql = "UPDATE agendar
  SET id_barbero = '$id_barbero', fecha_cita = '$fecha_cita', hora_cita = '$hora_cita',estado ='$estado',
  id_servicio = '$id_servicio', id_cliente = '$id_cliente', id_horario = '$id_horario'
  WHERE id_cita = '$txtID'";

  mysqli_query($conexion, $sql);

  header("Location:index.php");
  exit;

}



$id_barbero = $barbero[0]["id_barbero"];
$fecha_cita = $cita[0]["fecha_cita"];
$estado = $cita[0]["estado"];

$estado = match ($estado) {
  'P' => "Pendiente",
  'A' => "Aceptada",
  'C' => "Cancelada",
};


?>

<div class="card">
    <div class="card-header">
    Datos de la cita
    </div>
    <div class="card-body">
        <form action="" method="post">

        
        <div class="mb-3">

                <label for="estado" class="form-label">Estado</label>
                <input type="text" value="<?php echo $estado?>" class="form-control" readonly name="estado" id="estado" aria-describedby="helpId" placeholder="estado">
            </div>
     



        <div class="mb-3">

  <label for="id_barbero" class="form-label">Barbero</label>
  <select class="form-select" name="id_barbero" id="id_barbero">
    <?php
      //Mostrar los barberos disponibles en el select
      $sql = "SELECT barbero.id_barbero, usuario.nombre FROM usuario
              INNER JOIN barbero ON barbero.id_usuario = usuario.id_usuario";

      $resultado = mysqli_query($conexion, $sql);

      $valorSeleccionado = "";

      if (isset($_POST["id_barbero"])) {
        $valorSeleccionado = $_POST["id_barbero"];
      } else if (isset($cita)) {
        $valorSeleccionado = $barbero[0]["id_barbero"];
      }

      while ($row = mysqli_fetch_array($resultado)) {
        $selected = ($valorSeleccionado == $row["id_barbero"]) ? "selected" : "";
        echo "<option value='{$row['id_barbero']}' $selected>{$row['id_barbero']} - {$row['nombre']}</option>";
      }
    ?>
  </select>
</div>





        <button type="submit" class="btn btn-primary">Validar Disponibilidad</button>

<?php

$id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';

  $sql = "SELECT fecha  FROM horario WHERE id_barbero = '$id_barbero'";

$resultado = mysqli_query($conexion, $sql);

$fechas_disponibles = [];

while($row = mysqli_fetch_array($resultado)){
    $fechas_disponibles[] = $row['fecha'];
}

?>







        <div class="mb-3">
  <label for="fecha_cita" class="form-label">Fecha de la cita</label>
  <select class="form-select" name="fecha_cita" id="fecha_cita" >
    <?php
      //Mostrar las fechas disponibles en el select
      $selected = "";

      if(isset($cita) && $id_barbero==$barbero["id_barbero"]){
        $fecha_cita = $cita[0]["fecha_cita"];
        echo "<option value='$fecha_cita' selected>$fecha_cita</option>";
      }



      foreach($fechas_disponibles as $fecha){
        if(isset($cita) && $fecha == $cita[0]["fecha_cita"]) continue; // omitir la fecha de la cita si ya se ha agregado al select
        $selected = (isset($_POST['fecha_cita']) && $_POST['fecha_cita'] == $fecha) ? "selected" : "";
        echo "<option value='$fecha'  $selected>$fecha</option>";
      }
    ?>
  </select>
</div>



    <button type="submit" class="btn btn-primary">Validar Horas</button>


    <?php
// Si se ha seleccionado un barbero y una fecha, mostrar la sección de selección de hora
if ($id_barbero && $fecha_cita) {

  $fecha_cita = (isset($_POST['fecha_cita'])) ? $_POST['fecha_cita'] : '';


    //Consulta para obtener las fechas y horas disponibles del barbero

    $sql = "SELECT horario.hora FROM horario
    LEFT JOIN agendar ON agendar.id_horario = horario.id_horario AND agendar.estado IN ('A', 'P')
    WHERE horario.id_barbero = '$id_barbero' AND horario.fecha = '$fecha_cita' AND agendar.id_horario IS NULL";

 

    $resultado = mysqli_query($conexion, $sql);

    $horas_disponibles = [];

    while($row = mysqli_fetch_array($resultado)){
        $horas_disponibles[] = $row['hora'];
    }
}

?>




    <div class="mb-3">
  <label for="hora_cita" class="form-label">Hora de la cita</label>
  <select class="form-select" name="hora_cita" id="hora_cita" >
    <?php
      //Mostrar las fechas disponibles en el select
      $selected = "";

      if(isset($cita) && $id_barbero==$barbero["id_barbero"] && $fecha_cita==$cita[0]["fecha_cita"]){
        $hora_cita = $cita[0]["hora_cita"];
        echo "<option value='$hora_cita' selected>$hora_cita</option>";
      }

      foreach($horas_disponibles as $hora){
        if(isset($cita) && $hora == $cita[0]["hora_cita"]) continue; // omitir la fecha de la cita si ya se ha agregado al select
        $selected = (isset($_POST['hora_cita']) && $_POST['hora_cita'] == $hora) ? "selected" : "";
        echo "<option value='$hora' $selected>$hora</option>";
      }
    ?>
  </select>
</div>

   





   

<div class="mb-3">
  <label for="id_servicio" class="form-label">Servicio</label>
  <select class="form-select" name="id_servicio" id="id_servicio" >
    <?php
    //Mostrar los servicios disponibles en el select
    $sql = "SELECT * FROM servicio";
    $resultado = mysqli_query($conexion, $sql);

    while($row = mysqli_fetch_array($resultado)){
      $selected = '';
      if(isset($_POST['id_servicio']) && $_POST['id_servicio'] == $row['id_servicio']){
        $selected = 'selected';
      }
      echo "<option value='{$row['id_servicio']}' $selected>{$row['id_servicio']} - {$row['tipo_servicio']}</option>";
    }
    ?>
  </select>
</div>



    <button type="submit" name="confirmar_cita" id="confirmar_cita" class="btn btn-success">Actualizar cita</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    
    

    

  </form>
</div>



