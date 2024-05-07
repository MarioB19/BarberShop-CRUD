
<?php 
$url_base = "http://localhost/BarberShop/Usuarios/Administradores/index";
?>

<!doctype html>
<html lang="en">

<head>
  <title>BarberShop</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>


  <nav class="navbar navbar-expand navbar-light bg-light">
      <ul class="nav navbar-nav">
          <li class="nav-item">
              <a class="nav-link active" href="<?php echo $url_base;?>/../index.php" aria-current="page">Sistema <span class="visually-hidden">(current)</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href= "<?php echo $url_base;?>/../Empleados/">Empleado</a>
          </li>
        
          <li class="nav-item">
              <a class="nav-link" href="<?php echo $url_base;?>/../Clientes/">Clientes</a>
          </li>
      
          <li class="nav-item">
              <a class="nav-link" href= "<?php echo $url_base;?>/../Citas/">Citas</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo $url_base;?>/../Horarios/">Horarios</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo $url_base;?>/../Servicios/">Servicios</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo $url_base;?>/../Informes/">Informes</a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="<?php echo $url_base;?> /../../../login/logout.php">Cerrar Sesion</a>
          </li>
      </ul>
  </nav>


  <main class = "container">