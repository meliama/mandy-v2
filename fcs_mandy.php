<?php
function validar($info,$file){
  $errores = [];
  $name = trim($info['name']);
  $surname = trim($info['surname']);
  $username = trim($info['username']);
  $email = trim($info['email']);
  $question = $info['question'];
  $answer = trim ($info['answer']);
  $pass = trim($info['password']);
  $repass = trim($info['repass']);
  $img_profile = $file['img_profile']['error'];
  if ($name == '') {
    $errores['name'] = 'Completá tu nombre';
  }elseif (! filter_var($info['name'],FILTER_VALIDATE_REGEXP, ["options"=>["regexp"=>'/^[a-zA-Z]+$/' ]]))
  {
     $errores['name'] = 'Solo letras permitidas';
  }elseif (strlen($info['name'])<2) {
    $errores['name'] = 'Mínimo 2 carateres';
  }
  if ($surname == '') {
    $errores['surname'] = 'Completá tu apellido';
  }elseif (!filter_var($info['surname'],FILTER_VALIDATE_REGEXP,
  ["options"=>["regexp"=>"/^[a-zA-Z]+$/" ]])){
    $errores['surname'] ='Solo letras permitidas';
  }elseif (strlen($info['surname'])<2) {
    $errores['surname'] ='Mínimo 2 carateres';
  }
  if ($username == '') {
    $errores['username'] = 'Completá tu nombre de usuario';
  }elseif (strlen($info['username'])<2) {
    $errores['username'] ='El nombre de usuario debe tener más de un carácter.';
  }
  elseif (comprobarUsuario($info['username']) != false) {
    $errores['username'] = 'Ya hay una cuenta asociada a este nombre de usuario';
  }
  if ($email == '') {
    $errores['email'] = 'Completá tu e-mail';
  } elseif (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'Usa el formato nombre@ejemplo.com';
  }
  elseif (comprobarEmail($info['email']) != false) {
    $errores['email'] = 'Ya hay una cuenta asociada con este e-mail';
  }
  if($question==''){
    $errores['question'] = 'Elegí una pregunta';
  }
  if($answer==''){
    $errores['answer']='Escribí una respuesta';
  }elseif (!filter_var($info['answer'],FILTER_VALIDATE_REGEXP,
  ["options"=>["regexp"=>"/^[a-zA-Z]+$/" ]])){
    $errores['answer'] ='El campo debe contener solo letras';
  }elseif (strlen($info['answer'])<2) {
    $errores['answer'] ='La respuesta debe tener más de un carácter.';
  }
  if ($pass == '') {
    $errores['password'] = 'Completá tu contraseña';
  }elseif (strlen($info['password'])<3) {
    $errores['password'] ='La contraseña debe tener más de 3 carácteres';
  }elseif (!filter_var($info['password'],FILTER_VALIDATE_REGEXP,
  ["options"=>["regexp"=>"/^[0-9a-zA-Z]+$/" ]])){
    $errores['password'] ='El campo debe contener solo letras o números';
  }
  if ($repass == '') {
    $errores['repass'] = 'Repetí tu contraseña';
  } elseif ($info['password'] != $info['repass']) {
    $errores['repass'] = 'Las contraseñas deben coincidir';
  }
  if ($file['img_profile']['error'] != UPLOAD_ERR_OK) {
    $errores['img_profile'] = 'Subí una imagen';
  }
  return $errores;
}
function crearUsuario($info){
  $usuarioAGuardar = [
      'id'=>generarId(),
      'name'=>$info['name'],
      'surname'=>$info['surname'],
      'username'=>$info['username'],
      'email'=>$info['email'],
      'question'=>$info['question'],
      'answer'=>$info['answer'],
      'password'=>password_hash($info['password'],PASSWORD_DEFAULT)
    ];
    $usuarioGuardado = json_encode($usuarioAGuardar);
    file_put_contents('todosUsuarios.json',$usuarioGuardado.PHP_EOL, FILE_APPEND);
}
function todosLosUsuarios(){
  $json = file_get_contents("todosUsuarios.json");
  $usuariosJSON = explode(PHP_EOL, $json);
  array_pop($usuariosJSON);
  $usuariosTodos = [];
  foreach ($usuariosJSON as $usuario) {
    $usuariosTodos[] = json_decode($usuario, true);
  }
  return $usuariosTodos;
}
function generarId(){
        $todosUsuarios = todosLosUsuarios();
        var_dump($todosUsuarios);
        if (count($todosUsuarios) == 0) {
          return 1;
        }
        $elUltimoUsuario = end($todosUsuarios);
        $id = $elUltimoUsuario['id'];
        return $id + 1 ;
    }
