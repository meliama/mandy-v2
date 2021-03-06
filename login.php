<?php
session_start();
require_once('fcs_mandy.php');
//esto agregue de COOKIES
if(isset($_COOKIE['idUsuario'])){
  $_SESSION['idUsuario']=$_COOKIE['idUsuario'];
}

if (isset($_SESSION['idUsuario'])){
  header('Location:index.html');
  exit;
}
$esPost=$_SERVER["REQUEST_METHOD"]=="POST";
$remember='';
if ($esPost){
   
   $erroresTotales = validacionLogin($_POST);

   $noErrores= empty($erroresTotales);

    if($noErrores){

      //la funcion comprobarEmail me devuelve al usuario
      $usuario = comprobarEmail($_POST["email"]);
      	// Guardo en $_SESSION el ID del USUARIO
      $_SESSION['idUsuario'] = $usuario['id'];


        if (isset($_POST["remember"])) {
            $time=time()+(60*60*24*365);
          setcookie('idUsuario', $usuario['id'],$time);


        }
<<<<<<< HEAD

=======
>>>>>>> 1439c4e37e564dbdec9941417faee5972872c7bb
      header('location: index.html');

      exit;
  }
}

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/ionicons-2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <title>Mandy.com - Compra arte independiente local</title>
  </head>
  <body>

    <!-- HEADER -->

		<header class="main-header">

			<input type="checkbox" id="open-nav">

			<label for="open-nav" class="toggle-nav">
				<span class="ion-navicon-round"></span>
			</label>

			<a href="index.html" class="logo-title">
				<h1>Mandy</h1>
			</a>

			<!-- NAV -->

			<nav class="main-nav">

				<label class="close-nav" for="open-nav">
					<span class="ion-chevron-left"></span>
				</label>

				<a href="#" class="shopping-bag sb-mobile">
					<span class="ion-bag"></span>
				</a>

				<ul>
					<li><a href="index.html">Inicio</a></li>
					<li><a href="#">Cómo funciona</a></li>
					<li><a href="#">Categorías</a></li>
					<li><a href="#">Servicios</a></li>
					<li><a href="faqs.html">FAQs</a></li>
				</ul>

				<span class="registro-mobile">
					<a href="login.php" class="log-in-mobile">Login</a>
					<a href="registro.php">
						¿Aún no tienes cuenta?<br><u>Regístrate.</u>
					</a>
				</span>

			</nav>

			<div class="icon-nav">

				<input type="checkbox" id="open-search">

				<div class="links-desktop">
					<a href="registro.php">Regístrate</a>
					<a href="login.php" class="log-in-desktop">Login</a>
				</div>

				<form action="" method="get" class="top-searchbar">
					<input type="text" name="top-searchbar" placeholder="¿Qué estás buscando?">
					<!-- <input type="submit" name="search" value="Ir"> -->
				</form>

				<label for="open-search" class="top-search">
						<span class="ion-search"></span>
				</label>

				<a href="#" class="shopping-bag sb-desktop">
					<span class="ion-bag"></span>
				</a>

			</div>

		</header>


    <div class="page-container login-registro-content">

      <div class="titulo-login">
          <h3>Login</h3>
      </div>

      <form class="form-login-registro" action="" method="post">

        <input type="text" class="email" name="email" placeholder="Correo electrónico" >


        <input type="password" class="password" name="password" placeholder="Contraseña" >

        <?php if (!empty($erroresTotales['email'])): ?>
            <span class="error"><span class="ion-close">
          <? echo $erroresTotales['email']?>
        </span>
        </span>
      <?php endif; ?><br>


        <div class="adicionales-login">
          <label class="recordarme">
            <input type="checkbox" name="remember" value="remember"> Recordarme
          </label>
          <a class="olvidar" href="recuperar_pass.php">¿Olvidó su contraseña?</a>
        </div>

        <button class="boton-ingresar" type="submit" name="boton">Ingresar</button>
        <button class="boton-registrate" type="button" name="button">Regístrate</button>

      </form>

    </div>

  </body>
</html>
