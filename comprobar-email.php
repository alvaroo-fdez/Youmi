<?php
require_once 'Conexion.php';

// Obtener el correo electrónico enviado en la solicitud AJAX
$email = $_GET['email'];

try {
  $conn = new Conexion();
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Comprobar si el correo electrónico ya está registrado
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    // Si el correo electrónico ya está registrado, devolver "existe: true" como JSON
    $response = array('existe' => true);
    echo json_encode($response);
  } else {
    // Si el correo electrónico no está registrado, devolver "existe: false" como JSON
    $response = array('existe' => false);
    echo json_encode($response);
  }
}
catch(PDOException $e) {
  // Si hay un error al conectar a la base de datos, devolver un mensaje de error como JSON
  $response = array('error' => 'Error al conectar a la base de datos');
  echo json_encode($response);
}

// Cerrar la conexión a la base de datos
$conn = null;
?>