function comprobarEmail($email){
 $usuarios = todosLosUsuarios();
 for ($i=0; $i < count($usuarios) ; $i++) {
   if ($usuarios[$i]['email'] == $email) {
     return $usuarios[$i];
   }
 }
 return false;
}
function comprobarUsuario($username){
 $usuarios = todosLosUsuarios();
 for ($i=0; $i < count($usuarios) ; $i++) {
   if ($usuarios[$i]['username'] == $username) {
     return $usuarios[$i];
   }
 }
 return false;
}
function guardarImagen($img_profile,$errores){
    $img_profile= $_FILES[$img_profile];
    $noError=$img_profile['error'] == UPLOAD_ERR_OK;
    $posibles_errores['img_profile']=[
      'No aceptamos éste formato.Probá a guardarla como jpg,jpeg,png o gif',
      'Error'.$img_profile['error'].'Intentá de nuevo.',
    ];
    if ($noError) {
     $name=$img_profile['name'];
     $ext=pathinfo($name,PATHINFO_EXTENSION);
     $file=$img_profile['tmp_name'];
     $ext_ok=($ext='jpg'or $ext='JPG' or $ext='JPEG' or $ext='jpeg' or $ext='png' or $ext='PNG' or $ext='gif' or $ext='GIF');
     if ($ext_ok) {
       $name_file = $_POST['username'] . '.' .$ext;
       $rutaDelArchivo=dirname(__FILE__) . '/images/img_profile/' . $name_file;
       $img_to_upload=move_uploaded_file($file,$rutaDelArchivo);
     } else {
       $errores['img_profile']=$posibles_errores['img_profile'][0];
     }
   } else {
     $errores['img_profile']=$posibles_errores['img_profile'][1];
   }
   return $errores;
 }
 function validacionLogin($info){
    $errores = [];
    $posibles_errores['email']=[
    "Completá tu e-mail",
    "Usa el formato nombre@ejemplo.com",
    "Éste email no tiene cuenta asociada.",
    "Email o contraseña incorrectos."];
    $email_limpio=trim($info['email']);
    $formato_email=filter_var($info['email'], FILTER_VALIDATE_EMAIL);
    $email=$info['email'];
    $pass_limpia=trim($info['password']);
// esto no se si ponerlo  no ...
   if ($pass_limpia == '') {
      $errores['email'] = 'Completá tu contraseña';
    }
  if ($email_limpio == '') {
     $errores['email']=$posibles_errores['email'][0];
  }
  elseif (!$formato_email) {
     $errores['email']=$posibles_errores['email'][1];
  }
  elseif( comprobarEmail($email) == false){
     $errores['email']=$posibles_errores['email'][2];
  }else {
    $elUsuario=comprobarEmail($email);
    $password=$elUsuario['password'];
    $password_ingresada=$info['password'];
    if (password_verify($password_ingresada, $password) == false) {
      //en realidad ya sabemos que es que la contrasena es incorrecta
       $errores['email']=$posibles_errores['email'][3];
    }
  }
  return $errores;
}
function comprobarAnswer($answer){
 $answers = todosLosUsuarios();
 for ($i=0; $i < count($answers) ; $i++) {
   if ($answers[$i]['answer'] == $answer) {
     return $answers[$i];
   }
 }
 return false;
}
function validarRespuesta($info){
    $answer = trim($info['answer']);
    $errores = [];
    if($answer==''){
      $errores['answer']='Escribí una respuesta';
    }else{
      $elUsuario=comprobarAnswer($answer);
      $answer_guardada=$elUsuario['answer'];
      $answer_ingresada=$info['answer'];
      if( $answer_ingresada !== $answer_guardada) {
         $errores['answer']='Respuesta incorrecta.';
      }
    }
}
function validarEmail($info){
  $errores = [];
  $email_limpio = trim($info['email']);
  $email=$info['email'];
  if ($email_limpio == '') {
    $errores['email'] = 'Completá tu email';
  } elseif (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'Usa el formato nombre@ejemplo.com';
  }elseif(comprobarEmail($email) == false){
     $errores['email']='E-mail incorrecto.';
  }
  return $errores;
}
 ?>
