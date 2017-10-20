<?php
session_start();

require_once('fcs_mandy.php');

if (isset($_SESSION['idUsuario'])){
  header('Location:index.html');
  exit;
}

$questions = [
  'q1'=>'¿Cuál es tu libro favorito?',
  'q2'=>'¿Cuál es el nombre de tu mascota?',
  'q3'=>'¿Cuál es tu artista favorito?',
  'q4'=>'¿Cuál es tu vanguardia favorita?',
  'q5'=>'¿Cuál es tu película favorita?',
  'q6'=>'¿Cuál es tu sueño?'
];
// initialize
$name = '';
$surname = '';
$username = '';
$email = '';
$question='';
$answer='';
$password = '';
$repass = '';

$esPost=$_SERVER["REQUEST_METHOD"]=="POST";

if ($esPost) {
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $question = $_POST["question"];
  $answer=$_POST["answer"];
  $password = $_POST["password"];
  $repass = $_POST["repass"];
  $img_profile = $_FILES["img_profile"];

  $erroresTotales=validar($_POST,$_FILES);

  if (count($erroresTotales) == 0) {

    $erroresTotales = guardarImagen('img_profile', $erroresTotales);
    if (count($erroresTotales) == 0) {
      crearUsuario($_POST);
      $usuario = comprobarUsuario($_POST["username"]);
      $_SESSION['idUsuario'] = $usuario['id'];
      header('location: index.html');
    }
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

  <div class="titulo-registro">
      <h3>Registro</h3>
  </div>

  <form class="form-login-registro" action="" method="post" enctype="multipart/form-data">
    <div class="input-container">
      <input type="text" name="name" class="name" placeholder="Nombre" value="<?=$name?>">
      <?php if (!empty($erroresTotales['name'])): ?>
        <span class="error"> <span class="ion-close"> </span><?=$erroresTotales['name'];?></span>
      <?php endif; ?>
    </div>

    <div class="input-container">
      <input type="text" name="surname" class="surname" placeholder="Apellido" value="<?=$surname?>" >
      <?php if (!empty($erroresTotales['surname'])): ?>
        <span class="error"><span class="ion-close"> </span><?=$erroresTotales['surname'];?></span>
      <?php endif; ?>
    </div>
    <br>

    <input type="text" class="user" name="username" placeholder="Usuario" value="<?=$username?>">
    <?php if (!empty($erroresTotales['username'])): ?>
      <span class="error"><span class="ion-close"> </span><?=$erroresTotales['username'];?></span>
    <?php endif; ?>
    <br>

    <input type="text" class="email" name="email" placeholder="Correo electrónico" value="<?=$email?>">
    <?php if (!empty($erroresTotales['email'])): ?>
      <span class="error"><span class="ion-close"> </span><?=$erroresTotales['email'];?></span>
    <?php endif; ?>
    <br>

      <select name="question" class="question">
        <option value="">Pregunta de seguridad</option>
      <?php foreach ($questions as $key=> $value) : ?>
        <?php if(isset($question) && $question == $key): ?>
      <option selected value="<?php echo $key; ?>"><?php echo $value; ?> </option>
        <?php else: ?>
      <option value="<?php echo $key;?>"><?php echo $value;?></option>
    <?php endif; ?>
      <?php endforeach ?>
  </select>

  <?php if (isset($erroresTotales['question'])): ?>
  <span class="error"><span class="ion-close"> </span><?=$erroresTotales['question'];?></span>
  <?php endif; ?>
  <br>

  <input type="text" class="answer" name="answer" placeholder="Respuesta" value="<?=$answer?>">
  <?php if (!empty($erroresTotales['answer'])): ?>
    <span class="error"><span class="ion-close"> </span><?=$erroresTotales['answer'];?></span>
  <?php endif; ?>

    <br>
    <input type="password" class="password" name="password" placeholder="Contraseña" value="<?=$password?>">
    <?php if (!empty($erroresTotales['password'])): ?>
      <span class="error"><span class="ion-close"> </span><?=$erroresTotales['password'];?></span>
    <?php endif; ?>
    <br>

    <input type="password" class="repass" name="repass" placeholder="Reingresar contraseña" value="<?=$repass?>">
    <?php if (!empty($erroresTotales['repass'])): ?>
      <span class="error"><span class="ion-close"> </span><?=$erroresTotales['repass'];?></span>
    <?php endif; ?>
    <br>


    <input type="file" name="img_profile" class="img_profile" >
    <?php if (!empty($erroresTotales['img_profile'])): ?>
      <span class="error"><span class="ion-close"> </span><?=$erroresTotales['img_profile'];?></span>
    <?php endif; ?>


    <button class="boton-registrarme" type="submit" name="button">Registrarme</button>

  </form>

  </body>
</html>
