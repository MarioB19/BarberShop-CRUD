<?php 
session_start();
if(!isset($_SESSION['username'])){
  header("Location:../../../index.php");
}
include("../conexion.php");

include("../templates/header.php"); 

$imprimir_horarios = mysqli_query($conexion,"SELECT horario.id_horario,horario.fecha,horario.hora,barbero.id_barbero
from horario
INNER JOIN barbero on barbero.id_barbero = horario.id_barbero;
");


if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "DELETE from horario where id_horario = '$txtID'";

    mysqli_query($conexion,$sql);

    header("Location:index.php");
}



?>

<br/>
<h3> Horarios </h3>
<div class="card">
    <div class="card-header">
  
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Ingresar Horarios</a>
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table "  >
            <thead>
                <tr>
                    <th scope="col">Id_Horario</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Id_barbero</th>
                    <th scope="col">Acciones</th>
    
                   
                </tr>
            </thead>
            <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_horarios)) { ?>
 
                <tr class="">
                    
       
                <td scope="row"><?php echo $fila["id_horario"];?> </td>
                <td><?php echo $fila["fecha"];?> </td>
                <td><?php echo $fila["hora"];?> </td>
                <td><?php echo $fila["id_barbero"];?> </td>
            
        
                    
                    <td>  
     <a name="" id="" class="btn btn-primary" href="editar.php?txtID=<?php echo $fila["id_horario"];?>" role="button">Modificar</a>
          
        <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $fila["id_horario"];?>" role="button">Eliminar</a>
            </td>
        
        
                </tr>
<?php
            }
                ?>
            </tbody>
        </table>

    </div>
    
    </div>
</div>


<?php include("../templates/footer.php");  ?>