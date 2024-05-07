<?php 
session_start();
if(!isset($_SESSION['username'])){
  header("Location:../../../index.php");
}


include("../conexion.php");



$imprimir_barberos = mysqli_query($conexion,"SELECT barbero.id_barbero,usuario.id_usuario ,usuario.nombre , usuario.ApeP , usuario.ApeM,
usuario.sexo,usuario.telefono,usuario.correo , usuario.username,usuario.tipo, barbero.fecha_ingreso , barbero.anios_trabajados
from usuario
INNER JOIN barbero on barbero.id_usuario = usuario.id_usuario;
");

if(isset($_GET["txtID"])){
    

    $txtID=(isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    $aux_id ="Select username from usuario where id_usuario = '$txtID'";
    $username =  mysqli_fetch_array(mysqli_query($conexion, $aux_id))['username'];

    

    $sql = "DELETE from usuario where id_usuario = '$txtID'";

    mysqli_query($conexion,$sql);


    mysqli_query($conexion, "DROP USER '$username'@'localhost'");

    header("Location:index.php");
}


include("../templates/header.php");




?>




<br/>
<h3> Empleados </h3>
<div class="card">
    <div class="card-header">
  
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Ingresar empleado</a>
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table "  >
            <thead>
                <tr>
                <th scope="col" style="text-align:center">id_barbero</th>
                <th scope="col" style="text-align:center">id_usuario</th>
                <th scope="col" style="text-align:center">Nombre</th>
                <th scope="col" style="text-align:center">Apellido Paterno</th>
                <th scope="col" style="text-align:center">Apellido Materno</th>
                <th scope="col" style="text-align:center">Sexo</th>
                <th scope="col" style="text-align:center">Telefono</th>
                <th scope="col" style="text-align:center">Correo</th>
                <th scope="col" style="text-align:center">Username</th>
                <th scope="col" style="text-align:center">Tipo User</th>
                <th scope="col" style="text-align:center">años_trabajados</th>
                <th scope="col" style="text-align:center">fecha_ingreso</th>
                <th scope="col" style="text-align:center">Acciones</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_barberos)) { ?>
 
                <tr class="">
                    
       
                <td style="text-align:center"><?php echo $fila["id_barbero"];?> </td>
                <td style="text-align:center"><?php echo $fila["id_usuario"];?> </td>
                <td style="text-align:center"><?php echo $fila["nombre"];?> </td>
                <td style="text-align:center"><?php echo $fila["ApeP"];?> </td>
                <td style="text-align:center"><?php echo $fila["ApeM"];?> </td>
                <td style="text-align:center"><?php echo $fila["sexo"];?> </td>
                <td style="text-align:center"><?php echo $fila["telefono"];?> </td>
                <td style="text-align:center"><?php echo $fila["correo"];?> </td>
                <td style="text-align:center"><?php echo $fila["username"];?> </td>
                <td><?php 
                
                if($fila["tipo"]==1){
                    echo "Barbero";
                }
                ;?> </td>
               <td style="text-align: center;"><?php echo $fila["anios_trabajados"]; ?></td>
               <td style="text-align: center;"><?php echo $fila["fecha_ingreso"]; ?></td>
          

               


        
                    
                    <td>  
      
        <a name="" id="" class="btn btn-primary" href="editar.php?txtID=<?php echo $fila["id_usuario"];?>" role="button">Modificar</a>
        
        <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $fila["id_usuario"];?>" role="button">Eliminar</a>
        
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