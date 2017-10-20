<?php
session_start();
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
require_once('fcs_mandy.php');

$esPost=$_SERVER["REQUEST_METHOD"]=="POST";
$email = '';
$password = '';
// $question='';
$answer='';

if ($esPost){

      $email = $_POST["email"];
      $password = $_POST["password"];
      // $question = $_POST["question"];
      $answer=$_POST["answer"];

      $erroresTotales=validacionRecuperarPass($_POST);
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
      var_dump($_POST);
      echo "<br>";

      var_dump($erroresTotales);
      $noError=empty($erroresTotales);


              if ($noError) {

                   //la funcion comprobarAnswer me devuelve al usuario
                   $usuario = comprobarUsuario($_POST["answer"]);
                   header('Location:test.php');
                  



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
           <? echo $erroresTotales['email']?>
         </span>
         </span>
       <?php endif; ?><br>

         <input type="password" class="password" name="password" placeholder="Contraseña"value="<?=$password?>" >
         <?php if (!empty($erroresTotales['password'])): ?>
             <span class="error"><span class="ion-close">
           <? echo $erroresTotales['password']?>
         </span>
         </span>
       <?php endif; ?><br>
       <h3 style="font-size:20px;"><?php echo"PREGUNTA DEL JSON";  ?></h3>

       <br>
       <input type="text" class="answer" name="answer" placeholder="Respuesta" value="">
       <?php if (!empty($erroresTotales['answer'])): ?>
         <span class="error"><span class="ion-close"> </span><?=$erroresTotales['answer'];?></span>
       <?php endif; ?>

         <br>





         <button class="boton-ingresar" type="submit" name="boton">Enviar</button>
         <button class="boton-registrate" type="reset" name="button">Reset</button>

       </form>

     </div>

   </body>
 </html>
