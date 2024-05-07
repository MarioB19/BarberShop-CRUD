<?php 
include("../templates/header.php");
session_start();
include("../conexion.php");





//Obtener el id del barbero seleccionado
$id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';

$sql = "SELECT fecha FROM horario WHERE id_barbero = '$id_barbero'";

$resultado = mysqli_query($conexion, $sql);

$fechas_disponibles = [];

while($row = mysqli_fetch_array($resultado)){
    $fechas_disponibles[] = $row['fecha'];
}


//Obtener la fecha seleccionada
$fecha_cita = (isset($_POST['fecha_cita'])) ? $_POST['fecha_cita'] : '';

// Si se ha seleccionado un barbero y una fecha, mostrar la sección de selección de hora
if ($id_barbero && $fecha_cita) {
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

if($_POST && isset($_POST['confirmar_cita'])){

  $id_barbero = (isset($_POST['id_barbero'])) ? $_POST['id_barbero'] : '';
  $fecha_cita = (isset($_POST['fecha_cita'])) ? $_POST['fecha_cita'] : '';
  $hora_cita = (isset($_POST['hora_cita'])) ? $_POST['hora_cita'] : '';
  $estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

  $id_servicio= (isset($_POST['id_servicio'])) ?  $_POST['id_servicio'] : '';
  $id_cliente= (isset($_POST['id_cliente'])) ?  $_POST['id_cliente'] : '';

  $fecha_ingreso = (isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '';

  $sql = ("Select id_horario from horario where fecha='$fecha_cita' && hora='$hora_cita' && id_barbero ='$id_barbero'");

  $id= mysqli_query($conexion, $sql);


  $id_horario = mysqli_fetch_array($id)['id_horario'];



  $sql = "INSERT INTO agendar (id_barbero , fecha_cita , hora_cita,estado,id_servicio , id_cliente , id_horario) 
  VALUES ('$id_barbero' , '$fecha_cita' , '$hora_cita','$estado','$id_servicio' , '$id_cliente' ,'$id_horario')";

  mysqli_query($conexion, $sql);

  header("Location:index.php");
  exit;

}

?>

<div class="card">
    <div class="card-header">
    Datos de la cita
    </div>
    <div class="card-body">
        <form action="" method="post">

<div class="mb-3">
  <label for="id_barbero" class="form-label">Barbero</label>
  <select class="form-select" name="id_barbero" id="id_barbero">
    <?php
    //Mostrar los barberos disponibles en el select
    $sql = "SELECT barbero.id_barbero , usuario.nombre FROM usuario
    INNER JOIN barbero on barbero.id_usuario= usuario.id_usuario";


    $resultado = mysqli_query($conexion, $sql);

    while($row = mysqli_fetch_array($resultado)){
      $selected = ($row['id_barbero'] == $_POST['id_barbero']) ? 'selected' : '';


      echo "<option value='{$row['id_barbero']}' $selected>{$row['id_barbero']} - {$row['nombre']}</option>";
    }
    ?>
  </select>
</div>


        <button type="submit" class="btn btn-primary">Validar Disponibilidad</button>



        <div class="mb-3">
  <label for="fecha_cita" class="form-label">Fecha de la cita</label>
  <select class="form-select" name="fecha_cita" id="fecha_cita" >
    <option value="">Seleccionar fecha</option>
    <?php
      //Mostrar las fechas disponibles en el select
      foreach($fechas_disponibles as $fecha){
        $selected = ($fecha == $_POST['fecha_cita']) ? "selected" : "";
        echo "<option value='$fecha' $selected>$fecha</option>";
      }
    ?>
  </select>
</div>

    <button type="submit" class="btn btn-primary">Validar Horas</button>


    <div class="mb-3">
  <label for="hora_cita" class="form-label">Hora de la cita</label>
  <select class="form-select" name="hora_cita" id="hora_cita" >
    <option value="">Seleccionar hora</option>
    <?php
      //Mostrar las horas disponibles en el select
      foreach($horas_disponibles as $hora){
        $selected = '';
        if(isset($_POST['hora_cita']) && $_POST['hora_cita'] == $hora){
          $selected = 'selected';
        }
        echo "<option value='$hora' $selected>$hora</option>";
      }
    ?>
  </select>
</div>

<div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-select" name="estado" id="estado" >
        <option value="P">Pendiente</option>
        <option value="A">Aceptada</option>
        <option value="C">Cancelada</option>
      </select>
    </div>

   

    <div class="mb-3">
      <label for="id_servicio" class="form-label">Servicio</label>
      <select class="form-select" name="id_servicio" id="id_servicio" >
      <?php
      //Mostrar los clientes disponibles en el select
      $sql = "SELECT * FROM servicio";
      $resultado = mysqli_query($conexion, $sql);

      while($row = mysqli_fetch_array($resultado)){ ?>

        <option value= <?php echo $row["id_servicio"];?> ><?php echo $row["id_servicio"] . "-" . $row["tipo_servicio"];?></option>;
      
        <?php
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
  <label for="id_cliente" class="form-label">Cliente</label>
  <select class="form-select" name="id_cliente" id="id_cliente" >
    <?php
      //Mostrar los clientes disponibles en el select
      $sql = "SELECT cliente.id_cliente , usuario.nombre FROM usuario
      INNER JOIN cliente on cliente.id_usuario= usuario.id_usuario"
      ;

      $resultado = mysqli_query($conexion, $sql);

      while($row = mysqli_fetch_array($resultado)){ ?>

        <option value= <?php echo $row["id_cliente"];?> ><?php echo $row["id_cliente"] . "-" . $row["nombre"];?></option>;
      
        <?php
        }
        ?>
  </select>

</div>


    

    <button type="submit" name="confirmar_cita" id="confirmar_cita" class="btn btn-success">Crear cita</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    
    

    

  </form>
</div>
