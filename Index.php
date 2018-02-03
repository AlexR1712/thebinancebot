<?php

  if (!empty($_POST['correo']) && !empty($_POST['clave'])) {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'testdb';
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $mensaje = '';

    mysql_connect($host, $user, $pass);
    mysql_select_db($db);

    $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND clave = '$clave'";

    $resultado = mysql_query($query);


    if (@mysql_num_rows($resultado)  >= 1) {
      session_start();
      $_SESSION["user"] = $correo;
      header("location:Bienvenido/index.php");
    }
    else {
      $mensaje = 'Verifique los datos ingresados e inténtelo de nuevo.';
    }
 
  }
?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="Images/1.png">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
  </head>

  <body>
<!--   <div class="container1">
    <label class="switch">
      <input type="checkbox" id="toogle" onclick="myFunction()" unchecked>
      <div class="slider round"></div>
    </label>
  </div>

  <script>
    function myFunction() {
      if (document.getElementById("toogle").checked) {
        document.body.style.backgroundColor = "#1E1E1E";
        document.body.style.color = "white";
    } else {
    document.body.style.backgroundColor = "white";
    document.body.style.color = "black";
      }
    }
  </script> -->
  <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="#">Static top</a></li>
              <li><a href="#">Fixed top</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

    </div> <!-- /container -->
  
      
      

<div class="container4">
   <div class="shortico">
      <div class="row">
        <img src="Images/Monsters.png" alt="logo" width="150">
          <?php
            if (!empty($mensaje)): ?>
              <div class="panel panel-default container3" id="warning">
                <div class="panel-body bg-danger">Verifique los datos ingresados e inténtelo de nuevo.</div>
              </div>
          <?php endif; ?>
         <h2 class="form-signin-heading">Iniciar sesión</h2>
         <form class="form-signin" action="index.php" method="POST">
            <input type="email" id="inputEmail" class="form-control login-label" placeholder="Correo" required autofocus name="correo">
            <input type="password" id="inputPassword" class="form-control login-label" placeholder="Contraseña" required name="clave">
            <button class="boton1 btn-lg btn-block" type="submit">Iniciar sesión</button><br>
            <input type="checkbox" value="remember-me" checked>Recordar</label>
            <div class="forgotLink">
               <a href="fake.html">¿Problema para iniciar sesión?</a>
            </div>
         </form>
         <form method="get" action="register.html">
            <button class="boton2 btn-lg btn-block" type="submit">Registrarse</button>
         </form>
      </div>
   </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>