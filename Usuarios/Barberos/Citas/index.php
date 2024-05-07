<?php


session_start();

if(!isset($_SESSION['username'])){
  header("Location:../../../index.php");
}

include("../conexion.php");


$aux_id = "SELECT barbero.id_barbero FROM usuario 
INNER JOIN barbero on barbero.id_usuario = usuario.id_usuario
WHERE usuario.username = '{$_SESSION['username']}'";

$id_barbero =  mysqli_fetch_array(mysqli_query($conexion, $aux_id))['id_barbero'];






$imprimir_citas = mysqli_query($conexion,"SELECT * from agendar where id_barbero = '$id_barbero'");



if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "DELETE from agendar where id_cita = '$txtID'";

    mysqli_query($conexion,$sql);

    header("Location:index.php");
}




include("../templates/header.php");  

?>

<br/>
<h3> Citas </h3>
<div class="card">
    <div class="card-header">
  
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table "  >
            <thead>
                <tr>
                    <th scope="col">Fecha Cita</th>
                    <th scope="col">Hora cita</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Id Cliente</th>
                    <th scope="col">Id Servicio</th>
                    <th scope="col">Acciones</th>
                   
                </tr>
            </thead>
            <tbody>

            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_citas)) { ?>
 
                <tr class="">
                    
                
                    <td><?php echo $fila["fecha_cita"];?> </td>
                    <td><?php echo $fila["hora_cita"];?> </td>
                    <td><?php echo $fila["estado"];?> </td>
                    <td><?php echo $fila["id_cliente"];?> </td>
                    <td><?php echo $fila["id_servicio"];?> </td>


        
                    
                    <td>  
        <a name="" id="" class="btn btn-primary" href="confirmar.php?txtID=<?php echo $fila["id_cita"];?>" role="button">Confirmar</a>
          
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