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



$imprimir_servicios = mysqli_query($conexion,"SELECT * from servicio");

if(isset($_GET["txtID"])){

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    $sql = "DELETE from servicio where id_servicio = '$txtID'";

    mysqli_query($conexion,$sql);

    header("Location:index.php");
}



include("../templates/header.php");  ?>

<br/>
<h3> Servicios </h3>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table "  >
            <thead>
                <tr>
                 
                    <th scope="col">Tipo servicio</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Duracion</th>
                    <th scope="col">Descripcion</th>
                   
                   
                </tr>
            </thead>
            <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_servicios)) { ?>
 
                <tr class="">
                    
       
      
                <td><?php echo $fila["tipo_servicio"];?> </td>
                <td><?php echo $fila["costo"];?> </td>
                <td><?php echo $fila["duracion"];?> </td>
                <td><?php echo $fila["descripcion"];?> </td>
             
            
            
        
                
        
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