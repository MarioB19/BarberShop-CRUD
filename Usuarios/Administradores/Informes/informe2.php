
<?php 

ob_clean(); // Limpiar el buffer de salida

session_start();
if(!isset($_SESSION['username'])){
  header("Location:../../index.php");
}

include("../conexion.php");
include("../templates/header.php"); 

// Incluir la librería TCPDF
include("PDF/TCPDF-main/tcpdf.php");

ob_clean(); // Limpiar el buffer de salida

// Crear un nuevo objeto TCPDF
$pdf = new TCPDF();

// Agregar una página al documento
$pdf->AddPage();

// Consulta SQL para recuperar los datos del informe
$sql = "SELECT id_usuario, nombre, ApeP, ApeM, sexo, telefono, correo, password, username, tipo FROM usuario";
$resultado = mysqli_query($conexion, $sql);

// Establecer el formato de la fuente
$pdf->SetFont('helvetica', '', 10);

// Escribir los encabezados del informe en el PDF


while ($fila = mysqli_fetch_assoc($resultado)) {
    $pdf->Write(0, "id_usuario :  \t");
    $pdf->Write(0, $fila['id_usuario'] . "" . "\n");
    $pdf->Write(0, "nombre : \t");
    $pdf->Write(0, $fila['nombre'] . "" . "\n");
    $pdf->Write(0, "ApeP :  \t");
    $pdf->Write(0, $fila['ApeP'] . "" ."\n");
    $pdf->Write(0, "ApeM : \t");
    $pdf->Write(0, $fila['ApeM'] . "" ."\n");
    $pdf->Write(0, "Sexo  : \t");
    $pdf->Write(0, $fila['sexo'] . "" ."\n");
    $pdf->Write(0, "Telefono :  \t");
    $pdf->Write(0, $fila['telefono'] . "" ."\n");
    $pdf->Write(0, "Correo :  \t");
    $pdf->Write(0, $fila['correo'] . "" ."\n");
    $pdf->Write(0, "Password : \t");
    $pdf->Write(0, $fila['password'] . "" ."\n");
    $pdf->Write(0, "Username :  \t");
    $pdf->Write(0, $fila['username'] . "" ."\n");
    $pdf->Write(0, "Tipo : \t");
    $pdf->Write(0, $fila['tipo'] . "" ."\n \n");
}




// Cerrar el archivo y liberar los recursos de MySQL
mysqli_free_result($resultado);

// Descargar el PDF
$pdf->Output('informe2.pdf', 'D');

Header("Location: index.php");

?>