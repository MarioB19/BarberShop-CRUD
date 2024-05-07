<?php
session_start();

if(!isset($_SESSION['username'])){
  header("Location:../../../index.php");
}

include("../conexion.php");


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
  
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Ingresar Servicios</a>
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table "  >
            <thead>
                <tr>
                    <th scope="col">Id_Servicio</th>
                    <th scope="col">Tipo servicio</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Duracion</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Acciones</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_servicios)) { ?>
 
                <tr class="">
                    
       
                <td scope="row"><?php echo $fila["id_servicio"];?> </td>
                <td><?php echo $fila["tipo_servicio"];?> </td>
                <td><?php echo $fila["costo"];?> </td>
                <td><?php echo $fila["duracion"];?> </td>
                <td><?php echo $fila["descripcion"];?> </td>
             
            
            
        
                    
                    <td>  
        <a name="" id="" class="btn btn-primary" href="editar.php?txtID=<?php echo $fila["id_servicio"];?>" role="button">Modificar</a>
          
        <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $fila["id_servicio"];?>" role="button">Eliminar</a>

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