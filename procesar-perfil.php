<?php 

require_once 'Perfil.php';
require_once 'Conexion.php';

$id = $_COOKIE['id'];
$nombre = $_POST['nombre'];
$fechanacimiento = $_POST['fechanacimiento'];
$genero = $_POST['genero'];

$mostrar = $_POST['mostrar-genero'];

if(isset($mostrar)){
    $mostrargenero = 1;
}else{
    $mostrargenero = 0;
}

$generoamostrar = $_POST['muestrame-genero'];

$juegos = $_POST['juegos'];

//var_dump($juegos);



function obteneredad($fechaNacimiento)
{
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $diferencia = $fechaNacimiento->diff($fechaActual);
    return $diferencia->y;
}

$edad = obteneredad($fechanacimiento);
//var_dump($_POST['juegos']);

$perfil = new Perfil($id, $nombre, $edad, $genero, $generoamostrar,  $mostrargenero, $fechanacimiento);

if($perfil->creaPerfil()){
    $perfil->insertajuegos($juegos);
}
  
$con = new Conexion();

for ($i = 1; $i <= 6; $i++) {
  $inputName = "imagen{$i}";
  
  if (isset($_FILES[$inputName])) {
    $nombre_archivo = uniqid($id . '_', true) . '.' . pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
    $tipo_archivo = $_FILES[$inputName]['type'];
    $tamano_archivo = $_FILES[$inputName]['size'];
    $temp_archivo = $_FILES[$inputName]['tmp_name'];

    $ruta = "imagenes-usuarios/{$nombre_archivo}";

    if (comprobar_extension($nombre_archivo)) {
      move_uploaded_file($temp_archivo, $ruta);

      $stmt = $con->prepare("INSERT INTO fotos (id_usuario, ruta) VALUES (:idusuario, :ruta)");

      $stmt->bindParam(":idusuario", $id);
      $stmt->bindParam(":ruta", $ruta);

      $stmt->execute();
    }
  }
}



function comprobar_extension($nombre_archivo) {
    $extensiones_permitidas = array('jpg', 'jpeg', 'png');
    $extension = strtolower(substr(strrchr($nombre_archivo, '.'), 1));
    if (in_array($extension, $extensiones_permitidas)) {
        return true;
    } else {
        return false;
    }
}


?>