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
$sql = "SELECT id_cita, fecha_cita, hora_cita, estado, id_cliente, id_servicio, id_barbero, id_horario FROM agendar";
$resultado = mysqli_query($conexion, $sql);

// Establecer el formato de la fuente
$pdf->SetFont('helvetica', '', 10);

// Escribir los encabezados del informe en el PDF
$pdf->Write(0, "id_cita \t fecha_cita \t hora_cita \t estado \t id_cliente \t id_servicio \t id_barbero \t id_horario \n");

// Iterar sobre los resultados y escribirlos en el PDF
while ($fila = mysqli_fetch_assoc($resultado)) {
    $pdf->Write(0,"\n" . $fila['id_cita'] . "       ");
    $pdf->Write(0, $fila['fecha_cita'] . "     ");
    $pdf->Write(0, $fila['hora_cita'] . "         ");
    $pdf->Write(0, $fila['estado'] . "               ");
    $pdf->Write(0, $fila['id_cliente'] . "              ");
    $pdf->Write(0, $fila['id_servicio'] . "               ");
    $pdf->Write(0, $fila['id_barbero'] . "                  ");
    $pdf->Write(0, $fila['id_horario'] . "            ");
}

// Cerrar el archivo y liberar los recursos de MySQL
mysqli_free_result($resultado);

// Descargar el PDF
$pdf->Output('informe1.pdf', 'D');

Header("Location: index.php");

?>