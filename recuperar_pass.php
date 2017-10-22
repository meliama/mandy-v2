<?php
session_start();

require_once('fcs_mandy.php');

$esPost=$_SERVER["REQUEST_METHOD"]=="POST";
$email = '';

//lo usamos para luego imprimir la pregunta seleccionada abajo en el form
$questions = [
  'q1'=>'¿Cuál es tu libro favorito?',
  'q2'=>'¿Cuál es el nombre de tu mascota?',
  'q3'=>'¿Cuál es tu artista favorito?',
  'q4'=>'¿Cuál es tu vanguardia favorita?',
  'q5'=>'¿Cuál es tu película favorita?',
  'q6'=>'¿Cuál es tu sueño?'
];

if ($esPost){
    $email=$_POST['email'];

//validarEmail me verifica y anda bien
  $erroresTotales = validarEmail($_POST);
//Me dice que si hay algo enviado por $email=$_POST['email'] ,me traiga al usuario
//asi despues, podemos traer la $questions seleccionada por el user mas abajo
  if (!empty($email)) {
    $usuario = comprobarEmail($email);
    }
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<br>";

      //Si no hay errores en el email, entonces le digo $noError
      //Abajo, esta es la condicion para que entre al if y me imprima
      //la $questions
      if (empty($erroresTotales)) {

        $noError="";
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
           <h3>¿Olvidaste tu contraseña?</h3>
       </div>

       <form class="form-login-registro" action="" method="post">

         <input type="text" class="email" name="email" placeholder="Correo electrónico"value="<?=$email?>" >
         <?php if (!empty($erroresTotales['email'])): ?>
             <span class="error"><span class="ion-close">
             <?=$erroresTotales['email'];?>
         </span>
         </span>
       <?php endif; ?>
       <button type="submit" name="button">buscar</button>
     </form>

    <form class="form-login-registro" action="" method="post">

       <?php if (isset($noError)): ?>
         <!-- ERROR: undefine index answer-->
         <!-- Me tira NULL, con mucho sentido porque no lo envie por $_POST todavia -->
        <?php $erroresAnswer = validarRespuesta($_POST['answer']);

        var_dump($erroresAnswer);

        ?>

       <p style="font-size:20px;"><?=$questions[$usuario['question']] ?></p>

       <br>
       <input type="text" class="answer" name="answer" placeholder="Respuesta" value="">
       <?php if (!empty($erroresAnswer['answer'])): ?>
         <span class="error"><span class="ion-close"> </span><?=$erroresAnswer['answer'];?></span>
       <?php endif; ?>
       <button class="boton-ingresar" type="submit" name="boton">Enviar</button>
       <button class="boton-registrate" type="reset" name="button">Reset</button>
     <?php endif; ?>

         <br>



       </form>

     </div>

   </body>
 </html>
