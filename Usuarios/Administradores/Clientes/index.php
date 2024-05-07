<?php 

session_start();
if(!isset($_SESSION['username'])){
  header("Location:../../../index.php");
}
include("../conexion.php");


$imprimir_clientes = mysqli_query($conexion,"SELECT cliente.id_cliente,usuario.id_usuario ,usuario.nombre , usuario.ApeP , usuario.ApeM,
usuario.sexo,usuario.telefono,usuario.correo , usuario.username,usuario.tipo
from usuario
INNER JOIN cliente on cliente.id_usuario = usuario.id_usuario
where usuario.tipo =2;
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




include("../templates/header.php");  ?>

<br/>
<h3> Clientes </h3>
<div class="card">
    <div class="card-header">
  
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Ingresar cliente</a>
    </div>
    <div class="card-body">
      
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id_cliente</th>
                    <th scope="col">id_usuario</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Username</th>
                    <th scope="col">Tipo User</th>
                    <th scope="col">Acciones</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($imprimir_clientes)) { ?>
 
                <tr class="">
                    
       
                <td scope="row"><?php echo $fila["id_cliente"];?> </td>
                <td><?php echo $fila["id_usuario"];?> </td>
                <td><?php echo $fila["nombre"];?> </td>
                <td><?php echo $fila["ApeP"];?> </td>
                <td><?php echo $fila["ApeM"];?> </td>
                <td><?php echo $fila["sexo"];?> </td>
                <td><?php echo $fila["telefono"];?> </td>
                <td><?php echo $fila["correo"];?> </td>
                <td><?php echo $fila["username"];?> </td>
                <td><?php 
                
                if($fila["tipo"]==2){
                    echo "Cliente";
                }
                ;?> </td>
                

               


        
                    
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