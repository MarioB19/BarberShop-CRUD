<?php 
session_start();
if(!isset($_SESSION['username'])){
  header("Location:../../index.php");
}

include("templates/header.php"); 

?>


<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Barber Shop</h1>
      <p class="col-md-8 fs-4">Tu Barberia Favorita</p>
      <p2 class="col-md-8 fs-4">Cliente</p2>
      <?php  echo $_SESSION['username'];
      ?>
    
    </div>
  </div>


  <?php include("templates/footer.php");  ?>