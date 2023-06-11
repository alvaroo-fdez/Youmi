<?php
require_once 'Conexion.php';

function obtenerFoto($userId)
{
  // Conexión a la base de datos utilizando PDO
  $pdo = new Conexion();

  // Consulta para obtener la ruta de la foto del usuario
  $query = 'SELECT ruta FROM fotos WHERE id_usuario = :userId ORDER BY id ASC';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();

  // Obtener el resultado de la consulta
  $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

  // Cerrar la conexión a la base de datos
  $pdo = null;

  return $imagen;
}

$con = new Conexion();

// Obtener el ID del usuario logueado desde $_COOKIE['id']
$userId = $_COOKIE['id'];

// Consulta para obtener los matches del usuario logueado
$stmt = $con->prepare("SELECT p.* 
FROM perfiles p
INNER JOIN matches m ON p.id_usuario = m.user2_id
WHERE m.user1_id = :userId
UNION
SELECT p.* 
FROM perfiles p
INNER JOIN matches m ON p.id_usuario = m.user1_id
WHERE m.user2_id = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();

// Obtener los resultados como un array asociativo
$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener la foto de cada match del usuario logueado
$stmt2 = $con->prepare("SELECT ruta FROM fotos WHERE id_usuario = :userId ORDER BY id ASC");
$stmt2->bindParam(':userId', $userId);
$stmt2->execute();

foreach ($matches as &$match) {
  $ruta = obtenerFoto($match['id_usuario']);
  $match['ruta'] = $ruta['ruta'];
}

// Cerrar la conexión PDO
$con = null;

// Enviar los resultados como respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($matches);
