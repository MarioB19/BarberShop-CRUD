<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel = "stylesheet" href = "libs/registro.css">


    <title>Registro de Usuario</title>
  </head>
  <body>
   
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
          <div class="card-img-left d-none d-md-flex">
            <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Registrarse</h5>
            <form action="registrar.php" method="POST">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="nombre" name = "nombre" placeholder="nombre" required autofocus>
                <label for="nombre">Nombre</label>
              </div>

            
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="ApeP" name ="ApeP" placeholder="ApeP" required autofocus>
                <label for="ApeP">Apellido Paterno</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="ApeM" name= "ApeM" placeholder="ApeM" required autofocus>
                <label for="ApeM">Apellido Materno</label>
              </div>



         
              <div class="form-group mb-3">
              <label for="sexo">Sexo</label>
              <select class="form-control" id="sexo" name="sexo">
        
              <option value="masculino">Masculino</option>
              <option value="femenino">Femenino</option>
             </select>
             </div>
 

              
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="telefono" name ="telefono"placeholder="telefono" required autofocus>
                <label for="telefono">Telefono</label>
              </div>


 
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username"placeholder="username" required autofocus>
                <label for="username">Username</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="correo" name="correo" placeholder="correo" required autofocus>
                <label for="correo">Correo Electronico</label>
              </div>


              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name = "password" placeholder="password" required autofocus>
                <label for="password">Password</label>
              </div>


              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Registrate</button>
              </div>

              <a class="d-block text-center mt-2 small" href="index.php">Si tienes una cuenta...Entra</a>

              <hr class="my-4">

              

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   
  </body>
</html>