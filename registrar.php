<?php
include("bd.php");

$nombre = $_POST['nombre'];
$ApeP = $_POST['ApeP'];
$ApeM = $_POST['ApeM'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password2 = $_POST['password'];
$sexo = $_POST['sexo'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$sexo = ($sexo == "masculino") ? "H" : "M";
$tipo = 2;
$bandera = 1;

// Crear el trigger para verificar si el usuario ya existe
mysqli_query($conexion, "DROP TRIGGER IF EXISTS verificar_usuario_existente");
mysqli_query($conexion, "CREATE TRIGGER verificar_usuario_existente BEFORE INSERT ON usuario
    FOR EACH ROW
    BEGIN
        DECLARE usuario_existente INT;
        SELECT COUNT(*) INTO usuario_existente FROM usuario WHERE username = NEW.username;
        IF usuario_existente > 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El usuario ya existe';
        END IF;
    END;
");

try {
    // Insertar el nuevo usuario
    $sql = "INSERT INTO usuario(nombre, ApeP, ApeM, username, password, sexo, correo, telefono, tipo) VALUES(?,?,?,?,?,?,?,?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssss", $nombre, $ApeP, $ApeM, $username, $password, $sexo, $correo, $telefono, $tipo);
    $stmt->execute();

    $id = "SELECT id_usuario FROM usuario WHERE username = '$username'";
    $valor_id = mysqli_query($conexion, $id);

    $stmt = $conexion->prepare("INSERT INTO cliente(id_usuario) VALUES (?)");
    $stmt->bind_param("i", mysqli_fetch_array($valor_id)['id_usuario']);
    $stmt->execute();

    mysqli_query($conexion, "CREATE USER '$username'@'localhost' IDENTIFIED BY  '$password2'");

    // Eliminar el trigger
    mysqli_query($conexion, "DROP TRIGGER IF EXISTS verificar_usuario_existente");
} catch (Exception $e) {
    $mensaje_error = $e->getMessage();

    if ($mensaje_error == 'El usuario ya existe') {
        $bandera = 2;
    }


include("libs/header.php");
    ?>

    
    <div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold"><?php echo $mensaje_error;?></h1>
   

   
   

      <a name="" id="" class="btn btn-primary" href="registro.php" role="button">Volver</a> 
      
    
    </div>
  </div>

   

<?php



    


}

if ($bandera == 1) {

header("Location:index.php");
  }






?>